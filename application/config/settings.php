<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * An open source development control panel written in PHP
 *
 * @package		BackendPro
 * @author		Adam Price
 * @copyright	Copyright (c) 2008, Adam Price
 * @license		http://www.gnu.org/licenses/lgpl.html
 * @link		http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ------------------------------------------------------------------------

define('BEP_VERSION','0.6.1');

/*
 |--------------------------------------------------------------------------
 | BackendPro Database Table Prefix
 |--------------------------------------------------------------------------
 | This is the table prefix which will be placed before
 | each table name which BackendPro uses
 */
$config['table_prefix'] = 'be_';

/*
 |--------------------------------------------------------------------------
 | View File Locations
 |--------------------------------------------------------------------------
 | Contains variables setting where the default view file directories are located.
 | All must be defined with trailing slashes, apart from BE_template_dir which is
 | blank by default
 */
$config['theme'] = "default"; 
$config['backendpro_template_dir'] = "";
$config['template_public'] = $config['backendpro_template_dir'] . "public/";
$config['template_admin'] = $config['backendpro_template_dir'] . "admin/";

/* End of file backendpro.php */
/* Location: system/application/config/backendpro.php */