<?php
/*
Plugin Name: Add Banner Extension
Plugin URI: https://github.com/sararilfy/add-banner-extension
Description: (プラグインの短い説明)
Version: 1.0.0
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
	private $version = '1.0.0';

	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function __construct() {
		register_activation_hook( __FILE__, array( $this, 'create_table' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
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
			'Add Banner Extension',
			'Add Banner',
			'manage_options',
			plugin_basename( __FILE__ ),
			array( $this, 'list_page_render' ),
			'dashicons-admin-media'
		);
		$list_page = add_submenu_page(
			__FILE__,
			'All Settings',
			'All Settings',
			'manage_options',
			plugin_basename( __FILE__ ),
			array( $this, 'list_page_render' )
		);
		$post_page = add_submenu_page(
			__FILE__,
			'Add New',
			'Add New',
			'manage_options',
			plugin_dir_path( __FILE__ ) . 'includes/add-banner-admin-post.php',
			array( $this, 'post_page_render' )
		);

		//add_action( 'admin_print_styles-' . $list_page1, array( $this, 'add_style' ) );
	}

	/**
	 * Admin List Page Template Require.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function list_page_render () {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/add-banner-admin-list.php' );
		new add_Banner_Extension_Admin_List();
	}

	/**
	 * Admin Post Page Template Require.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function post_page_render () {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/add-banner-admin-post.php' );
		new add_Banner_Extension_Admin_Post();
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
}