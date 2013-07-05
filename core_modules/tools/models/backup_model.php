<?php

class Backup_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->_prefix = $this->config->item('table_prefix');
		$this->_TABLES = array('BACKUP' => $this->_prefix . 'backups');

		log_message('debug','BackendPro : Backup_model class loaded');		
	}
	
	public function getBackups($where = NULL,$order_by=NULL, $limit = array('limit' => NULL, 'offset' => ''))
	{
		$this->db->select('*');
		$this->db->from($this->_TABLES['BACKUP']);

		(! is_null($where))?$this->db->where($where):NULL;
		(! is_null($order_by))?$this->db->order_by($order_by):NULL;
		
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		return $this->db->get();		
	}
	
    public function count($where=NULL)
    {
		
        $this->db->from($this->_TABLES['BACKUP'].' videos');
       (! is_null($where))?$this->db->where($where):NULL;
		
        return $this->db->count_all_results();
    }	
	
}