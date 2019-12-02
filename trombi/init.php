<?php

class TrombiLoader {
	public $options;

	function __construct() {

		$this->options = array(
			'settings'          => 'trombi_settings',
			'version'           => TROMBI_VERSION,
			'feature_img_size'  => 'trombi-thumb',
			'installed_version' => 'trombi_installed_version'
		);

		$this->post_type      = 'trombi';
		$settings             = get_option( $this->options['settings'] );
		$this->post_type_slug = isset( $settings['slug'] ) ? ( $settings['slug'] ? sanitize_title_with_dashes( $settings['slug'] ) : 'trombi' ) : 'trombi';
		$this->incPath        = dirname( __FILE__ );
		$this->classesPath    = $this->incPath . '/classes/';
		$this->viewsPath      = $this->incPath . '/views/';
		$this->assetsUrl = TROMBI_PLUGIN_URL . '/assets/';

		$this->LoadClass( $this->classesPath );

		register_activation_hook( TROMBI_PLUGIN_ACTIVE_FILE_NAME, array( $this, 'activate' ) );
		register_deactivation_hook( TROMBI_PLUGIN_ACTIVE_FILE_NAME, array( $this, 'deactivate' ) );

	}

	public function activate() {

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$trombi_professions_table = $wpdb->prefix . 'trombi_professions';
		$wpdb->query("CREATE TABLE IF NOT EXISTS $trombi_professions_table (
          id int NOT NULL AUTO_INCREMENT,
          Professions varchar(45) NOT NULL,
          PRIMARY KEY  (id)
         )$charset_collate;");

		$charset_collate = $wpdb->get_charset_collate();
		$trombi_member_table = $wpdb->prefix . 'trombi_members';
		$wpdb->query("CREATE TABLE IF NOT EXISTS $trombi_member_table (
		id int NOT NULL AUTO_INCREMENT,
		lastName varchar(45)  NOT NULL,
		firstName varchar(45)  NOT NULL,
		profession varchar(45)  NOT NULL,
		phone varchar(45)  NOT NULL,
		short_bio  varchar(150)  NOT NULL,
		PRIMARY KEY  (id)
	 )$charset_collate;");

		flush_rewrite_rules();

		$this->insertDefaultData();
	}

	public function deactivate() {
		flush_rewrite_rules();
	}



	function LoadClass( $dir ) {
		if ( ! file_exists( $dir ) ) {
			return;
		}
		$classes = array();

		foreach ( scandir( $dir ) as $item ) {
			if ( preg_match( "/.php$/i", $item ) ) {
				require_once( $dir . $item );
				$className = str_replace( ".php", "", $item );
				$classes[] = new $className;
			}
		}

		if ( $classes ) {
			foreach ( $classes as $class ) {
				$this->objects[] = $class;
			}
		}
	}




	function render( $viewName, $args = array() ) {
		global $trombi;

		$viewPath = $trombi->viewsPath . $viewName . '.php';
		if ( ! file_exists( $viewPath ) ) {
			return;
		}

		if ( $args ) {
			extract( $args );
		}
		$pageReturn = include $viewPath;
		if ( $pageReturn AND $pageReturn <> 1 ) {
			return $pageReturn;
		}
	}



	function __call( $name, $args ) {
		if ( ! is_array( $this->objects ) ) {
			return;
		}
		foreach ( $this->objects as $object ) {
			if ( method_exists( $object, $name ) ) {
				$count = count( $args );
				if ( $count == 0 ) {
					return $object->$name();
				} elseif ( $count == 1 ) {
					return $object->$name( $args[0] );
				} elseif ( $count == 2 ) {
					return $object->$name( $args[0], $args[1] );
				} elseif ( $count == 3 ) {
					return $object->$name( $args[0], $args[1], $args[2] );
				} elseif ( $count == 4 ) {
					return $object->$name( $args[0], $args[1], $args[2], $args[3] );
				} elseif ( $count == 5 ) {
					return $object->$name( $args[0], $args[1], $args[2], $args[3], $args[4] );
				} elseif ( $count == 6 ) {
					return $object->$name( $args[0], $args[1], $args[2], $args[3], $args[4], $args[5] );
				}
			}
		}
	}

	private function insertDefaultData() {
		global $trombi;
		update_option( $trombi->options['installed_version'], $trombi->options['version'] );
		if ( ! get_option( $trombi->options['settings'] ) ) {
			update_option( $trombi->options['settings'], $trombi->defaultSettings );
		}
	}

}

global $trombi;
if ( ! is_object( $trombi ) ) {
	$trombi = new TrombiLoader;
}
