<?php

class Shortcut extends Admin_Controller
{
	protected $uploadPath = 'uploads/shortcut';
	protected $uploadthumbpath= 'uploads/shortcut/thumb/';

	public function __construct(){
    	parent::__construct();
        $this->load->module_model('tools','shortcut_model');
        $this->lang->module_load('tools','shortcut');
		$this->bep_assets->load_asset('jquery.upload');
    }
    
	public function index()
	{
		// Display Page
		$data['header'] = 'shortcut';
		$data['page'] = $this->config->item('template_admin') . "shortcut/index";
		$data['module'] = 'tools';
		$this->load->view($this->_container,$data);		
	}

	public function json()
	{
		$total=$this->shortcut_model->count();
		paging('shortcut_id');
		$rows=$this->shortcut_model->getShortcuts()->result_array();
		echo json_encode(array('total'=>$total,'rows'=>$rows));
	}

    
	public function delete_json()
	{
    	$id=$this->input->post('id');
		if($id && is_array($id))
		{
        	foreach($id as $row):
				$this->shortcut_model->delete('SHORTCUTS',array('shortcut_id'=>$row));
            endforeach;
		}
	}    

	public function form_json()
	{
		
        $data=$this->_get_posted_data(); //Retrive Posted Data		

        if(!$this->input->post('shortcut_id'))
        {
			$data['added_date'] = date('Y-m-d H:i:s');
            $success=$this->shortcut_model->insert('SHORTCUTS',$data);
        }
        else
        {
            $success=$this->shortcut_model->update('SHORTCUTS',$data,array('shortcut_id'=>$data['shortcut_id']));
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
        $data['shortcut_id'] = $this->input->post('shortcut_id');
		$data['name'] = $this->input->post('name');
		$data['image'] = $this->input->post('image');
		$data['link'] = $this->input->post('link');
		$data['new_window'] = $this->input->post('new_window');
		$data['status'] = $this->input->post('status');

        return $data;
   }
   
   function upload_image(){
		//Image Upload Config
		$config['upload_path'] = $this->uploadPath;
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size']	= '10240';
		$config['remove_spaces']  = true;
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
 		  $config['image_library'] = 'gd2';
		  $config['source_image'] = $data['full_path'];
          $config['new_image']    = $this->uploadthumbpath;
		  //$config['create_thumb'] = TRUE;
		  $config['maintain_ratio'] = TRUE;
		  $config['height'] =100;
		  $config['width'] = 100;

		  $this->load->library('image_lib', $config);
		  $this->image_lib->resize();
		  echo json_encode($data);
	    }
	}
	
	function upload_delete(){
		//get filename
		$filename = $this->input->post('filename');
		@unlink($this->uploadPath . '/' . $filename);
	} 		
		
		
	    
}