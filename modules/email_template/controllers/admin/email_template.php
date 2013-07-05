<?php

class Email_template extends Admin_Controller
{
	
	public function __construct(){
    	parent::__construct();
        $this->load->module_model('email_template','email_template_model');
        $this->lang->module_load('email_template','email_template');
		$this->bep_assets->load_asset('tinymce');
    }
    
	public function index()
	{
		// Display Page
		$data['header'] = 'email_template';
		$data['page'] = $this->config->item('template_admin') . "email_template/index";
		$data['module'] = 'email_template';
		$this->load->view($this->_container,$data);		
	}

	public function json()
	{
		$this->_get_search_param();	
		$total=$this->email_template_model->countEmailTemplates();
		paging('email_template_id');
		$this->_get_search_param();	
		$rows=$this->email_template_model->getEmailTemplates()->result_array();
		echo json_encode(array('total'=>$total,'rows'=>$rows));
	}
	
	public function _get_search_param()
	{
		// Search Param Goes Here
		parse_str($this->input->post('data'),$params);
		if(!empty($params['search']))
		{
			($params['search']['name']!='')?$this->db->like('name',$params['search']['name']):'';
			($params['search']['slug_name']!='')?$this->db->like('slug_name',$params['search']['slug_name']):'';
			($params['search']['subject']!='')?$this->db->like('subject',$params['search']['subject']):'';

		}  

		
		if(!empty($params['date']))
		{
			foreach($params['date'] as $key=>$value){
				$this->_datewise($key,$value['from'],$value['to']);	
			}
		}
		               
        
	}

	
	private function _datewise($field,$from,$to)
	{
			if(!empty($from) && !empty($to))
			{
				$this->db->where("(date_format(".$field.",'%Y-%m-%d') between '".date('Y-m-d',strtotime($from)).
						"' and '".date('Y-m-d',strtotime($to))."')");
			}
			else if(!empty($from))
			{
				$this->db->like($field,date('Y-m-d',strtotime($from)));				
			}		
	}	
    
	public function combo_json()
    {
		$rows=$this->email_template_model->getEmailTemplates()->result_array();
		echo json_encode($rows);    	
    }    
    
	public function delete_json()
	{
    	$id=$this->input->post('id');
		if($id && is_array($id))
		{
        	foreach($id as $row):
				$this->email_template_model->delete('EMAIL_TEMPLATES',array('email_template_id'=>$row));
            endforeach;
		}
	}    

	public function form_json()
	{
		
        $data=$this->_get_posted_data(); //Retrive Posted Data		

        if(!$this->input->post('email_template_id'))
        {
			$data['created_date'] = date('Y-m-d H:i:s');
			$success=$this->email_template_model->insert('EMAIL_TEMPLATES',$data);
        }
        else
        {
			$data['modified_date'] = date('Y-m-d H:i:s');           
            $success=$this->email_template_model->update('EMAIL_TEMPLATES',$data,array('email_template_id'=>$data['email_template_id']));
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
        $data['email_template_id'] = $this->input->post('email_template_id');
		$data['name'] = $this->input->post('name');
		$data['slug_name'] = $this->input->post('slug_name');
		$data['subject'] = $this->input->post('subject');
		$data['body'] = $this->input->post('body');
        return $data;
   }
   
   	
	    
}