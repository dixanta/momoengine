<?php

class Slideshow
{
	var $CI;	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
	}

	//back end installation functions
	function install()
	{
		
		$config['slideshow_module'] = '';

		$this->CI->settings_model->save('slideshow', $config);
	}
	
	function uninstall()
	{
		$this->CI->settings_model->delete('slideshow');
	}	

	//admin end form and check functions
	function form($post	= false)
	{
		//this same function processes the form
		if(!$post)
		{
			$settings	= $this->CI->settings_model->get('slideshow');
		}
		else
		{

			$settings = $post;
		}

		$data['settings']=$settings;
		$data['modules']=array();
		//$data['layouts'] = $this->CI->Layout_model->get_layouts();
		if(!empty($settings['slideshow_module']))
		{
			$data['modules']=@unserialize($settings['slideshow_module']);
		}
	
		//retrieve form contents
		return $this->CI->load->view('form',$data, true);
	}	

	function check()
	{	
		$error	= false;
		
		// The only value that matters is currency code.
		//if ( empty($_POST['']) )
			//$error = "<div>You must enter a valid currency code</div>";
					
		//count the errors
		if($error)
		{
			return $error;
		}
		else
		{
			$this->CI->settings_model->save('slideshow', array('slideshow_module'=>serialize($_POST['slideshow_module'])));
			return false;
		}
	}
	
	function view($settings)
	{
		$data=array();
		return $this->CI->load->view('slideshow',$data,TRUE);
	}	
}