<?php

class MY_Form_validation extends CI_Form_validation
{
	function valid_captcha()
	{
		// Make sure the captcha library is loaded
		$this->CI->load->module_library('recaptcha','Recaptcha');

		// Set the error message
		$this->CI->form_validation->set_message('valid_captcha', $this->CI->lang->line('userlib_validation_captcha'));


		// Perform check
		$this->CI->recaptcha->recaptcha_check_answer($this->CI->input->server('REMOTE_ADDR'), $this->CI->input->post('recaptcha_challenge_field'), $this->CI->input->post('recaptcha_response_field'));
		return $this->CI->recaptcha->is_valid;
	}	
}