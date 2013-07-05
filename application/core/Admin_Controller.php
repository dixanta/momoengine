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
 * Admin_Controller
 *
 * Extends the Site_Controller class so I can declare special Admin controllers
 *
 * @package       	BackendPro
 * @subpackage      Controllers
 */
class Admin_Controller extends Site_Controller
{
	var $user_id;
	function __construct()
	{
		parent::__construct();

		// Set container variable
		$this->_container = $this->config->item('template_admin') . "container.php";

		// Set Pop container variable
		$this->_popup_container = $this->config->item('template_admin') . "popup.php";

		// Make sure user is logged in
		check('Control Panel');
		$this->load->helper(array('easyui','paging'));
		// Check to see if the install path still exists
		if( is_dir('install'))
		{
			flashMsg('warning',$this->lang->line('backendpro_remove_install'));
		}
		
		$this->user_id = $this->session->userdata('id');

		// Set private meta tags
		//$this->bep_site->set_metatag('name','content',TRUE/FALSE);
		$this->bep_site->set_metatag('robots','nofollow, noindex');
		$this->bep_site->set_metatag('pragma','nocache',TRUE);

		// Load the ADMIN asset group
		$this->bep_assets->load_asset_group('ADMIN');
		$this->bep_assets->load_asset_group('ADMIN-EXTENDED');
		$this->bep_assets->load_asset_group('EASYUI');
		$this->bep_assets->load_asset_group('EASYUI-EXTENDED');
		//log_message('debug','BackendPro : Admin_Controller class loaded');
	}
}

/* End of Admin_controller.php */
/* Location: ./system/application/libraries/Admin_controller.php */