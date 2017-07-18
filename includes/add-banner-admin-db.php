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
	 * @param string $text_domain
	 * @param string $version
	 */
	public function create_table( $text_domain, $version ) {
		global $wpdb;

		$prepared        = $wpdb->prepare( "SHOW TABLES LIKE %s", $this->table_name );
		$is_db_exists    = $wpdb->get_var( $prepared );
		$charset_collate = $wpdb->get_charset_collate();

		if ( is_null( $is_db_exists ) ) {

			$this->create_table_execute( $charset_collate, $text_domain, $version );

		} else {
			/**
			 * version up process.
			 *
			 * @since 2.0.0
			 */
			$options = get_option( $text_domain );

			if ( !isset( $options['version'] ) || $options['version'] !== $version ) {

				$lists = $this->get_list_options();

				$wpdb->query( "DROP TABLE " . $this->table_name );

				$this->create_table_execute( $charset_collate, $text_domain, $version );

				foreach ( $lists as $list ) {

					$args = array(
						'image_url'            => $list->image_url,
						'image_alt'            => $list->image_alt,
						'link_url'             => $list->link_url,
						'open_new_tab'         => $list->open_new_tab,
						'insert_element_class' => $list->insert_element_class,
						'insert_element_id'    => $list->insert_element_id,
						'how_display'          => "article",
						'filter_category'      => true,
						'category_id'          => $list->category_id,
						'register_date'        => $list->register_date,
						'update_date'          => $list->update_date
					);

					$this->insert_exit_data( $args );

				}
			}
		}

	}

	/**
	 * Create table execute
	 *
	 * @since 2.0.0
	 * @param string $charset_collate
	 * @param string $text_domain
	 * @param string $version
	 */
	private function create_table_execute ( $charset_collate, $text_domain, $version ) {

		require_once ( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$query  = "CREATE TABLE " . $this->table_name;
		$query .= "(id MEDIUMINT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
		$query .= "image_url TEXT NOT NULL,";
		$query .= "image_alt TEXT,";
		$query .= "link_url TEXT,";
		$query .= "open_new_tab BOOLEAN DEFAULT FALSE,";
		$query .= "insert_element_class TINYTEXT,";
		$query .= "insert_element_id TINYTEXT,";
		$query .= "how_display TINYTEXT,";
		$query .= "filter_category BOOLEAN DEFAULT FALSE,";
		$query .= "category_id BIGINT,";
		$query .= "register_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,";
		$query .= "update_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,";
		$query .= "UNIQUE KEY id(id)";
		$query .= ") " . $charset_collate;

		dbDelta( $query );

		$options = array( 'version' => $version );

		update_option( $text_domain, $options, 'yes' );

	}

	/**
	 * Insert exiting data
	 * @since 2.0.0
	 *
	 * @param array $args
	 */
	private function insert_exit_data ( $args ) {
		global $wpdb;

		$prepared = array(
			'%s',
			'%s',
			'%s',
			'%d',
			'%s',
			'%s',
			'%s',
			'%d',
			'%d',
			'%s',
			'%s'
		);

		$wpdb->insert( $this->table_name, $args, $prepared );
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
	 * @version 2.0.0
	 * @since   1.0.0
	 * @param   integer $category_id
	 * @return  array
	 */
	public function get_categories ( $category_id ) {
		global $wpdb;
		$query    = "SELECT * FROM " . $this->table_name . " WHERE category_id = %d AND filter_category = 1 AND how_display = 'article'";
		$data     = array( $category_id );
		$prepared = $wpdb->prepare( $query, $data );
		return (array) $wpdb->get_results( $prepared );
	}

	/**
	 * Get Not filter data.
	 *
	 * @since  2.0.0
	 * @return array
	 */
	public function get_not_filter () {
		global $wpdb;
		$query = "SELECT * FROM " . $this->table_name . " WHERE filter_category = 0 AND how_display = 'article'";
		return (array) $wpdb->get_results( $query );
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
			'how_display'          => strip_tags( $post['banner-how-display'] ),
			'filter_category'   => isset( $post['banner-filter-category'] ) ? (int) 1 : 0,
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
			'%s',
			'%d',
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
			'how_display'          => strip_tags( $post['banner-how-display'] ),
			'filter_category'   => isset( $post['banner-filter-category'] ) ? (int) 1 : 0,
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
			'%s',
			'%d',
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