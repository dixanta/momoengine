<?php

class Backup_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->_prefix = $this->config->item('table_prefix');
		$this->_TABLES = array('Backup' => $this->_prefix . 'backup');

		log_message('debug','BackendPro : Backup_model class loaded');		
	}
	
	public function getBackups($where = NULL,$order_by=NULL, $limit = array('limit' => NULL, 'offset' => ''))
	{
		$this->db->select('*');
		$this->db->from($this->_TABLES['Backup']);

		if( ! is_null($where))
		{
			$this->db->where($where);
		}
		
		if(!is_null($order_by))
		{
			$this->db->order_by($order_by);
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		return $this->db->get();		
	}
	
}