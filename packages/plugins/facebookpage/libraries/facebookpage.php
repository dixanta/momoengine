<?php

class Facebookpage
{
	var $CI;	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
		//$this->CI->lang->load('facebookpage');				
	}

	//back end installation functions
	function install()
	{
		
		$config['fanpage_id'] = '';

		$this->CI->settings_model->save('facebookpage', $config);
	}
	
	function uninstall()
	{
		$this->CI->settings_model->delete('facebookpage');
	}	

	//admin end form and check functions
	function form($post	= false)
	{
		//this same function processes the form
		if(!$post)
		{
			$settings	= $this->CI->settings_model->get('facebookpage');
		}
		else
		{

			$settings = $post;
			print_r($settings);
			exit;
		}

		$data['settings']=$settings;
		$data['modules']=array();
		
		$data['fanpage_id']=$settings['fanpage_id'];

		if(!empty($settings['facebookpage_module']))
		{
			$data['modules']=@unserialize($settings['facebookpage_module']);
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
			$this->CI->settings_model->save('facebookpage', array('facebookpage_module'=>serialize($_POST['facebookpage_module'])));
			$this->CI->settings_model->save('facebookpage', array('fanpage_id'=>$_POST['fanpage_id']));			
			return false;
		}
	}
	
	function view($settings)
	{
		$facebook_page_settings= $this->CI->settings_model->get('facebookpage');
		$data['fanpage_id']=$facebook_page_settings['fanpage_id'];
		$data['settings']=$settings;
		return $this->CI->load->view('facebookpage',$data,TRUE);
	}	
}