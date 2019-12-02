<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * @link       https://www.linkedin.com/in/julien-dubromez-1240a5168
 * @since      1.0.0
 *
 * @package    Trombin
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

$table_name = $wpdb->prefix . 'trombi_professions';
$wpdb->query( "DROP TABLE IF EXISTS $table_name");
$table_name = $wpdb->prefix . 'trombi_members';
$wpdb->query( "DROP TABLE IF EXISTS $table_name" );