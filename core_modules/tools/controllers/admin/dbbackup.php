<?php

class Dbbackup extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->module_model('tools','backup_model');
		$this->load->helper('paging');
		$this->lang->module_load('tools','backup');		
	}
	
	public function index()
	{
		// Display Page
		$data['header'] = 'Database Backup';
		$data['page'] = $this->config->item('template_admin') . "dbbackup/index";
		$data['module'] = 'tools';
		//$data['categories'] =$this->category_model->getCategories();
		$this->load->view($this->_container,$data);	
	}

	public function create()
	{
		if(!is_dir($this->preference->item('backup_path')))
		{
			echo json_encode(array('success'=>FALSE,'msg'=>'Directory Not Exist'));
			exit;
		}
		
		$this->load->dbutil();
		$backup_file=date('Y_m_d_h_i_s').'_backup.sql';
		$prefs = array(
			   
				'format'      => 'zip',             // gzip, zip, txt
				'filename'    => $backup_file,    // File name - NEEDED ONLY WITH ZIP FILES
				'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
				'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
				'newline'     => "\n"               // Newline character used in backup file
			  );
		
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup($prefs);
		
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		$file=$this->preference->item('backup_path').'/'.$backup_file.'.zip';
		write_file($file, $backup); 
		$this->backup_model->insert('BACKUP',array('file'=>$file,'backup_date'=>date('Y-m-d H:i:s')));
		echo json_encode(array('success'=>TRUE,'msg'=>'Backedup Successful'));
		
	}
	
	public function json()
	{
		$total=$this->backup_model->count();
		paging('backup_date desc');
		$rows=$this->backup_model->getBackups()->result_array();
		echo json_encode(array('total'=>$total,'rows'=>$rows));		
	}
	

	public function delete_json()
	{
    	$id=$this->input->post('id');
		if($id && is_array($id))
		{
        	foreach($id as $row):
			$backup=$this->backup_model->getBackups(array('backup_id'=>$row))->row_array();
			
			@unlink($backup['file']);
			$this->backup_model->delete('BACKUP',array('backup_id'=>$row));
            endforeach;
		}
	}
	
	public function download()
	{
		//$this->input->post('file');
		$this->load->helper('download');
		$data = file_get_contents($this->input->get('file')); 
		$name = 'backup.sql.zip';
		force_download($name, $data); 
	}
}