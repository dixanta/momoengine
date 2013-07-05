<?php
class Language extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$data['header']='Language';
		$data['page']= $this->config->item('template_admin') .'language/index';
		$data['module']='tools';
		
		$this->load->view($this->_container,$data);				
	}
}