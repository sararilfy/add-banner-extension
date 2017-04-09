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
			$query .= "insert_element_id TINYTEXT,";
			$query .= "category_id BIGINT,";
			$query .= "register_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,";
			$query .= "update_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,";
			$query .= "UNIQUE KEY id(id)";
			$query .= ") " . $charset_collate;

			require_once ( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $query );
		}

	}

	/**
	 * Get Data.
	 *
	 * @since  1.0.0
	 * @param  integer $id
	 * @return array   $args
	 */
	public function get_options ( $id ) {
		global $wpdb;
		$query    = "SELECT * FROM " . $this->table_name . " WHERE id = %d";
		$data     = array( $id );
		$prepared = $wpdb->prepare( $query, $data );
		return (array) $wpdb->get_row( $prepared );
	}

	/**
	 * Get All Data.
	 *
	 * @since  1.0.0
	 * @return array  $results
	 */
	public function get_list_options () {
		global $wpdb;

		$prepared = "SELECT * FROM " . $this->table_name . " ORDER BY update_date DESC";

		return (array) $wpdb->get_results( $prepared );
	}

	/**
	 * Get Category.
	 *
	 * @since  1.0.0
	 * @param  integer $category_id
	 * @return array   $args
	 */
	public function get_categories ( $category_id ) {
		global $wpdb;
		$query    = "SELECT * FROM " . $this->table_name . " WHERE category_id = %d";
		$data     = array( $category_id );
		$prepared = $wpdb->prepare( $query, $data );
		return (array) $wpdb->get_results( $prepared );
	}

	/**
	 * insert_table.
	 *
	 * @since 1.0.0
	 * @param array $post
	 * @return int
	 */
	public function insert_options( array $post ) {
		global $wpdb;

		$data = array(
			'image_url'            => strip_tags( $post['banner-image-url'] ),
			'image_alt'            => strip_tags( $post['banner-image-alt'] ),
			'link_url'             => strip_tags( $post['banner-image-link'] ),
			'open_new_tab'         => isset( $post['banner-image-target'] ) ? (int) 1 : 0,
			'insert_element_class' => strip_tags( $post['banner-element-class'] ),
			'insert_element_id'    => strip_tags( $post['banner-element-id'] ),
			'category_id'          => isset( $post['banner-display-category'] ) ? (int) $post['banner-display-category'] : 0,
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
			'%d',
			'%s',
			'%s'
		);

		$wpdb->insert( $this->table_name, $data, $prepared );
		return (int) $wpdb->insert_id;
	}

	/**
	 * Update Data.
	 *
	 * @since 1.0.0
	 * @param array $post($_POST)
	 */
	public function update_options ( array $post ) {
		global $wpdb;

		$data = array(
			"image_url"            => strip_tags( $post['banner-image-url'] ),
			"image_alt"            => strip_tags( $post['banner-image-alt'] ),
			"link_url"             => strip_tags( $post['banner-image-link'] ),
			"open_new_tab"         => isset( $post['banner-image-target'] ) ? 1 : 0,
			"insert_element_class" => strip_tags( $post['banner-element-class'] ),
			"insert_element_id"    => strip_tags( $post['banner-element-id'] ),
			'category_id'          => isset( $post['banner-display-category'] ) ? (int) $post['banner-display-category'] : 0,
			'update_date'          => date( "Y-m-d H:i:s" )
		);

		$key = array( 'id' => esc_html( $post['add_banner_extension_id'] ) );

		$prepared = array(
			'%s',
			'%s',
			'%s',
			'%d',
			'%s',
			'%s',
			'%d',
			'%s'
		);

		$key_prepared = array( '%d' );

		$wpdb->update( $this->table_name, $data, $key, $prepared, $key_prepared );
	}

	/**
	 * Delete data.
	 *
	 * @since 1.0.0
	 * @param integer $id
	 */
	public function delete_options( $id ) {
		global $wpdb;

		$key = array( 'id' => esc_html( $id ) );
		$key_prepared = array( '%d' );
		$wpdb->delete( $this->table_name, $key, $key_prepared );

	}

}