<?php

class Slug_model extends MY_Model
{
	var $file_name; 	
    public function __construct()
    {
    	parent::__construct();
        $this->prefix='';
        $this->_TABLES=array('SLUG'=>$this->prefix.'slugs');
		$this->file_name = APPPATH.'config/routes'.EXT;		
    }

	// Check for existing indexes or reserved words
	function verify($route)
	{
		$route = strtolower($route);
		
		// Can't be the same as the name of a controller
		if ($handle = opendir(APPPATH.'controllers')) {
		    while (false !== ($file = readdir($handle))) {
		        if ($file != "." && $file != "..") {
		        	$file = str_replace('.php', '', strtolower($file));
		            if($route == $file) return false;
		        }
		    }
		    closedir($handle);
		}
		
		// otherwise, we're good
		return true;
	
	}

	// does the route exist ?
	function exists($route)
	{
		if(array_key_exists($route, $this->router->routes)) return true;
	}

	function validate_slug($slug, $id=false, $count=false)
	{
		if($this->check_slug($slug.$count, $id))
		{
			if(!$count)
			{
				$count	= 1;
			}
			else
			{
				$count++;
			}
			return $this->validate_slug($slug, $id, $count);
		}
		else
		{
			return $slug.$count;
		}
	}
	
	function check_slug($slug, $id=FALSE)
	{
		if($id)
		{
			$this->db->where('slug_id !=', $id);
		}
		$this->db->where('slug_name', $slug);
		
		return (bool) $this->db->count_all_results($this->_TABLES['SLUG']);
	}
	
	public function delete_slug($slug_id)
	{
		$this->db->where_in('slug_id', $slug_id);
		$this->db->delete($this->_TABLES['SLUG']); 
	}
    
	
}