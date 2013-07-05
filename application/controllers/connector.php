<?php

class Connector extends Admin_Controller
{
	public function __construct()
    {
    	parent::__construct();
		
		//permission check 
		
    }
    
    public function index()
    {
//    	$opts = array(
//	'root'            => $this->preference->item('upload_path'),                       // path to root directory
//	'URL'             => base_url(). $this->preference->item('upload_path').'/', // root directory URL
//	);
	 $opts = array(
		// 'debug' => true, 
		'roots' => array(
		  array( 
			'driver' => 'LocalFileSystem', 
			'path'   => 'assets/',//$this->preference->item('upload_path'),//set_realpath('yourfilespath'), 
			//'URL'    =>  'http://localhost/yprojects/rmsfinal/assets/'
			// more elFinder options here
    'accessControl' => 'access',             // disable and hide dot starting files (OPTIONAL)

   /* 'attributes' => array(
        array(
            'pattern' => '/tes$/', //You can also set permissions for file types by adding, for example, <b>.jpg</b> inside pattern.
            'read' => true,
            'write' => true,
            'locked' => true
        ),
	
    )*/ 		  
			)
		)
	  );	
	  
	  $this->load->library('elfinderconnector',NULL);    
		//$connector = new elFinderConnector(new elFinder($opts));
      $this->elfinderconnector->initialize(new Elfinder($opts));
	  $this->elfinderconnector->run();
    }
	


}