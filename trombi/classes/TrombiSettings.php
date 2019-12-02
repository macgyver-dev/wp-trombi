<?php

class TrombiSettings
{

    function __construct()
    {
        add_action( 'admin_menu' , array($this, 'trombi_menu_register'));
    }



    /**
     *  Trombi menu addition
     */
    function trombi_menu_register() {
	    $page = add_submenu_page( 'edit.php?post_type=trombi', __('Trombi Settings', TROMBI_SLUG), __('Settings', TROMBI_SLUG), 'administrator', 'trombi_settings', array($this, 'trombi_settings') );
	    add_action('admin_print_styles-' . $page, array( $this,'trombi_style'));
	    add_action('admin_print_scripts-'. $page, array( $this,'trombi_script'));

    }

	function trombi_style(){
		global $trombi;
			wp_enqueue_style( 'css_settings', $trombi->assetsUrl . 'css/settings.css', '',TROMBI_VERSION);
	}


	function trombi_script(){
		global $trombi;
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'trombi_js_settings',  $trombi->assetsUrl. 'js/settings.js', array('jquery','wp-color-picker'), TROMBI_VERSION, true );
		$nonce = wp_create_nonce( $trombi->nonceText() );
		wp_localize_script( 'trombi_js_settings', 'trombi_var', array('trombi_nonce' => $nonce) );
	}

    function trombi_settings(){
        global $trombi;
        $trombi->render('settings');
    }

}
