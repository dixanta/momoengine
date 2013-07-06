<?php
class Page extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->getLayoutBlocks('Page');	
		$this->load->module_model('page','page_model');		
		$this->bep_site->set_crumb('Home','');

	}
	
	public function index($id=NULL)
	{
		if(is_null($id))
		{
			redirect(site_url());
		}
		$this->bep_site->set_crumb($this->uri->segment(1));				
		$detail=$this->page_model->getPages(array('page_id'=>$id))->row_array();
		
		$this->bep_site->set_metatag('meta_keywords',$detail['meta_keywords']);
		$this->bep_site->set_metatag('meta_description',$detail['meta_description']);		

		// Display Page
		$data['header'] = $detail['page_title'];
		$data['detail'] = $detail;
		$data['view_page'] =  'page/index';
		$this->load->view($this->_container,$data);
	}
	
	public function faq()
	{
		$data['header'] = 'faq';
		$data['view_page'] =  'page/faq';
		$this->load->view($this->_container,$data);		
	}
}