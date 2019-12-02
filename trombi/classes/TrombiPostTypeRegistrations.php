<?php

if(!class_exists( 'TrombiPostTypeRegistrations' )):

	class  TrombiPostTypeRegistrations {

		public function __construct() {
			add_action( 'init', array( $this, 'register' ) );
		}

		public function register() {
			$this->post_type();
		}

		/**
		 * Register the custom post type.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		protected function post_type() {
			global $trombi;
			$trombi_labels = array(
				'name'               => _x( 'Trombi', TROMBI_SLUG ),
				'singular_name'      => _x( 'Membre', TROMBI_SLUG ),
				'menu_name'          => __( 'Trombi', TROMBI_SLUG ),
				'name_admin_bar'     => __( 'Membre', TROMBI_SLUG ),
				'parent_item_colon'  => __( 'Membre Parent:', TROMBI_SLUG ),
				'all_items'          => __( 'Tous les Membres', TROMBI_SLUG ),
				'add_new_item'       => __( 'Ajouter un Membre', TROMBI_SLUG ),
				'add_new'            => __( 'Nouveau Membre', TROMBI_SLUG ),
				'new_item'           => __( 'Nouveau Membre', TROMBI_SLUG ),
				'edit_item'          => __( 'Editer un Membre', TROMBI_SLUG ),
				'update_item'        => __( 'Update Membre', TROMBI_SLUG ),
				'view_item'          => __( 'Voir les Membres', TROMBI_SLUG ),
				'search_items'       => __( 'Rechercher un Membre', TROMBI_SLUG ),
				'not_found'          => __( 'Not found', TROMBI_SLUG ),
				'not_found_in_trash' => __( 'Not found in Trash', TROMBI_SLUG ),
			);
			$trombi_args   = array(
				'label'               => __( 'Trombi', TROMBI_SLUG ),
				'description'         => __( 'Membre', TROMBI_SLUG ),
				'labels'              => $trombi_labels,
				'supports'            => array( 'title',  'thumbnail', 'revisions'),
				'hierarchical'        => false,
				'public'              => true,
				'rewrite'             => array( 'slug' => $trombi->post_type_slug ),
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 99,
				'menu_icon'           => 'dashicons-calendar-alt',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);
			register_post_type( $trombi->post_type, $trombi_args );
			flush_rewrite_rules();
		}

	}

endif;
