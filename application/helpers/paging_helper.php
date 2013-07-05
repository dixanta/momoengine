<?php

function paging($default)
{
	$ci=&get_instance();
	if($ci->input->post('order'))
	{
		
		$ci->db->order_by($ci->input->post('sort').' '.$ci->input->post('order'));
	}
	else
	{
		$ci->db->order_by($default);
	}
	if($ci->input->post('rows') && $ci->input->post('page'))
	{
		$offset=($ci->input->post('page')*$ci->input->post('rows'))-($ci->input->post('rows'));
		
		
		$ci->db->limit($ci->input->post('rows'),$offset);
	}
	else
	{
		$ci->db->limit('10');
	}	
}