<?php

class Layout extends Admin_Controller
{
	
	public function __construct(){
    	parent::__construct();
        $this->load->module_model('layout','layout_model');
        $this->lang->module_load('layout','layout');
    }
    
	public function index()
	{
		// Display Page
		$data['header'] = 'layout';
		$data['page'] = $this->config->item('template_admin') . "layout/index";
		$data['module'] = 'layout';
		$this->load->view($this->_container,$data);		
	}

	public function json()
	{
		$this->_get_search_param();	
		$total=$this->layout_model->countLayouts();
		paging('layout_id');
		$this->_get_search_param();	
		$rows=$this->layout_model->getLayouts()->result_array();
		echo json_encode(array('total'=>$total,'rows'=>$rows));
	}
	
	public function _get_search_param()
	{
		parse_str($this->input->post('data'),$params);
		if(!empty($params['search']))
		{
			($params['search']['name']!='')?$this->db->like('name',$params['search']['name']):'';
		}
	}

	public function combo_json()
    {
		$rows=$this->layout_model->getLayouts()->result_array();
		echo json_encode($rows);    	
    }    
    
	public function delete_json()
	{
    	$id=$this->input->post('id');
		if($id && is_array($id))
		{
        	foreach($id as $row):
				$this->layout_model->delete('LAYOUTS',array('layout_id'=>$row));
            endforeach;
		}
	}    

	public function form_json()
	{
		
        $data=$this->_get_posted_data(); //Retrive Posted Data		

        if(!$this->input->post('layout_id'))
        {
            $success=$this->layout_model->insert('LAYOUTS',$data);
        }
        else
        {
            $success=$this->layout_model->update('LAYOUTS',$data,array('layout_id'=>$data['layout_id']));
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
        $data['layout_id'] = $this->input->post('layout_id');
$data['name'] = $this->input->post('name');

        return $data;
   }
   
   	
	    
}