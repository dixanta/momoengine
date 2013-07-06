<?php
class Account extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->module_model('auth','user_model');	
	    $this->lang->module_load('account','account');
	    $this->bep_site->set_crumb('Home','');
	    $this->bep_site->set_crumb('Account','account');
	    
	}
	
	public function index()
	{	
		$id=$this->session->userdata('id');
		$data=$this->user_model->getUserProfile(array('user_id'=>$id))->row_array();
		
		$data['header'] = "User Account";
		$data['view_page'] =  'account/index';
		$data['module'] = 'account';

		$this->load->view($this->_container,$data);
	}
	

	
	public function change_password()
	{
	//print_r($_POST);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->module_library('auth','user_email');
		
		$min_password_length=$this->preference->item('min_password_length');
		
		$this->form_validation->set_rules('password', 'Old Password', 'required|min_length['.$min_password_length.']|callback_password_check');
		$this->form_validation->set_rules('new_password', 'New Confirmation', 'required|min_length['.$min_password_length.']');
		$this->form_validation->set_rules('conf_password', 'Password Confirmation', 'required|min_length['.$min_password_length.']|matches[new_password]');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['header'] = "Change Password";
			$data['view_page'] =  'account/change_password';
			$data['module'] = 'account';
			$this->load->view($this->_container,$data);				
		}
		else
		{	
			$user_id=$this->session->userdata('id');	//echo $user_id; exit;	
			$pass=$this->input->post('new_password');
			$enc_pass=$this->userlib->encode_password($pass);
			// Update password in database
			$date = date('Y-m-d H:i:s');				
			$this->user_model->update('Users',array('modified'=>$date, 'password'=>$enc_pass), array('id'=>$user_id));

			// Email the new password to the user
			$query = $this->user_model->fetch('Users','username,email',NULL,array('id'=>$user_id));
			$user = $query->row();
			$data = array(
                    'username'=>$user->username,
                    'email'=>$user->email,
                    'password'=>$pass,
                    'site_name'=>$this->preference->item('site_name'),
                    'site_url'=>base_url()
			);

			$this->user_email->send($user->email,$this->lang->line('userlib_change_password'),'account/email_change_password',$data);

			flashMsg('success','You have successfully changed your password. Please login again.');
			redirect(site_url());

			
		}
	}	
	
	public function password_check($str)
	{
		$user_id=$this->session->userdata('id');

		$password=$this->userlib->encode_password($str);

		$result=$this->user_model->fetch('Users',NULL,NULL,array('id'=>$user_id,'password'=>$password));
		
		if ($result->num_rows()==0)
		{
			$this->form_validation->set_message('password_check', 'Password did not matches with our database');
			return FALSE;		
		}
		//echo $str; exit;
		return TRUE;
	}
	

	
	
}