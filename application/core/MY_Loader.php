<?php

/**
 * Matchbox Loader class
 *
 * This file is part of Matchbox
 *
 * Matchbox is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * Matchbox is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package   Matchbox
 * @copyright 2007-2008 Zacharias Knudsen
 * @license   http://www.gnu.org/licenses/gpl.html
 * @version   $Id: Loader.php 205 2008-02-24 01:43:55Z zacharias@dynaknudsen.dk $
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Replaces the CodeIgniter Loader class
 *
 * All code not encapsulated in {{{ Matchbox }}} was made by EllisLab
 *
 * @package   Matchbox
 * @copyright 2007-2008 Zacharias Knudsen
 * @license   http://www.gnu.org/licenses/gpl.html
 */
class MY_Loader extends CI_Loader
{
    // {{{ Matchbox

    /**
     * The Matchbox object
     *
     * @var    object
     * @access private
     */
    var $_matchbox;

    /**
     * Loads library from module
     *
     * @param  string
     * @param  string
     * @param  mixed
     * @return void
     * @access public
     */
    function module_library($module, $library = '', $params = null)
    {
        return $this->library($library, $params, $module);
    }

    /**
     * Loads model from module
     *
     * @param  string
     * @param  string
     * @param  string
     * @param  mixed
     * @return void
     * @access public
     */
    function module_model($module, $model, $name = '', $db_conn = false)
    {
        return $this->model($model, $name, $db_conn, $module);
    }

    /**
     * Loads view from module
     *
     * @param  string
     * @param  string
     * @param  array
     * @param  bool
     * @return void
     * @access public
     */
    function module_view($module, $view, $vars = array(), $return = false)
    {
        return $this->view($view, $vars, $return, $module);
    }

    /**
     * Loads file from module
     *
     * @param  string
     * @param  string
     * @param  bool
     * @return void
     * @access public
     */
    function module_file($module, $path, $return = false)
    {
        return $this->file($path, $return, $module);
    }

    /**
     * Loads helper from module
     *
     * @param  string
     * @param  mixed
     * @return void
     * @access public
     */
    function module_helper($module, $helpers = array())
    {
        return $this->helper($helpers, $module);
    }

    /**
     * Loads language file from module
     *
     * @param  string
     * @param  mixed
     * @param  string
     * @return void
     * @access public
     */
    function module_language($module, $file = array(), $lang = '')
    {
        return $this->language($file, $lang, $module);
    }

    /**
     * Loads config file from module
     *
     * @param  string
     * @param  string
     * @param  bool
     * @param  bool
     * @return void
     * @access public
     */
    function module_config($module, $file = '', $use_sections = false, $fail_gracefully = false)
    {
        return $this->config($file, $use_sections, $fail_gracefully, $module);
    }

    //}}}

    // All these are set automatically. Don't mess with them.
    var $_ci_ob_level;
	protected $_ci_view_paths		= array();
	protected $_ci_library_paths	= array();
	protected $_ci_model_paths		= array();
	protected $_ci_helper_paths		= array();
    var $_ci_cached_vars    = array();
    var $_ci_classes        = array();
    var $_ci_models            = array();
    var $_ci_helpers        = array();
    var $_ci_plugins        = array();
    var $_ci_scripts        = array();
    var $_ci_varmap            = array('unit_test' => 'unit', 'user_agent' => 'agent');


    /**
     * Constructor
     *
     * Sets the path to the view files and gets the initial output buffering level
     *
     * @access    public
     */
    function __construct()
    {
        // {{{ Matchbox

        $this->_matchbox = &load_class('Matchbox');
        // }}}

        $this->_ci_is_php5 = (floor(phpversion()) >= 5) ? TRUE : FALSE;
		$this->_ci_library_paths = array(APPPATH, BASEPATH);
        $this->_ci_view_path = APPPATH.'views/';
        $this->_ci_ob_level  = ob_get_level();

        log_message('debug', "Loader Class Initialized");
    }

	// --------------------------------------------------------------------
	
