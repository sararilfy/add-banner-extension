<?php

/**
 * Class add_Banner_Extension_Admin_List
 *
 * @author Yoshie Nakayama
 * @since  1.0.0
 */
class add_Banner_Extension_Admin_List {
	/**
	 * add_Banner_Extension_Admin_List constructor.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {

		$db = new add_Banner_Extension_Admin_Db();
		$mode = "";

		if ( isset( $_GET['mode'] ) && $_GET['mode'] === 'delete' ) {
			if ( isset( $_GET['add_banner_extension_id'] ) && is_numeric( $_GET['add_banner_extension_id'] ) ) {
				$db->delete_options( $_GET['add_banner_extension_id'] );
				$mode = "delete";
			}
		}

		$this->page_render( $db, $mode );
	}

	/**
	 * LIST Page HTML Render
	 *
	 * @since  1.0.0
	 * @param add_Banner_Extension_Admin_Db $db
	 * @param String $mode
	 */
	private function page_render ( add_Banner_Extension_Admin_Db $db, $mode = "" ) {
		$post_url = admin_url() . 'admin.php?page=add-banner-extension/includes/add-banner-admin-post.php';
		$self_url = $_SERVER[ 'PHP_SELF' ] . '?' . $_SERVER[ 'QUERY_STRING' ];

		$html  = '';
		$html .= '<div class="wrap">';
		$html .= '<h1>Add Banner Extension List</h1>';
		echo $html;

		if ( $mode === "delete" ) {
			$this->information_render();
		}

		$html  = '<table class="wp-list-table widefat fixed striped">';
		$html .= '<tr>';
		$html .= '<thead>';
		$html .= '<th>image</th>';
		$html .= '<th>image alt</th>';
		$html .= '<th>link url</th>';
		$html .= '<th>open new tab</th>';
		$html .= '<th>class</th>';
		$html .= '<th></th>';
		$html .= '</thead>';
		$html .= '</tr>';
		echo $html;

		$results = $db->get_list_options();

		if ( $results ) {

			foreach ( $results as $row ) {
				$html  = '<tr>';
				$html .= '<td>';
				$html .= '<a href="' . $post_url . '&add_banner_extension_id=' . esc_html( $row->id ) . '">';
				$html .= '<img src="' . esc_url( $row->image_url ) . '" alt="' . esc_attr( $row->image_alt ) . '">';
				$html .= '</a>';
				$html .= '</td>';
				$html .= '<td>' . esc_html( $row->image_alt ) . '</td>';
				$html .= '<td>' . esc_html( $row->link_url ) . '</td>';
				$html .= '<td>' . esc_html( $row->open_new_tab ) . '</td>';
				$html .= '<td>' . esc_html( $row->insert_element_class ) . '</td>';
				$html .= '<td>';
				$html .= '<a href="' . $post_url . '&add_banner_extension_id=' . esc_html( $row->id ) . '" class="button">Edit</a>&nbsp;';
				$html .= '<a href="'. $self_url .'&mode=delete&add_banner_extension_id=' . esc_attr( $row->id ) . '" class="button">Delete</a>';
				$html .= '</td>';
				$html .= '</tr>';
				echo $html;
			}

		} else {
			echo '<td colspan="6">Without registration</td>';
		}

		$html  = '</table>';
		$html .= '</div>';
		echo $html;

	}

	/**
	 * Information Message Render
	 *
	 * @since 1.0.0
	 */
	private function information_render () {
		$html  = '<div id="message" class="updated notice notice-success is-dismissible below-h2">';
		$html .= '<p>Deletion succeeds.</p>';
		$html .= '<button type="button" class="notice-dismiss">';
		$html .= '<span class="screen-reader-text">Dismiss this notice.</span>';
		$html .= '</button>';
		$html .= '</div>';
		echo $html;
	}
}