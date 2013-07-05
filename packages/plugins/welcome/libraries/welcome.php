<?php

class Welcome
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
		
		$config['welcome_module'] = '';
		$config['welcome_text'] = '';

		$this->CI->settings_model->save('welcome', $config);
	}
	
	function uninstall()
	{
		$this->CI->settings_model->delete('welcome');
	}	

	//admin end form and check functions
	function form($post	= false)
	{
		$this->CI->bep_assets->load_asset('tinymce');
		//this same function processes the form
		if(!$post)
		{
			$settings	= $this->CI->settings_model->get('welcome');
		}
		else
		{

			$settings = $post;
		}

		$data['settings']=$settings;
		$data['modules']=array();

		if(!empty($settings['welcome_module']))
		{
			$data['modules']=@unserialize($settings['welcome_module']);
		}
	
		//retrieve form contents
		return $this->CI->load->view('form',$data, true);
	}	

	function check()
	{	
		$error	= false;
		if($error)
		{
			return $error;
		}
		else
		{
			$this->CI->settings_model->save('welcome', array('welcome_module'=>serialize($_POST['welcome_module'])));
			$this->CI->settings_model->save('welcome', array('welcome_text'=>$_POST['welcome_text']));							
			return false;
		}
	}
	
	function view($settings)
	{
		$welcome= $this->CI->settings_model->get('welcome');
		$data['welcome_text']=$welcome['welcome_text'];
		$data['settings']=$settings;

		return $this->CI->load->view('welcome',$data,TRUE);
	}	
}