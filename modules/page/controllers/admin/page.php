<?php

class Page extends Admin_Controller
{
	protected $uploadPath = 'uploads/page';
	protected $uploadthumbpath= 'uploads/page/thumb/';

	public function __construct(){
    	parent::__construct();
        $this->load->module_model('page','page_model');
		$this->load->module_model('slug','slug_model');
        $this->lang->module_load('page','page');
		$this->bep_assets->load_asset('jquery.upload');
		$this->bep_assets->load_asset('tinymce');
    }
    
	public function index()
	{
		// Display Page
		$data['header'] = 'page';
		$data['page'] = $this->config->item('template_admin') . "page/index";
		$data['module'] = 'page';
		$this->load->view($this->_container,$data);		
	}

	public function json()
	{
		$this->_get_search_param();	
		$total=$this->page_model->countPages();
		paging('page_id');
		$this->_get_search_param();	
		$rows=$this->page_model->getPages()->result_array();
		echo json_encode(array('total'=>$total,'rows'=>$rows));
	}
	
	public function _get_search_param()
	{
		// Search Param Goes Here
	}

	public function combo_json()
    {
		$rows=$this->page_model->getPages()->result_array();
		echo json_encode($rows);    	
    }    
    
	public function delete_json()
	{
		$data['page_flag']=1;
    	$id=$this->input->post('id');
		if($id && is_array($id))
		{
        	foreach($id as $row):
				$this->page_model->update('PAGES',$data,array('page_id'=>$row));
            endforeach;
		}
	}    

	public function form_json()
	{
		
        $data=$this->_get_posted_data(); //Retrive Posted Data		

		$slug['slug_name'] = url_title($data['page_title'], 'dash', TRUE);

        if(!$this->input->post('page_id'))
        {
			$slug['slug_name']= $this->slug_model->validate_slug($slug['slug_name']);
			$this->slug_model->insert('SLUG',$slug);
			$data['slug_id'] = $this->db->insert_id();
			
			$data['created_date'] = date('Y-m-d H:i:s');
			$data['slug_name'] = $slug['slug_name'];
            $this->page_model->insert('PAGES',$data);
			
			$page_id=$this->db->insert_id();
			$slug['route']='page/index/'.$page_id;
			
			$success=$this->slug_model->update('SLUG',$slug,array('slug_id'=>$data['slug_id']));
			//echo $this->db->last_query();
			//exit;
        }
        else
        {
			//$slug['route']='page/index/'.$data['page_id'];
			//print_r($slug);exit;
			$slug['slug_name']= $this->slug_model->validate_slug($slug['slug_name'],$data['slug_id']);
			$this->slug_model->update('SLUG',$slug,array('slug_id'=>$data['slug_id']));
			$data['modified_date'] = date('Y-m-d H:i:s');
			$data['slug_name'] = $slug['slug_name'];
            $success=$this->page_model->update('PAGES',$data,array('page_id'=>$data['page_id']));
        }
        
		if($success)
		{
			$success = TRUE;
			$msg=lang('success_message'); 
		} 
		else
		{
			$success = FALSE;
			$msg=lang('failure_message');
		}
		 
		 echo json_encode(array('msg'=>$msg,'success'=>$success));		
        
	}
   
   private function _get_posted_data()
   {
   		$data=array();
		$data['page_id'] = $this->input->post('page_id');
		$data['page_title'] = $this->input->post('page_title');
		$data['description'] = $this->input->post('description');
		$data['image_name'] = $this->input->post('image_name');
		$data['slug_id'] = $this->input->post('slug_id');
		$data['slug_name'] = url_title($data['page_title'], 'dash', TRUE);
		$data['status'] = $this->input->post('status');
		$data['meta_keywords'] = $this->input->post('meta_keywords');
		$data['meta_description'] = $this->input->post('meta_description');	

        return $data;
   }
   
	function upload_image(){
		//Image Upload Config
		$config['upload_path'] = $this->uploadPath;
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size']	= '10240';
		$config['remove_spaces']  = true;
		$config['encrypt_name']  = TRUE;

		//load upload library
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload())
		{
			$data['error'] = $this->upload->display_errors('','');
			echo json_encode($data);
		}
		else
		{
		  $data = $this->upload->data();
		  $this->load->library('image_lib');
		  
 		  $config['image_library'] = 'gd2';
		  $config['source_image'] = $data['full_path'];

		  $config['maintain_ratio'] = TRUE;
		  $config['height'] =$this->preference->item('page_image_height');
		  $config['width'] = $this->preference->item('page_image_width');
		  
		  $this->image_lib->initialize($config);
		  $this->image_lib->resize();		  
		  
          $config['new_image']    = $this->uploadthumbpath;
		  //$config['create_thumb'] = TRUE;
		  $config['maintain_ratio'] = TRUE;
		  $config['height'] =100;
		  $config['width'] = 100;

		  $this->image_lib->initialize($config);
		  $this->image_lib->resize();
		  echo json_encode($data);
	    }
	}
	
	function upload_delete(){
		//get filename
		$filename = $this->input->post('filename');
		@unlink($this->uploadthumbpath . '/' . $filename);
		@unlink($this->uploadPath . '/' . $filename);
	} 			
		
		
	    
}