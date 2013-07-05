<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{

		$data['header'] = "Home";
		$data['view_page'] = 'home/index';
		$this->load->view($this->_container,$data);
	}
}


/* End of file welcome.php */
/* Location: ./modules/welcome/controllers/welcome.php */