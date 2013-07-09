<?php
function easyui_settings($key)
{
	$combo_settings['AREA']=array('url'=>site_url('area/admin/area/combo_json'),
								'valueField'=>'area_id',
								'textField'=>'area_name'
							);
	$combo_settings['BLOG_CATEGORY']=array('url'=>site_url('blog/admin/category/combo_json'),
								'valueField'=>'blogcategory_id',
								'textField'=>'blogcategory_name'
							);	
	$combo_settings['SHOP']=array('url'=>site_url('shop/admin/shop/combo_json'),
								'valueField'=>'shop_id',
								'textField'=>'shop_name'
							);
	$combo_settings['SERVICE_TYPE']=array('url'=>site_url('service/admin/type/combo_json'),
								'valueField'=>'service_type_id',
								'textField'=>'name'
							);		

	$combo_settings['RESOURCE_CATEGORY']=array('url'=>site_url('resource/admin/category/combo_json'),
										'valueField'=>'category_id',
										'textField'=>'category_name'
								);
	
	return $combo_settings[$key];						
}

function easyui_combobox($obj,$key,$options=array())
{
		$combo_settings=easyui_settings($key);
	if(!empty($options))
	{

		$combo_settings=array_merge($combo_settings, $options);
	}

?>		
	$('#<?=$obj?>').combobox(<?=json_encode($combo_settings)?>);		
<?php		
}

function easyui_combobox_localdata($obj,$key,$data)
{
	$combo_settings=easyui_settings($key);
?>		
	$('#<?=$obj?>').combobox({
			data:<?php echo $data?>,
			valueField:'<?=$combo_settings['valueField']?>',
			textField:'<?=$combo_settings['textField']?>'
	});		
<?php		
}

function ckeditor($obj,$config=array())
{
?>

			var config = {
            toolbar : 'Full',
			skin:'office2003',
			language: 'ja',
            height:300,
            width:800,
            filebrowserBrowseUrl:CKEDITOR.basePath +'plugins/filemanager/index.html',
            filebrowserImageBrowseUrl :CKEDITOR.basePath +'plugins/filemanager/index.html?type=Images',
            filebrowserFlashBrowseUrl : CKEDITOR.basePath +'plugins/filemanager/index.html?Type=Flash',
			};
            <?
				if(!empty($config))
				{
					echo 'config='.json_encode($config).';';		
				}	
			?>
            $('<?php echo $obj?>').ckeditor(config);  
<?php	
}

function tinymce($obj,$config=array())
	{
?>
		$('#<?=$obj?>').tinymce({
			script_url : '<?=base_url()?>assets/js/tinymce/tiny_mce.js',
            mode: 'exact',
            skin : "o2k7",
            <? if(empty($config['theme'])){
				echo "theme : 'advanced',";
			}
			?>
            plugins : "advimage,advlink,media,contextmenu,",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			//content_css : "css/content.css",
            relative_urls : false,
            convert_urls : false,
			// Drop lists for link/image/media/template dialogs
			//template_external_list_url : "lists/template_list.js",
			//external_link_list_url : "lists/link_list.js",
			//external_image_list_url : "lists/image_list.js",
			//media_external_list_url : "lists/media_list.js",
			<?php
            if( check('Control Panel',NULL,FALSE) )
			{
				if(empty($config['no_filemanager'])){
            ?>
            
            //file_browser_callback : "ajaxfilemanager",
            <?php
				}
			}
			?>
			// Theme options
			//theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			//theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			//theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			
			
			//theme_advanced_statusbar_location : "bottom",*/
            
		});
        
  
<?php		
	}	