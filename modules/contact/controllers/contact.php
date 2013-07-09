<?php
class Contact extends Public_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->helper(array('form','date','url'));
        $this->load->library('form_validation');
		$this->load->library('email');
		$this->bep_site->set_crumb('Home','');
		$this->bep_site->set_crumb('Contact','contact');
		
		
	}
	
	function index()
	{
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|email');
		$this->form_validation->set_rules('message','Message','trim|required');	
		//$this->form_validation->set_rules('recaptcha_response_field','Recaptcha','trim|required|callback_valid_captcha');
		
		if($this->form_validation->run()===FALSE)
		{
			$data['header'] = 'Contact Us';
			$data['view_page'] = "contact/index";
			$data['captcha'] = $this->_generate_captcha();
			$this->load->view($this->_container,$data);	
		}
		else
		{
			$this->_send_mail();
			flashMsg('success','Thank you for contacting us. We will response you as soon as possible.');			
			redirect(site_url('contact'));			
			
		}

	}
	
	
	
	function _send_mail()
	{
			$subject="Contact from :: " .$this->input->post('name');

			$message="The following person has contacted";
			$message.="<br/>=====================================";
			$message.="<br/>Sender Name: " . $this->input->post('name');
			$message.="<br/>Sender Email: " . $this->input->post('email');			
			$message.="<br/>Sender Message: " . $this->input->post('message');
									
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->clear(TRUE);
			$this->email->from($this->preference->item('automated_from_email'), $this->preference->item('automated_from_name'));
			$this->email->to('dixanta@gmail.com');
			
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();		
	}
	
	private function _generate_captcha()
	{
		$this->bep_assets->load_asset('recaptcha');
		$this->load->module_library('recaptcha','Recaptcha');
		return $this->recaptcha->recaptcha_get_html();
	}

	private function valid_captcha()
	{
		// Make sure the captcha library is loaded
		$this->load->module_library('recaptcha','Recaptcha');
		$this->form_validation->set_message('valid_captcha', $this->lang->line('userlib_validation_captcha'));
		// Perform check
		$this->recaptcha->recaptcha_check_answer($this->input->server('REMOTE_ADDR'), $this->input->post('recaptcha_challenge_field'), $this->input->post('recaptcha_response_field'));

		return $this->recaptcha->is_valid;	
	}
	
}