<?php

class Filemanager extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->bep_assets->load_asset_group('ELFINDER');		
	}
	
	public function index()
	{
		$data['header']='File Manager';
		$data['page']= $this->config->item('template_admin') .'filemanager/index';
		$data['module']='tools';
		$this->load->view($this->_container,$data);		
	}
}