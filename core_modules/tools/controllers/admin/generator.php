<?php
class Generator extends Admin_Controller
{
	var $table_name='';
	var $prefix;
	var $table_columns=NULL;
	var $module_path='modules';
	var $module_name;
	var $languages=array();

	var $discard=array();
	public function __construct()
	{
		parent::__construct();
		set_time_limit(0);
	}
	
	public function index()
	{
		$data['header']='Module Generator';
		$data['page']= $this->config->item('template_admin') .'generator/index';
		$data['module']='tools';
		$tables=array();
		$core_tables=$this->_get_core_tables();
		foreach($this->db->list_tables() as $table):
			if(!in_array($table,$core_tables))
			{
				array_push($tables,$table);
			}
		endforeach;
		$data['tables']=$tables;
		$this->load->view($this->_container,$data);				
	}
	
	private function _get_core_tables()
	{
		$tables[]='be_acl_actions';
		$tables[]='be_acl_groups';
		$tables[]='be_acl_permission_actions';
		$tables[]='be_acl_permissions';
		$tables[]='be_acl_resources';
		$tables[]='be_groups';
		$tables[]='be_acl_actions';
		$tables[]='be_preferences';
		$tables[]='be_resources';
		$tables[]='be_shortcuts';
		$tables[]='be_user_profiles';
		$tables[]='be_users';	
		$tables[]='be_backups';	
		$tables[]='ci_sessions';	
		$tables[]='layouts';	
		$tables[]='pages';	
		$tables[]='settings';	
		$tables[]='slugs';										
		return $tables;
		
	}
	
	private function _get_primary_key()
	{
		foreach($this->table_columns as $column)
		{
			if($column->primary_key)
			{
				return $column->name;
			}
		}
	}
	public function generate()
	{
		$this->load->library('parser');
		$this->load->helper('inflector');	
		$this->load->helper('file');
		$this->load->module_helper('tools','code_snippet');		
		
		$data['module']='tools';
		$this->prefix=trim($this->input->post('prefix'));	
		$this->discard=explode(',',$this->input->post('discard'));
		foreach($this->input->post('tables') as $table):		
		
		$this->table_name=preg_replace('/'.$this->prefix.'/','',$table,1);

		$this->table_columns= $this->db->field_data($table);	
		//echo '<pre>';
		//print_r($this->table_columns);exit;

		$this->function_init=str_replace(' ','',humanize(plural(ucfirst($this->table_name))));	
		$this->table_key=singular(strtoupper($this->table_name));
		$controller=ucfirst(singular($this->table_name));
		$this->module_name=strtolower($controller);
		$this->_create_directories();
		


		$this->_generate_model_file($this->module_name);
		$this->_generate_language_file($this->module_name);
		$this->_generate_controller_file($this->module_name);	
		$this->_generate_api_controller_file($this->module_name);			

		$primary_key=$this->_get_primary_key();	
		$upload_view_function='';
		foreach($this->table_columns as $row):

			if(preg_match('/image/',$row->name,$match))
			{
				$upload_view_function=view_upload_code($this->module_name,$row->name);
						
			}
			
		endforeach;
			
		$view_array=array('PHP_START'=>'<?php ','PHP_END'=>'?>','VIEWTABLE'=>$this->module_name,'TABLE_FIELDS'=>$this->_generate_view_fields($this->table_columns),'PRIMARY_KEY'=>$primary_key,
						  'FORMFIELDS'=>$this->_generate_form_fields($this->table_columns,$primary_key),'SEARCH_FIELDS'=>$this->_generate_search_fields($this->table_columns),
						  'UPLOAD_VIEW_FUNCTION'=>$upload_view_function,'TABLE_NAME'=>strtolower($this->module_name));
		
		$view_data=$this->parser->parse('templates/view.tpl',$view_array,TRUE);
		
		$view_final_path=$this->view_admin_directory.$this->module_name.'/';
		@mkdir($view_final_path);
		$view_file=$view_final_path.'index.php';
		write_file($view_file,$view_data);
		echo $view_file . ' View generated<br/>';
	

		endforeach;
	}

