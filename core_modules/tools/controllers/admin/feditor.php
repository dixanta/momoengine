<?php

class Feditor extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		set_time_limit(0);
		$this->bep_assets->load_asset_group('FILETREE');
	}
	
	public function index()
	{
		$data['header'] = "File Editor";
		$data['page'] = $this->config->item('template_admin') . 'feditor/index';
		$data['module'] = 'tools';
		$this->load->view($this->_container,$data);
	}

	public function filetree()
	{
		
		$_POST['dir'] = urldecode($_POST['dir']);
		//echo getcwd() .'/'.$_POST['dir'];
		//exit;
		$root='';
		if( file_exists($root . $_POST['dir']) ) {
			$files = scandir($root . $_POST['dir']);
			natcasesort($files);
			if( count($files) > 2 ) { /* The 2 accounts for . and .. */
				echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
				// All dirs
				foreach( $files as $file ) {
					if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file) ) {
						echo "<li class=\"directory collapsed\"><a href=\"#\" class=\"fld\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . $file . "</a></li>";
					}
				}
				// All files
				foreach( $files as $file ) {
					if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file) ) {
						$ext = preg_replace('/^.*\./', '', $file);
						echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . $_POST['dir'] . $file . "\">" . $file . "</a></li>";
					}
				}
				echo "</ul>";	
			}
		}
	}
	
	public function get_file()
	{
		$file=$this->input->get('file');
		if($file)
		{
			$content=file_get_contents($file, FILE_USE_INCLUDE_PATH);
			echo $content;
		}
	}

	public function save()
	{
		if($this->input->post('save'))
		{
			$file=$this->input->post('source_file');
			$data=$this->input->post('filecontent');
			if(file_put_contents($file, $data))
			{
				echo json_encode(array('success'=>TRUE));	
				die();		
			}
			echo json_encode(array('success'=>FALSE));
		}
		echo json_encode(array('success'=>FALSE));
	}	
}