	/**
	 * Set _base_classes variable
	 *
	 * This method is called once in CI_Controller.
	 *
	 * @param 	array 	
	 * @return 	object
	 */
	public function set_base_classes()
	{
		$this->_base_classes =& is_loaded();
		
		return $this;
	}

    // --------------------------------------------------------------------

    /**
     * Class Loader
     *
     * This function lets users load and instantiate classes.
     * It is designed to be called from a user's app controllers.
     *
     * @access    public
     * @param    string    the name of the class
     * @param    mixed    the optional parameters
     * @return    void
     */
    function library($library = '', $params = NULL,$object_name=NULL)
    {
        if ($library == '')
        {
            return FALSE;
        }

        // {{{ Matchbox

        $module = $this->_matchbox->argument(2);

        if (is_array($library)) {
            foreach ($library as $class) {
                $this->_ci_load_class($class, $params, $module);
            }
        } else {
            $this->_ci_load_class($library, $params, $module);
        }

        // }}}

       // $this->_ci_assign_to_models();
    }

    // --------------------------------------------------------------------

    /**
     * Model Loader
     *
     * This function lets users load and instantiate models.
     *
     * @access    public
     * @param    string    the name of the class
     * @param    mixed    any initialization parameters
     * @return    void
     */
    function model($model, $name = '', $db_conn = FALSE)
    {
        if (is_array($model))
        {
            foreach($model as $babe)
            {
                $this->model($babe);
            }
            return;
        }

        if ($model == '')
        {
            return;
        }

        // Is the model in a sub-folder? If so, parse out the filename and path.
        if (strpos($model, '/') === FALSE)
        {
            $path = '';
        }
        else
        {
            $x = explode('/', $model);
            $model = end($x);
            unset($x[count($x)-1]);
            $path = implode('/', $x).'/';
        }

        if ($name == '')
        {
            $name = $model;
        }

        if (in_array($name, $this->_ci_models, TRUE))
        {
            return;
        }

        $CI =& get_instance();
        if (isset($CI->$name))
        {
            show_error('The model name you are loading is the name of a resource that is already being used: '.$name);
        }

        $model = strtolower($model);

        // {{{ Matchbox

        $module = $this->_matchbox->argument(3);
		
        if (!$filepath = $this->_matchbox->find('models/' . $path . $model . EXT, $module)) {
            show_error('Unable to locate the model you have specified: ' . $model);
        }

        // }}}

        if ($db_conn !== FALSE AND ! class_exists('CI_DB'))
        {
            if ($db_conn === TRUE)
                $db_conn = '';

            $CI->load->database($db_conn, FALSE, TRUE);
        }

			if ( ! class_exists('CI_Model'))
			{
				load_class('Model', 'core');
			}

        // {{{ Matchbox

        require_once($filepath);

        // }}}

        $model = ucfirst($model);

        $CI->$name = new $model();
        //$CI->$name->_assign_libraries();

        $this->_ci_models[] = $name;
		return;
    }

    // --------------------------------------------------------------------

