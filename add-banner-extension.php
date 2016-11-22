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
new add_Banner_Extension();

class add_Banner_Extension {
	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Admin menu.
	 */
	public function admin_menu (){
		add_menu_page(
			'Add Banner Extension',
			'Add Banner',
			'manage_options',
			'my-page',
			array( $this, 'test' ),
			'dashicons-admin-media'
		);
	}

	public function test () {
		echo "include_once('xxxx.php')";
	}
}