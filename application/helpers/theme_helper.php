<?php

function theme_css($file_name)
{
	$CI=&get_instance();
	$css_path='themes/'.$CI->config->item('theme').'/assets/css/' ;
	return '<link href="'.base_url().$css_path.$file_name.'" rel="stylesheet">';
}


function theme_js($file_name)
{
	$CI=&get_instance();
	$js_path='themes/'.$CI->config->item('theme').'/assets/js/' ;
	return '<script src="'.base_url().$js_path.$file_name.'"></script>';
}

function theme_img($file_name)
{
	$CI=&get_instance();
	$image_path='themes/'.$CI->config->item('theme').'/assets/images/' ;
	return base_url().$image_path.$file_name;
}