<?php
/**
 * Plugin Uninstall
 *
 * @author  Yoshie Nakayama
 * @version 1.0.0
 * @since   1.0.0
 */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
new add_Banner_Extension_Uninstall();
class add_Banner_Extension_Uninstall {
	/**
	 * Constructor Define.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function __construct () {
		$this->drop_table();
	}
	/**
	 * Drop Table.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private function drop_table () {
		global $wpdb;
		$table_name = $wpdb->prefix . "add_banner_extension";
		$wpdb->query( "DROP TABLE IF EXISTS " . $table_name );
	}
}