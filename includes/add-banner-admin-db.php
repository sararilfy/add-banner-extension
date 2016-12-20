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
	 * @since  1.0.0
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
			$query .= "UNIQUE KEY id(id)";
			$query .= ") " . $charset_collate;

			require_once ( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $query );
		}

	}

}