	private function _generate_controller_file($file)
	{
		
		$upload_path='';
		$upload_function='';	
		$upload_view_function='';
		$datewise_function='';
		
		foreach($this->table_columns as $row):

			if(preg_match('/image/',$row->name,$match))
			{
				$upload_path=set_upload_path($file);	
				$upload_function=upload_controller_method();	
				$upload_view_function=view_upload_code($file,$row->name);
						
			}
			else if(preg_match('/date/',$row->name,$match))
			{
				$datewise_function=datewise();
			}
			
		endforeach;
				
		$primary_key=$this->_get_primary_key();		
		$controller=ucfirst(singular($this->table_name));
		$controller_array=array('PHP_TAG'=>'<?php','CONTROLLER'=>$controller,'MODULE'=>$this->module_name,'PRIMARY_KEY'=>$primary_key,'FOLDER'=>$file,
								'MODEL'=>$file."_model",'TABLE_NAME'=>$this->function_init,'LANG'=>$file,
								'POSTED_DATA'=>$this->_generate_posted_data($this->table_columns),'TABLE_KEY'=>$this->table_key,
								'UPLOAD_PATH'=>$upload_path,'UPLOAD_FUNCTION'=>$upload_function,'SEARCH_PARAMS'=>$this->_generate_search_params($this->table_columns),'DATE_SEARCH_PARAMS'=>$this->_generate_date_search_params($this->table_columns),'DATEWISE_FUNCTION'=>$datewise_function);

		$controller_data=$this->parser->parse('templates/controller.tpl',$controller_array,TRUE);
		
		$controller_file=$this->controller_admin_directory.$file.'.php';
		write_file($controller_file,$controller_data);
		echo $controller_file . ' controller generated<br/>';			
	}
	
	private function _generate_api_controller_file($file)
	{

				
		//$primary_key=$this->_get_primary_key();		
		$controller=ucfirst(singular($this->table_name));
		$controller_array=array('PHP_TAG'=>'<?php','MODULE'=>$this->module_name,
								'MODEL'=>$file."_model",'TABLE_NAME'=>$this->function_init);

		$controller_data=$this->parser->parse('templates/api_controller.tpl',$controller_array,TRUE);
		
		$controller_file=$this->controller_directory.'api.php';
		write_file($controller_file,$controller_data);
		echo $controller_file . ' API controller generated<br/>';			
	}	
	
	private function _create_directories()
	{
		$module_directory=$this->module_path.'/'.$this->module_name;
		@mkdir($module_directory); // Create Main Module Directory
		
		$this->model_directory=$module_directory.'/models/';
		$this->language_directory=$module_directory.'/language/';
	
		$this->controller_directory=$module_directory.'/controllers/';
		$this->controller_admin_directory=$this->controller_directory.'admin/';
	
		$this->view_directory=$module_directory.'/views/';
		$this->view_admin_directory=$this->view_directory.'admin/';
		
		@mkdir($this->controller_directory); //Create Controller Folder				
		@mkdir($this->controller_admin_directory); //Create Controller Folder				

		@mkdir($this->model_directory); // Create Model Folder
		@mkdir($this->language_directory);	// Create Language Folder	
		@mkdir($this->view_directory);	// Create View Folder					
		@mkdir($this->view_admin_directory);	// Create Admin View Folder			


		$this->languages=$this->input->post('language');
		$other_language=$this->input->post('other_language');
		if($other_language)
		{
			$other=explode(',',$other_language);
			$this->languages=array_merge($this->languages,$other);
		}
		
		foreach($this->languages as $lang):
			$language_path=$this->language_directory.$lang.'/';
			@mkdir($language_path);	// Create language Folder	
		endforeach;		
				
	}	
	
	private function _generate_model_file($file)
	{
		
			
		$table_array=array('PHP_TAG'=>'<?php','MODEL'=>ucfirst($file),'TABLE_KEY'=>$this->table_key,'TABLE_NAME'=>$this->table_name,
							'FUNCTION_INIT'=>$this->function_init,'PREFIX'=>$this->prefix,'TABLE_ALIAS'=>plural($this->table_name));
		
		$model_data=$this->parser->parse('templates/model.tpl',$table_array,TRUE);
		$model_file=$this->model_directory.$file.'_model.php';
		write_file($model_file,$model_data);
		echo $model_file . ' Model generated<br/>';		
	}
	
	
	private function _generate_language_file($file)
	{
		$file_name=ucfirst(singular($this->table_name));
		$lang=$this->_generate_language_fields($this->table_columns);
		$lang_array=array('PHP_TAG'=>'<?php','LANG'=>$lang,'TABLE_NAME'=>$file,'CAP_TABLE_NAME'=>humanize($file_name));
		$lang_data=$this->parser->parse('templates/language.tpl',$lang_array,TRUE);
		
		/*$languages=$this->input->post('language');
		$other_language=$this->input->post('other_language');
		if($other_language)
		{
			$other=explode(',',$other_language);
			$languages=array_merge($languages,$other);
		}*/
		
		foreach($this->languages as $lang):
		
			$new_lang_path=$this->language_directory.trim($lang).'/'; 
			
			$lang_file=$new_lang_path.$file.'_lang.php';
			write_file($lang_file,$lang_data);
			echo $lang_file . ' language generated<br/>';
		endforeach;			
				
	}

	
	private function _generate_language_fields($fields)
	{

		$lang='';
		foreach($fields as $field):
			$lang=$lang."\$lang['".$field->name."'] = '".humanize($field->name)."';\r\n";
		endforeach;
		return $lang;
	}
	
