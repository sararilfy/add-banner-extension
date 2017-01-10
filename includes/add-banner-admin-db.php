<?php

/**
 * Class add_Banner_Extension_Admin_Db
 *
 * @author Yoshie Nakayama
 * @since  1.0.0
 */
class add_Banner_Extension_Admin_Db {

	private $table_name;

	/**
	 * add_Banner_Extension_Admin_Db constructor.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'add_banner_extension';
	}

	/**
	 * create_table.
	 *
	 * @since 1.0.0
	 */
	public function create_table() {
		global $wpdb;

		$prepared     = $wpdb->prepare( "SHOW TABLES LIKE %s", $this->table_name );
		$is_db_exists = $wpdb->get_var( $prepared );

		if ( is_null( $is_db_exists ) ) {
			$charset_collate = $wpdb->get_charset_collate();

			$query  = "CREATE TABLE " . $this->table_name;
			$query .= "(id MEDIUMINT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
			$query .= "image_url TEXT NOT NULL,";
			$query .= "image_alt TEXT,";
			$query .= "link_url TEXT,";
			$query .= "open_new_tab BOOLEAN DEFAULT FALSE,";
			$query .= "insert_element_class TINYTEXT,";
			$query .= "register_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,";
			$query .= "update_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,";
			$query .= "UNIQUE KEY id(id)";
			$query .= ") " . $charset_collate;

			require_once ( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $query );
		}

	}

	/**
	 * insert_table.
	 *
	 * @since 1.0.0
	 * @param array $post
	 * @return int
	 */
	public function insert_table( array $post ) {
		global $wpdb;

		$data = array(
			'image_url'            => strip_tags( $post['banner-image-url'] ),
			'image_alt'            => strip_tags( $post['banner-image-alt'] ),
			'link_url'             => strip_tags( $post['banner-image-link'] ),
			'open_new_tab'         => isset( $post['banner-image-target'] ) ? (int) $post['banner-image-target'] : 0,
			'insert_element_class' => strip_tags( $post['banner-element-class'] ),
			'register_date'        => date( "Y-m-d H:i:s" ),
			'update_date'          => date( "Y-m-d H:i:s" )
		);

		$prepared = array(
			'%s',
			'%s',
			'%s',
			'%d',
			'%s',
			'%s',
			'%s'
		);

		$wpdb->insert( $this->table_name, $data, $prepared );
		return (int) $wpdb->insert_id;
	}

}