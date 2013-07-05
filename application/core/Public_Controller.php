<?php

class Public_Controller extends Site_Controller{

	var $theme;	
	var $layout_id;		
	var $menu;
	
	function __construct()
	{
		parent::__construct();
		
		//Load Themes
		//$this->theme=$this->preference->item('theme');
		//$this->load->add_package_path('themes/'.$this->theme);
		$this->load->add_package_path('themes/'.config_item('theme'));
		$this->load->helper(array('text','theme'));
		// Set container variable
		$this->_container = "container.php";

		// Set public meta tags
		//$this->bep_site->set_metatag('name','content',TRUE/FALSE);
		$this->bep_site->set_metatag('meta_keywords',$this->preference->item('meta_keywords'));
		$this->bep_site->set_metatag('meta_description',$this->preference->item('meta_description'));
		
		if(!$this->preference->item('site_status'))
		{
			echo $this->preference->item('offline_message');
			exit;
		}
		$this->load->module_model('plugins','settings_model');
//		$this->load->module_model('layout','layout_model');
		$this->load->module_model('slug','slug_model');	

	//	$this->_loadPackages();			
	//	$this->getLayoutBlocks('Default');
		// Load the PUBLIC asset group
		$this->bep_assets->load_asset_group('PUBLIC');
		log_message('debug','BackendPro : Public_Controller class loaded');		
	}

	protected function getBlocks($layout_id,$position)
	{
		$blocks=array();
		foreach($this->extensions as $key=>$value):
			$settings=$this->settings_model->get($key);
			$modules=unserialize($settings[$key.'_module']);
			if($modules)
			{
				foreach ($modules as $option) {
					if ($option['layout_id'] == $layout_id && $option['position'] == $position && $option['status']) {
						 $blocks[$option['sort_order']]=$this->$key->view($option);
					}
				}				
			}
		endforeach;	
		ksort($blocks);
		return $blocks;
	}
	
	protected function getLayoutBlocks($layout)
	{
		$this->layout=$this->layout_model->getLayouts(array('name'=>$layout))->row_array();

		if(!empty($this->layout))
		{
			$this->layout_id=$this->layout['layout_id'];

		}
		$this->column_left=$this->getBlocks($this->layout_id,'column_left');
		$this->column_right=$this->getBlocks($this->layout_id,'column_right');
		$this->content_top=$this->getBlocks($this->layout_id,'content_top');
		$this->content_bottom=$this->getBlocks($this->layout_id,'content_bottom');			
	}
	private function _loadPackages()
	{
		
		$this->extensions = $this->settings_model->get('widget_modules');	
		foreach($this->extensions as $key=>$value):
			$this->load->add_package_path('packages/plugins/'.$key.'/');
			$this->load->library($key);		
		endforeach;
	}	
}