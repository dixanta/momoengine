<?php

function set_upload_path($module)
{
	$path="protected \$uploadPath = 'uploads/".$module."';\r\n";
	$path.="protected \$uploadthumbpath= 'uploads/".$module."/thumb/';\r\n";
	return $path;
}

function datewise()
{
	$str="
	private function _datewise(\$field,\$from,\$to)
	{
			if(!empty(\$from) && !empty(\$to))
			{
				\$this->db->where(\"(date_format(\".\$field.\",'%Y-%m-%d') between '\".date('Y-m-d',strtotime(\$from)).
						\"' and '\".date('Y-m-d',strtotime(\$to)).\"')\");
			}
			else if(!empty(\$from))
			{
				\$this->db->like(\$field,date('Y-m-d',strtotime(\$from)));				
			}		
	}";
	return $str;
}

function upload_controller_method()
{
	$CI=&get_instance();
	return $CI->load->view('templates/codes/c_upload',NULL,TRUE);
}

function view_upload_code($module,$field)
{
	$CI=&get_instance();
	$data=array('PHP_START'=>'<?php ','PHP_END'=>'?>','MODULE'=>$module,'FIELD'=>$field);
	return $CI->parser->parse('templates/codes/v_upload',$data,TRUE);
}


