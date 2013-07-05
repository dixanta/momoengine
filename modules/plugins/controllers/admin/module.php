<?php
class Module extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->module_model('plugins','settings_model');
		$this->load->module_model('layout','layout_model');
	}
	
	function index()
	{
		$enabled_modules	= $this->settings_model->get('widget_modules');
		
		$data['widget_modules']	= array();
		if ($handle = opendir('packages/plugins/')) {
			while (false !== ($file = readdir($handle)))
			{
				if (!strstr($file, '.'))
				{
					if(array_key_exists($file, $enabled_modules))
					{
						$data['widget_modules'][$file]	= true;
					}
					else
					{
						$data['widget_modules'][$file]	= false;
					}
				}
			}
			closedir($handle);
		}
		$data['header'] = 'Module Settings';		
		$data['page'] = $this->config->item('template_admin') . "module/index";
		$data['module'] = 'plugins';
		$this->load->view($this->_container,$data);	
	}

	function install($module)
	{
		$this->load->add_package_path('packages/plugins/'.$module.'/');
		$this->load->library($module);
		
		$enabled_modules	= $this->settings_model->get('widget_modules');
		
		if(!array_key_exists($module, $enabled_modules))
		{
			$this->settings_model->save('widget_modules', array($module=>false));
			$this->$module->install();
		}
		else
		{
			$this->settings_model->deleteKey('widget_modules', $module);
			$this->$module->uninstall();
		}
		redirect(site_url('plugins/admin/module'));
	}
	
	//this is an alias of install
	function uninstall($module)
	{
		$this->install($module);
	}
	
	function settings($module)
	{
		$this->load->add_package_path('packages/plugins/'.$module.'/');
		$this->load->library($module);
		$this->layouts=$this->layout_model->getLayouts()->result_array();		
		//ok, in order for the most flexibility, and in case someone wants to use javascript or something
		//the form gets pulled directly from the library.
	
		if(count($_POST) >0)
		{
			$check	= $this->$module->check();
			if(!$check)
			{
				$this->session->set_flashdata('message', sprintf(lang('settings_updated'), $module));
				redirect(site_url('plugins/admin/module'));
			}
			else
			{
				//set the error data and form data in the flashdata
				$this->session->set_flashdata('message', $check);
				$this->session->set_flashdata('post', $_POST);
				redirect(site_url('plugins/admin/module/settings/'.$module));
			}
		}
		elseif($this->session->flashdata('post'))
		{
			$data['form']		= $this->$module->form($this->session->flashdata('post'));
		}
		else
		{
			$data['form']		= $this->$module->form();
		}
		$data['header']		= $module.' Settings';
		$data['module']		= 'plugins';
		$data['module_name']= $module;
		$data['page_title']	= sprintf(lang('shipping_settings'), $module);
		$data['page'] = $this->config->item('template_admin') . "module/settings";
		$this->load->view($this->_container,$data);
	}	
	
	
/*	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		// Display Page
		$data['header'] = 'Module';
		$data['page'] = $this->config->item('template_admin') . "module/index";
		$data['module'] = 'plugins';
		$this->load->view($this->_container,$data);		
	}*/
}