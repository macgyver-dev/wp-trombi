<?php
if ( ! class_exists( 'TrombiFrontEnd' ) ) :

	class TrombiFrontEnd {

		function __construct() {

			add_action( 'init', array( $this, 'trombi_front_end' ) );
		}

		function trombi_front_end() {
			//wp_enqueue_script( 'front-end',TROMBI_PLUGIN_URL . '/assets/js/isotope.pkgd.min.js', array('jquery', 'imagesloaded'), TROMBI_VERSION, true );
			//wp_enqueue_script( 'isotop-init', TROMBI_PLUGIN_URL . '/assets/js/isotop.js', array('jquery'), TROMBI_VERSION, true );
		}

	}
endif;