    /**
     * Load View
     *
     * This function is used to load a "view" file.  It has three parameters:
     *
     * 1. The name of the "view" file to be included.
     * 2. An associative array of data to be extracted for use in the view.
     * 3. TRUE/FALSE - whether to return the data or load it.  In
     * some cases it's advantageous to be able to return data so that
     * a developer can process it in some way.
     *
     * @access    public
     * @param    string
     * @param    array
     * @param    bool
     * @return    void
     */
	public function view($view, $vars = array(), $return = FALSE)
	{
        // {{{ Matchbox

        $module = $this->_matchbox->argument(3);	
		
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return),$module);
	}	

    // --------------------------------------------------------------------

    /**
     * Load File
     *
     * This is a generic file loader
     *
     * @access    public
     * @param    string
     * @param    bool
     * @return    string
     */
    function file($path, $return = FALSE)
    {
        // {{{ Matchbox

        $module = $this->_matchbox->argument(2);

        return $this->_ci_load(array('_ci_path' => $path, '_ci_return' => $return), $module);

        // }}}
    }

    // --------------------------------------------------------------------

    /**
     * Load Helper
     *
     * This function loads the specified helper file.
     *
     * @access    public
     * @param    mixed
     * @return    void
     */
    function helper($helpers = array())
    {
        if ( ! is_array($helpers))
        {
            $helpers = array($helpers);
        }

        foreach ($helpers as $helper)
        {
            $helper = strtolower(str_replace(EXT, '', str_replace('_helper', '', $helper)).'_helper');

            if (isset($this->_ci_helpers[$helper]))
            {
                continue;
            }

            // {{{ Matchbox

            $module = $this->_matchbox->argument(1);

            if ($ext_helper = $this->_matchbox->find('helpers/' . config_item('subclass_prefix') . $helper . EXT, $module)) {
                $base_helper = BASEPATH . 'helpers/' . $helper . EXT;

                if (!file_exists($base_helper)) {
                    show_error('Unable to load the requested file: helpers/' . $helper . EXT);
                }

                include_once($ext_helper);
                include_once($base_helper);
            } elseif ($filepath = $this->_matchbox->find('helpers/' . $helper . EXT, $module, 2)) {
                include($filepath);
            } else {
                show_error('Unable to load the requested file: helpers/' . $helper . EXT);
            }

            // }}}

            $this->_ci_helpers[$helper] = TRUE;

        }

        log_message('debug', 'Helpers loaded: '.implode(', ', $helpers));
    }

    // --------------------------------------------------------------------

    /**
     * Load Helpers
     *
     * This is simply an alias to the above function in case the
     * user has written the plural form of this function.
     *
     * @access    public
     * @param    array
     * @return    void
     */
    function helpers($helpers = array())
    {
        $this->helper($helpers);
    }

    // --------------------------------------------------------------------

    /**
     * Loads a language file
     *
     * @access    public
     * @param    array
     * @param    string
     * @return    void
     */
    function language($file = array(), $lang = '')
    {
        $CI =& get_instance();

        if ( ! is_array($file))
        {
            $file = array($file);
        }

        foreach ($file as $langfile)
        {
            // {{{ Matchbox

            $module = $this->_matchbox->argument(2);

            $CI->lang->load($langfile, $lang, false, $module);

            // }}}
        }
    }

    // --------------------------------------------------------------------

    /**
     * Loads a config file
     *
     * @access    public
     * @param    string
     * @return    void
     */
    function config($file = '', $use_sections = FALSE, $fail_gracefully = FALSE)
    {
        $CI =& get_instance();

        // {{{ Matchbox

        $module = $this->_matchbox->argument(3);

        $CI->config->load($file, $use_sections, $fail_gracefully, $module);

        // }}}
    }


    // --------------------------------------------------------------------

    /**
     * Loader
     *
     * This function is used to load views and files.
     * Variables are prefixed with _ci_ to avoid symbol collision with
     * variables made available to view files
     *
     * @access    private
     * @param    array
     * @return    void
     */
    function _ci_load($_ci_data)
    {
		// Set the default data variables
		foreach (array('_ci_view', '_ci_vars', '_ci_path', '_ci_return') as $_ci_val)
		{
			$$_ci_val = ( ! isset($_ci_data[$_ci_val])) ? FALSE : $_ci_data[$_ci_val];
		}

		$file_exists = FALSE;
        // Set the path to the requested file
        // {{{ Matchbox

        if ($_ci_path == '')
        {
            $_ci_ext  = pathinfo($_ci_view, PATHINFO_EXTENSION);
            $_ci_file = ($_ci_ext == '') ? $_ci_view . EXT : $_ci_view;
            $_ci_path = str_replace(APPPATH, '', $this->_ci_view_path) . $_ci_file;
            $search   = 1;
        }
        else
        {
            $_ci_x    = explode('/', $_ci_path);
            $_ci_file = end($_ci_x);
            $search   = 3;
        }

        $module = $this->_matchbox->argument(1);

        if (!$_ci_path = $this->_matchbox->find($_ci_path, $module, $search)) {
			foreach ($this->_ci_view_paths as $view_file => $cascade)
			{
				if (file_exists($view_file.$_ci_file))
				{
					$_ci_path = $view_file.$_ci_file;
					$file_exists = TRUE;
					break;
				}

				if ( ! $cascade)
				{
					break;
				}
			}
			if ( ! $file_exists && ! file_exists($_ci_path))
			{
				show_error('Unable to load the requested file: '.$_ci_file);
			}						
        //    show_error('Unable to load the requested file: ' . $_ci_file);
        }

        // }}}

        // This allows anything loaded using $this->load (views, files, etc.)
        // to become accessible from within the Controller and Model functions.
        // Only needed when running PHP 5

		$_ci_CI =& get_instance();
		foreach (get_object_vars($_ci_CI) as $_ci_key => $_ci_var)
		{
			if ( ! isset($this->$_ci_key))
			{
				$this->$_ci_key =& $_ci_CI->$_ci_key;
			}
		}

        /*
         * Extract and cache variables
         *
         * You can either set variables using the dedicated $this->load_vars()
         * function or via the second parameter of this function. We'll merge
         * the two types and cache them so that views that are embedded within
         * other views can have access to these variables.
         */
        if (is_array($_ci_vars))
        {
            $this->_ci_cached_vars = array_merge($this->_ci_cached_vars, $_ci_vars);
        }
        extract($this->_ci_cached_vars);

        /*
         * Buffer the output
         *
         * We buffer the output for two reasons:
         * 1. Speed. You get a significant speed boost.
         * 2. So that the final rendered template can be
         * post-processed by the output class.  Why do we
         * need post processing?  For one thing, in order to
         * show the elapsed page load time.  Unless we
         * can intercept the content right before it's sent to
         * the browser and then stop the timer it won't be accurate.
         */
        ob_start();

        // If the PHP installation does not support short tags we'll
        // do a little string replacement, changing the short tags
        // to standard PHP echo statements.

        if ((bool) @ini_get('short_open_tag') === FALSE AND config_item('rewrite_short_tags') == TRUE)
        {
            echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?php print ', '<?php echo ', file_get_contents($_ci_path))).'<?php ');
        }
        else
        {
            include($_ci_path);
        }

        log_message('debug', 'File loaded: '.$_ci_path);

        // Return the file data if requested
        if ($_ci_return === TRUE)
        {
            $buffer = ob_get_contents();
            @ob_end_clean();
            return $buffer;
        }

        /*
         * Flush the buffer... or buff the flusher?
         *
         * In order to permit views to be nested within
         * other views, we need to flush the content back out whenever
         * we are beyond the first level of output buffering so that
         * it can be seen and included properly by the first included
         * template and any subsequent ones. Oy!
         *
         */
        if (ob_get_level() > $this->_ci_ob_level + 1)
        {
            ob_end_flush();
        }
        else
        {
            // PHP 4 requires that we use a global
            global $OUT;
            $OUT->append_output(ob_get_contents());
            @ob_end_clean();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load class
     *
     * This function loads the requested class.
     *
     * @access    private
     * @param     string    the item that is being loaded
     * @param    mixed    any additional parameters
     * @return     void
     */
    function _ci_load_class($class, $params = NULL, $object_name = NULL)
    {
        // Get the class name
        $class = str_replace(EXT, '', $class);
		// Was the path included with the class name?
		// We look for a slash to determine this
		$subdir = '';
		if (($last_slash = strrpos($class, '/')) !== FALSE)
		{
			// Extract the path
			$subdir = substr($class, 0, $last_slash + 1);

			// Get the filename from the path
			$class = substr($class, $last_slash + 1);
			//echo $subdir;
		}		

        // We'll test for both lowercase and capitalized versions of the file name
        foreach (array(ucfirst($class), strtolower($class)) as $class)
        {
            // {{{ Matchbox

            $module = $this->_matchbox->argument(2);

            if ($subclass = $this->_matchbox->find('libraries/' . config_item('subclass_prefix') . $class . EXT, $module)) {

                $baseclass = $this->_matchbox->find('libraries/' . $class . EXT, $module, 2);

                // }}}

                if ( ! file_exists($baseclass))
                {
                    log_message('error', "Unable to load the requested class: ".$class);
                    show_error("Unable to load the requested class: ".$class);
                }

                // Safety:  Was the class already loaded by a previous call?
                if (in_array($subclass, $this->_ci_loaded_files))
                {
                    $is_duplicate = TRUE;
                    log_message('debug', $class." class already loaded. Second attempt ignored.");
                    return;
                }

                include($baseclass);
                include($subclass);
                $this->_ci_loaded_files[] = $subclass;

                // {{{ Matchbox

                return $this->_ci_init_class($class, config_item('subclass_prefix'), $params, $module);

                // }}}
            }

            // Lets search for the requested library file and load it.
            $is_duplicate = FALSE;

            // {{{ Matchbox

            if ($filepath = $this->_matchbox->find('libraries/' . $class . EXT, $module, 2)) {
                if (in_array($class, $this->_ci_loaded_files)) {
                    $is_duplicate = true;
                    log_message('debug', $class . ' class already loaded. Second attempt ignored.');
                    return;
                }

                include($filepath);
                $this->_ci_loaded_files[] = $class;
                return $this->_ci_init_class($class, '', $params, $module);
            }

			foreach ($this->_ci_library_paths as $path)
			{

				$filepath = $path.'libraries/'.$subdir.$class.'.php';

				// Does the file exist?  No?  Bummer...
				if ( ! file_exists($filepath))
				{
					continue;
				}

				// Safety:  Was the class already loaded by a previous call?
				if (in_array($filepath, $this->_ci_loaded_files))
				{
					// Before we deem this to be a duplicate request, let's see
					// if a custom object name is being supplied.  If so, we'll
					// return a new instance of the object
					$is_duplicate = TRUE;
					log_message('debug', $class." class already loaded. Second attempt ignored.");
					return;
				}

				include_once($filepath);
				$this->_ci_loaded_files[] = $filepath;
				return $this->_ci_init_class($class, '', $params, $module);
			}			

            // }}}

        } // END FOREACH

        // If we got this far we were unable to find the requested class.
        // We do not issue errors if the load call failed due to a duplicate request
        if ($is_duplicate == FALSE)
        {
            log_message('error', "Unable to load the requested class: ".$class);
            show_error("Unable to load the requested class: ".$class);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Instantiates a class
     *
     * @access    private
     * @param    string
     * @param    string
     * @return    null
     */
    function _ci_init_class($class, $prefix = '', $config = FALSE, $object_name = NULL)
    {
        $class = strtolower($class);

        // Is there an associated config file for this class?
        // {{{ Matchbox

       $module = $this->_matchbox->argument(3);

       /* if ($config === NULL) {

        }*/

        // }}}

		// Is there an associated config file for this class?  Note: these should always be lowercase
		if ($config === NULL)
		{
            if ($filepath = $this->_matchbox->find('config/' . $class . EXT, $module)) {
				include($filepath);
            }			
			// Fetch the config paths containing any package paths
			$config_component = $this->_ci_get_component('config');

			if (is_array($config_component->_config_paths))
			{
				// Break on the first found file, thus package files
				// are not overridden by default paths
				foreach ($config_component->_config_paths as $path)
				{
					// We test for both uppercase and lowercase, for servers that
					// are case-sensitive with regard to file names. Check for environment
					// first, global next
					if (defined('ENVIRONMENT') AND file_exists($path .'config/'.ENVIRONMENT.'/'.strtolower($class).'.php'))
					{
						include($path .'config/'.ENVIRONMENT.'/'.strtolower($class).'.php');
						break;
					}
					elseif (defined('ENVIRONMENT') AND file_exists($path .'config/'.ENVIRONMENT.'/'.ucfirst(strtolower($class)).'.php'))
					{
						include($path .'config/'.ENVIRONMENT.'/'.ucfirst(strtolower($class)).'.php');
						break;
					}
					elseif (file_exists($path .'config/'.strtolower($class).'.php'))
					{
						include($path .'config/'.strtolower($class).'.php');
						break;
					}
					elseif (file_exists($path .'config/'.ucfirst(strtolower($class)).'.php'))
					{
						include($path .'config/'.ucfirst(strtolower($class)).'.php');
						break;
					}
				}
			}
		}		

        if ($prefix == '')
        {
            $name = (class_exists('CI_'.$class)) ? 'CI_'.$class : $class;
        }
        else
        {
            $name = $prefix.$class;
        }

        // Set the variable name we will assign the class to
        $classvar = ( ! isset($this->_ci_varmap[$class])) ? $class : $this->_ci_varmap[$class];

		// Save the class name and object name
		$this->_ci_classes[$class] = $classvar;
		
        // Instantiate the class
        $CI =& get_instance();

        if ($config !== NULL)
        {
            $CI->$classvar = new $name($config);
        }
        else
        {
            $CI->$classvar = new $name;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Autoloader
     *
     * The config/autoload.php file contains an array that permits sub-systems,
     * libraries, plugins, and helpers to be loaded automatically.
     *
     * @access    private
     * @param    array
     * @return    void
     */
    private function _ci_autoloader()
    {
        // {{{ Matchbox

        $ci = &get_instance();
        $ci->matchbox = &load_class('Matchbox');

        //}}}

		if (defined('ENVIRONMENT') AND file_exists(APPPATH.'config/'.ENVIRONMENT.'/autoload.php'))
		{
			include(APPPATH.'config/'.ENVIRONMENT.'/autoload.php');
		}
		else
		{
			include(APPPATH.'config/autoload.php');
		}

		if ( ! isset($autoload))
		{
			return FALSE;
		}
		
		// Autoload packages
		if (isset($autoload['packages']))
		{
			foreach ($autoload['packages'] as $package_path)
			{
				$this->add_package_path($package_path);
			}
		}		

        // Load any custom config file
        if (count($autoload['config']) > 0)
        {
            // {{{ Matchbox

            foreach ($autoload['config'] as $key => $value) {
                if (is_string($key)) {
                    if (is_array($value)) {
                        foreach ($value as $config) {
                            $ci->config->module_load($key, $config);
                        }
                    } else {
                        $ci->config->module_load($key, $value);
                    }
                } else {
                    $ci->config->load($value);
                }
            }

            // }}}
        }

        // Autoload helpers and languages
        foreach (array('helper', 'language') as $type)
        {
            if (isset($autoload[$type]) AND count($autoload[$type]) > 0)
            {
                // {{{ Matchbox
                foreach ($autoload[$type] as $key => $value) {
                    if (is_string($key)) {
                        $this->{'module_' . $type}($key, $value);
                    } else {
                        $this->$type($value);
                    }
                }
                // }}}
            }
        }

        // A little tweak to remain backward compatible
        // The $autoload['core'] item was deprecated
		if ( ! isset($autoload['libraries']) AND isset($autoload['core']))
		{
			$autoload['libraries'] = $autoload['core'];
		}

        // Load libraries
        if (isset($autoload['libraries']) AND count($autoload['libraries']) > 0)
        {
			// Load the database driver.
			if (in_array('database', $autoload['libraries']))
			{
				$this->database();
				$autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
			}

            // {{{ Matchbox

            foreach ($autoload['libraries'] as $key => $value) {
                if (is_string($key)) {
                    $this->module_library($key, $value);
                } else {
                    $this->library($value);
                }
            }

            // }}}

        }

        // {{{ Matchbox

        if (isset($autoload['model'])) {
            foreach ($autoload['model'] as $key => $value) {
                if (is_string($key)) {
                    $this->module_model($key, $value);
                } else {
                    $this->model($value);
                }
            }
        }

        // }}}

    }


}

