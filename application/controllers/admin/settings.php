<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * A website backend system for developers for PHP 4.3.2 or newer
 *
 * @package         BackendPro
 * @author          Adam Price
 * @copyright       Copyright (c) 2008
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ---------------------------------------------------------------------------

/**
 * Settings
 *
 * Main website settings controller
 *
 * @package         BackendPro
 * @subpackage      Controllers
 */
class Settings extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->lang->module_load('preferences','preferences');

		log_message('debug','BackendPro : Settings class loaded');
	}

	function index()
	{
		$this->load->module_model('auth','access_control_model');
		// Setup the preference form
		$config['form_name'] = $this->lang->line('backendpro_settings');
		$config['form_link'] = 'admin/settings/index';

		// Setup preference groups
		$config['group'] = array(
                'general'     => array('name'=> $this->lang->line('preference_page_general_configuration'), 'fields'=>'site_name,theme,date_format,date_time_format,meta_keywords,meta_description,backup_path,site_status,offline_message'),
                'members'     => array('name'=> $this->lang->line('preference_page_member_settings'), 'fields'=>'allow_user_registration,activation_method,account_activation_time,autologin_period,default_user_group,login_field,allow_user_profiles'),
                'security'    => array('name'=> $this->lang->line('preference_page_security_preferences'), 'fields'=>'use_login_captcha,use_registration_captcha,min_password_length'),
                'email'       => array('name'=> $this->lang->line('preference_page_email_configuration'), 'fields'=>'automated_from_name,automated_from_email,email_protocol,email_mailpath,smtp_host,smtp_user,smtp_pass,smtp_port,smtp_timeout,email_mailtype,email_charset,email_wordwrap,email_wrapchars,bcc_batch_mode,bcc_batch_size'),
                'maintenance' => array('name'=> $this->lang->line('preference_page_maintenance_debugging_settings'), 'fields'=>'page_debug,keep_error_logs_for'),
                'google' => array('name'=> $this->lang->line('preference_page_google_settings'), 'fields'=>'google_analytics_tracking_code,activate_google_analytics'),
				'social' => array('name'=> $this->lang->line('preference_page_social_settings'), 'fields'=>'facebook_fan_page_link,twitter_page_link,google_plus_page_link,linkedin_page_link'),	
		);

		// Setup custom field options
	
		$config['field']['site_name'] = array('rules'=>'trim|required');
		$config['field']['theme'] = array('rules'=>'trim|required');
		$config['field']['date_format'] = array('rules'=>'trim|required');
		$config['field']['date_time_format'] = array('rules'=>'trim|required');
		$config['field']['meta_keywords'] = array('type'=>'textarea','rules'=>'trim|required');
		$config['field']['meta_description'] = array('type'=>'textarea','rules'=>'trim|required');
		$config['field']['backup_path'] = array('rules'=>'trim|required');
		$config['field']['site_status'] = array('type'=>'boolean');	
		$config['field']['offline_message'] = array('type'=>'textarea','rules'=>'trim|required');			
		$config['field']['allow_user_registration'] = array('type'=>'boolean');
		$config['field']['activation_method'] = array('type'=>'dropdown','params'=>array('options'=>array('none'=>$this->lang->line('preference_field_activation_method_none'),'email'=>$this->lang->line('preference_field_activation_method_email'),'admin'=>$this->lang->line('preference_field_activation_method_admin'))));
		$config['field']['account_activation_time'] = array('rules'=>'trim|required|numeric');
		$config['field']['autologin_period'] = array('rules'=>'trim|required|numeric');
		$config['field']['default_user_group'] = array('type'=>'dropdown','params'=>array('options'=>$this->access_control_model->buildACLDropdown('group','id')));
		$config['field']['allow_user_profiles'] = array('type'=>'boolean');
		$config['field']['login_field'] = array('type'=>'dropdown','params'=>array('options'=>array('email'=>$this->lang->line('userlib_email'),'username'=>$this->lang->line('userlib_username'),'either'=>$this->lang->line('userlib_email_username'))));

		$config['field']['use_login_captcha'] = array('type'=>'boolean');
		$config['field']['use_registration_captcha'] = array('type'=>'boolean');
		$config['field']['min_password_length'] = array('rules'=>'trim|required|numeric');

		$config['field']['automated_from_email'] = array('rules'=>'trim|valid_email');
		$config['field']['email_protocol'] = array('type'=>'dropdown','params'=>array('options'=>array('sendmail'=>'Sendmail','mail'=>'PHP Mail','smtp'=>'SMTP')));
		$config['field']['smtp_port'] = array('rules'=>'trim|numeric');
		$config['field']['smtp_timeout'] = array('rules'=>'trim|numeric');
		$config['field']['email_mailtype'] = array('type'=>'dropdown','params'=>array('options'=>array('text'=>'Plaintext','html'=>'HTML')));
		$config['field']['email_wordwrap'] = array('type'=>'boolean');
		$config['field']['email_wrapchars'] = array('rules'=>'trim|numeric');
		$config['field']['bcc_batch_mode'] = array('type'=>'boolean');
		$config['field']['bcc_batch_size'] = array('rules'=>'trim|numeric');

		$config['field']['page_debug'] = array('type'=>'boolean');
		$config['field']['keep_error_logs_for'] = array('rules'=>'trim|required|numeric');

		$config['field']['google_analytics_tracking_code'] = array('rules'=>'trim|required');
		$config['field']['activate_google_analytics'] =array('type'=>'boolean');

		// Display the form
		$this->load->module_library('preferences','preference_form');
		$this->preference_form->initalize($config);
		$data['header'] = $this->preference_form->form_name;
		$data['content'] = $this->preference_form->display();
		$this->load->view($this->_container,$data);
	}
}
/* End of file settings.php */
/* Location: ./system/application/controllers/admin/settings.php */