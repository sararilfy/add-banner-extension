<?php
/*
Plugin Name: Add Banner Extension
Plugin URI: https://github.com/sararilfy/add-banner-extension
Description: Register an image from the administration screen, and a different banner image is displayed for each category.
Version: 1.0.3
Author: Yoshie Nakayama
License: GPLv2 or later
Text Domain: add-banner-extension
Domain Path: /languages
*/
require_once ( plugin_dir_path( __FILE__ ) . 'includes/add-banner-admin-db.php');
new add_Banner_Extension();

class add_Banner_Extension {

	/**
	 * Version Information.
	 *
	 * @var string
	 */
	private $version = '1.0.3';

	/**
	 * Text Domain.
	 *
	 * @var string
	 */
	private $text_domain = 'add-banner-extension';

	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function __construct() {
		register_activation_hook( __FILE__, array( $this, 'create_table' ) );
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );

		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		} else {
			add_action( 'the_content', array( $this, 'the_content' ) );
		}
	}

	/**
	 * create_table.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function create_table () {
		$db = new add_Banner_Extension_Admin_Db();
		$db->create_table();
	}

	/**
	 * i18n.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function plugins_loaded () {
		load_plugin_textdomain( $this->text_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * admin_init.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function admin_init () {
		wp_register_style( 'add-banner-extension-admin-style', plugins_url( 'css/style.css', __FILE__ ), array(), $this->version );
	}

	/**
	 * Admin menu.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function admin_menu () {
		add_menu_page(
			__( 'Add Banner Extension' , $this->text_domain ),
			__( 'Add Banner' , $this->text_domain ),
			'manage_options',
			plugin_basename( __FILE__ ),
			array( $this, 'list_page_render' ),
			'dashicons-format-gallery'
		);
		$list_page = add_submenu_page(
			__FILE__,
			__( 'All Banner List' , $this->text_domain ),
			__( 'All Banner List' , $this->text_domain ),
			'manage_options',
			plugin_basename( __FILE__ ),
			array( $this, 'list_page_render' )
		);
		$post_page = add_submenu_page(
			__FILE__,
			__( 'Add New' , $this->text_domain ),
			__( 'Add New' , $this->text_domain ),
			'manage_options',
			plugin_dir_path( __FILE__ ) . 'includes/add-banner-admin-post.php',
			array( $this, 'post_page_render' )
		);

		add_action( 'admin_print_styles-' . $list_page, array( $this, 'add_style' ) );
		add_action( 'admin_print_styles-' . $post_page, array( $this, 'add_style' ) );
		add_action( 'admin_print_scripts-' . $post_page, array( $this, 'add_scripts' ) );
	}

	/**
	 * Admin List Page Template Require.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function list_page_render () {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/add-banner-admin-list.php' );
		new add_Banner_Extension_Admin_List( $this->text_domain );
	}

	/**
	 * Admin Post Page Template Require.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function post_page_render () {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/add-banner-admin-post.php' );
		new add_Banner_Extension_Admin_Post( $this->text_domain );
	}

	/**
	 * Admin CSS Add.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function add_style () {
		wp_enqueue_style( 'add-banner-extension-admin-style' );
	}

	/**
	 * Admin Scripts Add.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function add_scripts () {
		wp_enqueue_media();
	}

	/**
	 * Display Banner
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   string $content
	 * @return  string $content
	 */
	public function the_content ( $content ) {

		if ( !is_single() ) {
			return $content;
		}

		$html = '';
		$categories = get_the_category();

		if ( count( $categories ) > 0 ) {

			require_once( plugin_dir_path( __FILE__ ) . 'includes/add-banner-admin-db.php' );
			$db = new add_Banner_Extension_Admin_Db();
			$args = $db->get_categories( $categories[0]->cat_ID );

			foreach ( $args as $value ) {

				$html .= '<div class="add-banner-extension-wrapper">';
				if ( !empty( $value->link_url ) ) {
					if ( $value->open_new_tab == 1 ) {
						$html .= '<a href="' . esc_url( $value->link_url ) . '" target="_blank">';
					} else {
						$html .= '<a href="' . esc_url( $value->link_url ) . '">';
					}
				}

				$html .= '<img src="' . esc_url( $value->image_url ) . '" alt="' . esc_attr( $value->image_alt ) . '"';

				if ( !empty( $value->insert_element_class ) ) {
					$html .= ' class="' . esc_attr( $value->insert_element_class ) . '"';
				}

				if ( !empty( $value->insert_element_id ) ) {
					$html .= ' id="' . esc_attr( $value->insert_element_id ) . '"';
				}

				$html .= '>';

				if ( !empty( $value->image_url ) ) {
					$html .= '</a>';
				}
				$html .= '</div>';

			}

		}

		return $content . $html;
	}
}