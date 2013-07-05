<?php

class Shortcut_widget
{
	public function __construct()
	{
		$this->CI =& get_instance();
		
	}
	
	function create()
	{
		$this->CI->load->module_model('tools','shortcut_model');
		$data['shortcuts']=$this->CI->shortcut_model->getShortcuts()->result_array();
		return $this->CI->load->module_view('dashboard',$this->CI->config->item('template_admin') . 'dashboard/shortcut',$data,TRUE);
	}
}