	private function _generate_posted_data($fields)
	{
		
		$cols='';
		foreach($fields as $row):
			if(($this->input->post('discard_post') && !in_array($row->name,$this->discard)) || (in_array($row->name,$this->discard) && !$this->input->post('discard_post')) || (!$this->input->post('discard_post') && !in_array($row->name,$this->discard))) 
				$cols=$cols."\$data['".$row->name."'] = \$this->input->post('".$row->name."');\r\n";
			
		endforeach;
		return $cols;
		
	}
	
	private function _generate_search_params($fields)
	{
		$cols='';
		foreach($fields as $row):
			if($row->primary_key!='1' && !in_array($row->name,$this->discard))
			{
				
				if(!preg_match('/text/is',$row->type,$match) && !preg_match('/image/is',$row->name,$match))
				{
					if(preg_match('/tinyint/',$row->type,$match)){
						$cols=$cols."(isset(\$params['search']['".$row->name."']))?\$this->db->where('".$row->name."',\$params['search']['".$row->name."']):'';\r\n";		
					}
					else if(preg_match('/int/',$row->type,$match)){
					$cols=$cols."(\$params['search']['".$row->name."']!='')?\$this->db->where('".$row->name."',\$params['search']['".$row->name."']):'';\r\n";						
					}
					else if(!preg_match('/date/',$row->type,$match)){
					$cols=$cols."(\$params['search']['".$row->name."']!='')?\$this->db->like('".$row->name."',\$params['search']['".$row->name."']):'';\r\n";
					}
					
				}
			}
		endforeach;
		
		return $cols;	
		
	}	
	
	private function _generate_date_search_params($fields)
	{
		$str="if(!empty(\$params['date']))
		{
			foreach(\$params['date'] as \$key=>\$value){
				\$this->_datewise(\$key,\$value['from'],\$value['to']);	
			}
		}";
		
		return $str;	
		
	}	
	
	private function _generate_view_fields($fields)
	{
		$cols='';
		//echo '<pre>';
		//print_r($fields);
		//exit;
		foreach($fields as $row):
			if(($this->input->post('discard_grid') && !in_array($row->name,$this->discard)) || (in_array($row->name,$this->discard) && !$this->input->post('discard_grid')) || (!$this->input->post('discard_grid') && !in_array($row->name,$this->discard))) 
			{
				if(strpos($row->name,'status')!==FALSE ||strpos($row->name,'active')!==FALSE)
				{
				$cols=$cols."<th data-options=\"field:'".$row->name."',sortable:true,formatter:formatStatus\" width=\"30\" align=\"center\"><?php echo lang('".$row->name."')?></th>\r\n";
					
				}
				else
				{
					if($row->primary_key=='1')
					{
						$cols=$cols."<th data-options=\"field:'".$row->name."',sortable:true\" width=\"30\"><?php echo lang('".$row->name."')?></th>\r\n";
						
					}
					else if(!preg_match('/text/is',$row->type,$match))
					{
						$cols=$cols."<th data-options=\"field:'".$row->name."',sortable:true\" width=\"50\"><?php echo lang('".$row->name."')?></th>\r\n";
					}
				}
			}
		endforeach;
		return $cols;
		
	}	
	
