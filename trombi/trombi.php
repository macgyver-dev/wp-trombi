<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.linkedin.com/in/julien-dubromez-1240a5168
 * @since             1.0.0
 * @package           Trombin
 *
 * @wordpress-plugin
 * Plugin Name:       Trombin
 * Plugin URI:        ''
 * Description:      Member display plugin for wordpress with Grid and Isotope View.
 * Version:           1.0.0
 * Author:            Julien Dubromez
 * Author URI:        https://www.linkedin.com/in/julien-dubromez-1240a5168
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       trombin
 * Domain Path:       /languages
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require( 'init.php' );
$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
define( 'TROMBI_VERSION', $plugin_data['Version']);
define( 'TROMBI_SLUG', 'trombi');
define( 'TROMBI_PLUGIN_PATH', dirname( __FILE__ ));
define( 'TROMBI_PLUGIN_ACTIVE_FILE_NAME', plugin_basename( __FILE__ ));
define( 'TROMBI_PLUGIN_URL', plugins_url( '' , __FILE__ ));
define( 'TROMBI_PLUGIN_DIR', plugin_dir_path(__FILE__ ));
