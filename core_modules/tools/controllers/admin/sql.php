<?php
class Sql extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		$data['header'] = 'SQL';
		$data['page'] = $this->config->item('template_admin') . "sql/index";
		$data['module'] = 'tools';
		$this->load->view($this->_container,$data);		
		
	}
	
	public function execute()
	{

		$contents=$this->input->post('sql');
		$output='';
		$contents = preg_replace('/--(.)*/', '', $contents);

		// Get rid of newlines
		$contents = preg_replace('/\n/', '', $contents);

		// Turn each statement into an array item
		$contents = explode(';', $contents);

		foreach($contents as $sql)
		{
			if( $sql == '')
			{
				continue;
			}
			$output.="Executing ---> ".$sql ."<br/>";
			$output.="========================================<br/>";
			$result=$this->db->query($sql);
			$output.=print_r($result,TRUE) .'<br/>';
		}
		echo $output;
	}
	
}