<?php
class Member_Controller extends Public_Controller
{
	var $user_id=NULL;
	var $new_mails=0;
	public function __construct()
	{
		parent::__construct();
		if(!is_user())
		{
			redirect(site_url('auth/login'));
		}
		$this->user_id=$this->session->userdata('id');
/*		$this->load->module_model('message','message_model');
		$this->message_model->joins=array('MESSAGE_RECIPIENTS');
		$this->new_mails=$this->message_model->countMessages(array('recipient'=>$this->user_id,'is_read'=>0));
*/		
		$this->google_tracking=FALSE;		
	}
}
