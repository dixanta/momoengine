{PHP_TAG}

class Api extends API_Controller
{
	public function __construct()
    {
    	parent::__construct();
        $this->load->module_model('{MODULE}','{MODEL}');
    }
    
    public function {MODULE}_get()
    {
    	//$this->get('param_name') for get method
    	$this->response(array('id'=>1),200);
    }

    public function {MODULE}_post()
    {
	    //$this->post('param_name') for post method
    	$this->response(array('success'=>TRUE),200);
    }
    
    public function {MODULE}_delete()
    {
	    //$this->post('param_name') for post method
    	$this->response(array('success'=>TRUE),200);
    }    
    
    
}