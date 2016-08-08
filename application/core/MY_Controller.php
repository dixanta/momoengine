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
 * Site_Controller
 *
 * Extends the default CI Controller class so I can declare special site controllers.
 * Also loads the BackendPro library since if this class is part of the BackendPro system
 *
 * @package         BackendPro
 * @subpackage      Controllers
 */
class Site_Controller extends CI_Controller
{
	var $_container;
	function __construct()
	{
		parent::__construct();

		// Load Base CodeIgniter files

		$this->load->helper(array('html','language'));
		// Load Base BackendPro files
		$this->load->config('settings');
		$this->lang->load('backendpro');
		//$this->load->model('base_model');

		// Load site wide modules
		$this->load->module_library('status','status');
		$this->load->module_model('preferences','preference_model','preference');
		$this->load->module_library('site','bep_site');
		$this->load->module_library('site','bep_assets');
		
		$this->load->module_library('auth','userlib');

		// Display page debug messages if needed
		if ($this->preference->item('page_debug'))
		{
			$this->output->enable_profiler(TRUE);
		}

		// Set site meta tags
		//$this->bep_site->set_metatag('name','content',TRUE/FALSE);
		$this->output->set_header('Content-Type: text/html; charset='.config_item('charset'));
		$this->bep_site->set_metatag('content-type','text/html; charset='.config_item('charset'),TRUE);
		$this->bep_site->set_metatag('robots','all');
		$this->bep_site->set_metatag('pragma','cache',TRUE);

		// Load the SITE asset group
		$this->bep_assets->load_asset_group('SITE');

		log_message('debug','BackendPro : Site_Controller class loaded');
	}

	function mail_config()
	{
		$config['protocol'] = $this->preference->item('email_protocol');
		//$config['mailpath'] = $this->preference->item('email_mailpath');
		$config['smtp_host'] = $this->preference->item('smtp_host');
		//$config['smtp_user'] = $this->preference->item('smtp_user');
		//$config['smtp_pass'] = $this->preference->item('smtp_pass');
		$config['smtp_port'] = $this->preference->item('smtp_port');
		$config['smtp_timeout'] = $this->preference->item('smtp_timeout');
		$config['wordwrap'] = $this->preference->item('email_wordwrap');
		$config['wrapchars'] = $this->preference->item('email_wrapchars');
		$config['mailtype'] = $this->preference->item('email_mailtype');
		$config['charset'] = $this->preference->item('email_charset');
		$config['bcc_batch_mode'] = $this->preference->item('bcc_batch_mode');
		$config['bcc_batch_size'] = $this->preference->item('bcc_batch_size');	
		return $config;
	}	
}

include_once("Admin_Controller.php");
include_once("Public_Controller.php");
include_once("Member_Controller.php");
include_once("API_Controller.php");
/* End of file MY_Controller.php */
/* Location: ./system/application/libraries/MY_Controller.php */