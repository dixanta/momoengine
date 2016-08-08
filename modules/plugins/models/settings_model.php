<?php

class Settings_model extends MY_Model
{

    public function __construct()
    {
    	parent::__construct();
        $this->prefix='';
        $this->_TABLES=array('SETTING'=>$this->prefix.'settings');
    }


	function get($code)
	{
		$this->db->where('code', $code);
		$this->db->from($this->_TABLES['SETTING']);
		$result	= $this->db->get();
		
		$return	= array();
		foreach($result->result() as $results)
		{
			$return[$results->key]	= $results->value;
		}
		return $return;	
	}    

	function save($code, $values)
	{
	
		//get the settings first, this way, we can know if we need to update or insert settings
		//we're going to create an array of keys for the requested code
		$settings	= $this->get($code);
	
		
		//loop through the settings and add each one as a new row
		foreach($values as $key=>$value)
		{
			//if the key currently exists, update the setting
			if(array_key_exists($key, $settings))
			{
				$update	= array('value'=>$value);
				$this->db->where('code', $code);
				$this->db->where('key',$key);
				$this->db->update($this->_TABLES['SETTING'], $update);
			}
			//if the key does not exist, add it
			else
			{
				$insert	= array('code'=>$code, 'key'=>$key, 'value'=>$value);
				$this->db->insert($this->_TABLES['SETTING'], $insert);
			}
			
		}
		
	}

	//delete any settings having to do with this particular code
	function deleteCode($code)
	{
		$this->db->where('code', $code);
		$this->db->delete($this->_TABLES['SETTING']);
	}
	
	//this deletes a specific setting
	function deleteKey($code, $key)
	{
		$this->db->where('code', $code);
		$this->db->where('key', $key);
		$this->db->delete($this->_TABLES['SETTING']);
	}	
}