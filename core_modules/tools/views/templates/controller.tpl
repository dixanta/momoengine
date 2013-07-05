{PHP_TAG}

class {CONTROLLER} extends Admin_Controller
{
	{UPLOAD_PATH}
	public function __construct(){
    	parent::__construct();
        $this->load->module_model('{MODULE}','{MODEL}');
        $this->lang->module_load('{MODULE}','{LANG}');
        //$this->bep_assets->load_asset('jquery.upload'); // uncomment if image ajax upload
    }
    
	public function index()
	{
		// Display Page
		$data['header'] = '{MODULE}';
		$data['page'] = $this->config->item('template_admin') . "{FOLDER}/index";
		$data['module'] = '{MODULE}';
		$this->load->view($this->_container,$data);		
	}

	public function json()
	{
		$this->_get_search_param();	
		$total=$this->{MODEL}->count();
		paging('{PRIMARY_KEY}');
		$this->_get_search_param();	
		$rows=$this->{MODEL}->get{TABLE_NAME}()->result_array();
		echo json_encode(array('total'=>$total,'rows'=>$rows));
	}
	
	public function _get_search_param()
	{
		// Search Param Goes Here
		parse_str($this->input->post('data'),$params);
		if(!empty($params['search']))
		{
			{SEARCH_PARAMS}
		}  

		
		{DATE_SEARCH_PARAMS}
		               
        
	}

	{DATEWISE_FUNCTION}	
    
	public function combo_json()
    {
		$rows=$this->{MODEL}->get{TABLE_NAME}()->result_array();
		echo json_encode($rows);    	
    }    
    
	public function delete_json()
	{
    	$id=$this->input->post('id');
		if($id && is_array($id))
		{
        	foreach($id as $row):
				$this->{MODEL}->delete('{TABLE_KEY}',array('{PRIMARY_KEY}'=>$row));
            endforeach;
		}
	}    

	public function save()
	{
		
        $data=$this->_get_posted_data(); //Retrive Posted Data		

        if(!$this->input->post('{PRIMARY_KEY}'))
        {
            $success=$this->{MODEL}->insert('{TABLE_KEY}',$data);
        }
        else
        {
            $success=$this->{MODEL}->update('{TABLE_KEY}',$data,array('{PRIMARY_KEY}'=>$data['{PRIMARY_KEY}']));
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
        {POSTED_DATA}
        return $data;
   }
   
   {UPLOAD_FUNCTION}	
	    
}