	private function _generate_search_fields($fields)
	{
		

		
//		 && (in_array($row->name,$this->discard) && $this->input->post('discard_search'))
		$cols='<tr>';
		$i=2;
		foreach($fields as $row):
			if($row->primary_key!='1' )
			{
				if(($this->input->post('discard_search') && !in_array($row->name,$this->discard)) || (in_array($row->name,$this->discard) && !$this->input->post('discard_search')) || (!$this->input->post('discard_search') && !in_array($row->name,$this->discard))) 
			{
				
					if(!preg_match('/text/is',$row->type,$match) && !preg_match('/image/is',$row->name,$match))
					{
						$cols=$cols."<td><label><?php echo lang('".$row->name."')?></label>:</td>\r\n";
						if(preg_match('/date/',$row->type,$match)){
							$cols=$cols."<td><input type=\"text\" name=\"date[".$row->name."][from]\" id=\"search_".$row->name."_from\"  class=\"easyui-datebox\"/> ~ <input type=\"text\" name=\"date[".$row->name."][to]\" id=\"search_".$row->name."_to\"  class=\"easyui-datebox\"/></td>\r\n";							
						}
						else if(!preg_match('/tinyint/',$row->type,$match)){
							$cols=$cols."<td><input type=\"text\" name=\"search[".$row->name."]\" id=\"search_".$row->name."\"  class=\"".$this->_field_class($row->type)."\"/></td>\r\n";	
						}
						else
						{
							$cols=$cols."<td><input type=\"radio\" name=\"search[".$row->name."]\" id=\"search_".$row->name."1\" value=\"1\"/><?php echo lang('general_yes')?>
									<input type=\"radio\" name=\"search[".$row->name."]\" id=\"search_".$row->name."0\" value=\"0\"/><?php echo lang('general_no')?></td>\r\n";	
	
	
						}
					if(($i%4)==0)
					{
						$cols=$cols."</tr>\r\n<tr>\r\n";
					}
					echo $i=$i+2;	
	
					}
				
			}
			} // if ! primary key
		endforeach;
		$cols=$cols.'</tr>';	
		return $cols;	
	}

	
	private function _generate_form_fields($fields,$primary_key)
	{
		$cols='';

		foreach($fields as $row):
		if($row->name!=$primary_key):
		
		if(($this->input->post('discard_form') && !in_array($row->name,$this->discard)) || (in_array($row->name,$this->discard) && !$this->input->post('discard_form')) || (!$this->input->post('discard_form') && !in_array($row->name,$this->discard))) 
			{
	
	
         $cols=$cols.'<tr>
		              <td width="34%" ><label><?php echo lang(\'%%FIELD%%\')?>:</label></td>
					  <td width="66%">';
			
			$field=	'<input name="%%FIELD%%" id="%%FIELD%%" class="'.$this->_field_class($row->type).'" required="true">';
			
			
			if(preg_match('/image/',$row->name,$match))
			{
				$field=	'<label id="upload_image_name" style="display:none"></label>
                      <input name="%%FIELD%%" id="%%FIELD%%" type="text" style="display:none"/>
                      <input type="file" id="upload_image" name="userfile" style="display:block"/>
                      <a href="#" id="change-image" title="Delete" style="display:none"><img src="<?=base_url()?>assets/icons/delete.png" border="0"/></a>';	
			}
			if(preg_match('/text/',$row->type,$match))
			{
				$field='<textarea name="%%FIELD%%" id="%%FIELD%%" class="'.$this->_field_class($row->type).'" required="true" style="width:300px;height:100px"></textarea>';
			}
			elseif(preg_match('/tinyint/',$row->type,$match))
			{
				$field=	'<input type="radio" value="1" name="%%FIELD%%" id="%%FIELD%%1" /><?php echo lang("general_yes")?> <input type="radio" value="0" name="%%FIELD%%" id="%%FIELD%%0" /><?php echo lang("general_no")?>';				
			}
			
			$cols.=$field;
				
			
		$cols.='</td>
		       </tr>';    	
		$cols=str_replace('%%FIELD%%',$row->name,$cols);
			}
		endif;
		endforeach;
		$cols=$cols.'<input type="hidden" name="'.$primary_key.'" id="'.$primary_key.'"/>';
		
		return $cols;		
	}		

	private function _field_class($type)
	{
		$class='easyui-validatebox';
		if($type=='datetime')
		{
			$class='easyui-datetimebox';
		}
		elseif($type=='date')
		{
			$class='easyui-datebox';
		}		
		elseif(preg_match('/int/is',$type,$matches))
		{
			$class='easyui-numberbox';
		}
		
		return $class;
	}	
	
	function test()
	{
		$this->load->module_helper('tools','code_snippet');		
		$this->load->library('parser');		
		view_upload_code('news','image');
	}
}