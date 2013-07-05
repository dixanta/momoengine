<?php

class Email_template_model extends MY_Model
{
	var $joins=array();
    public function __construct()
    {
    	parent::__construct();
        $this->prefix='';
        $this->_TABLES=array('EMAIL_TEMPLATES'=>$this->prefix.'email_templates');
		$this->_JOINS=array('KEY'=>array('join_type'=>'LEFT','join_field'=>'join1.id=join2.id',
                                           'select'=>'field_names','alias'=>'alias_name'),
                           
                            );        
    }
    
    public function getEmailTemplates($where=NULL,$order_by=NULL,$limit=array('limit'=>NULL,'offset'=>''))
    {
       $fields='email_templates.*';
       
		foreach($this->joins as $key):
			$fields=$fields . ','.$this->_JOINS[$key]['select'];
		endforeach;
                
        $this->db->select($fields);
        $this->db->from($this->_TABLES['EMAIL_TEMPLATES']. ' email_templates');
		
		foreach($this->joins as $key):
                    $this->db->join($this->_TABLES[$key]. ' ' .$this->_JOINS[$key]['alias'],$this->_JOINS[$key]['join_field'],$this->_JOINS[$key]['join_type']);
		endforeach;	        
        
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
    
    public function countEmailTemplates($where=NULL)
    {
		$this->db->select('count(*) as rows');
        $this->db->from($this->_TABLES['EMAIL_TEMPLATES'].' email_templates');
        
        foreach($this->joins as $key):
        $this->db->join($this->_TABLES[$key]. ' ' .$this->_JOINS[$key]['alias'],$this->_JOINS[$key]['join_field'],$this->_JOINS[$key]['join_type']);
        endforeach;        
        if( ! is_null($where))
		{
			$this->db->where($where);
		}
        $result=$this->db->get();
        if($result->num_rows()>0)
        {
        	$row=$result->row_array();
            return $row['rows'];
        }
        return 0;
    }
}