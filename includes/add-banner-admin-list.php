<?php

/**
 * Class add_Banner_Extension_Admin_List
 *
 * @author Yoshie Nakayama
 * @since  1.0.0
 */
class add_Banner_Extension_Admin_List {

	/**
	 * Text Domain.
	 *
	 * @var string
	 */
	private $text_domain;

	/**
	 * add_Banner_Extension_Admin_List constructor.
	 *
	 * @since  1.0.0
	 * @param  String $text_domain
	 */
	public function __construct( $text_domain ) {

		$this->text_domain = $text_domain;

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
		$html .= '<h1 class="wp-heading-inline">' . __( 'All Banner List', $this->text_domain ) . '</h1>';
		$html .= '<a href="' . admin_url() . 'admin.php?page=add-banner-extension/includes/add-banner-admin-post.php" class="page-title-action">' . __( 'Add New', $this->text_domain ) . '</a>';
		$html .= '<hr class="wp-header-end">';
		echo $html;

		if ( $mode === "delete" ) {
			$this->information_render();
		}

		$html  = '<table class="add-banner-extension-list-table wp-list-table widefat fixed striped">';
		$html .= '<tr>';
		$html .= '<thead>';
		$html .= '<th class="column-primary">' . __( 'Image', $this->text_domain ) . '</th>';
		$html .= '<th>' . __( 'Image Alt Text', $this->text_domain ) . '</th>';
		$html .= '<th>' . __( 'Link URL', $this->text_domain ) . '</th>';
		$html .= '<th>' . __( 'Open New Tab', $this->text_domain ) . '</th>';
		$html .= '<th>' . __( 'Class Name', $this->text_domain ) . '</th>';
		$html .= '<th>' . __( 'Id Name', $this->text_domain ) . '</th>';
		$html .= '<th class="column-categories">' . __( 'Display Category', $this->text_domain ) . '</th>';
		$html .= '</thead>';
		$html .= '</tr>';
		echo $html;

		$results = $db->get_list_options();

		if ( $results ) {

			foreach ( $results as $row ) {
				$html  = '<tr>';
				$html .= '<td class="column-primary">';
				$html .= '<div class="add-banner-extension-list-table-image-wrap">';
				$html .= '<a href="' . $post_url . '&add_banner_extension_id=' . esc_html( $row->id ) . '">';
				$html .= '<img src="' . esc_attr( $row->image_url ) . '" alt="' . esc_attr( $row->image_alt ) . '" class="banner-image-view">';
				$html .= '</a>';
				$html .= '</div>';
				$html .= '<a href="' . $post_url . '&add_banner_extension_id=' . esc_html( $row->id ) . '" class="button">' . __( 'Edit', $this->text_domain ) . '</a>&nbsp;';
				$html .= '<a href="'. $self_url .'&mode=delete&add_banner_extension_id=' . esc_attr( $row->id ) . '" class="button">' . __( 'Delete', $this->text_domain ) . '</a>';
				$html .= '<button type="button" class="toggle-row"><span class="screen-reader-text">' . __( 'Show more details', $this->text_domain ) . '</span></button>';
				$html .= '</td>';
				$html .= '<td data-colname="' . __( 'Image Alt Text', $this->text_domain ) . '">' . esc_html( $row->image_alt ) . '</td>';
				$html .= '<td data-colname="' . __( 'Link URL', $this->text_domain ) . '">' . esc_html( $row->link_url ) . '</td>';
				$html .= '<td data-colname="' . __( 'Open New Tab', $this->text_domain ) . '">';

				if ( esc_html( $row->open_new_tab ) == 1 ) {
					$html .= __( 'ON', $this->text_domain );
				} else {
					$html .= __( 'OFF', $this->text_domain );
				}

				$html .= '</td>';
				$html .= '<td data-colname="' . __( 'Class Name', $this->text_domain ) . '">' . esc_html( $row->insert_element_class ) . '</td>';
				$html .= '<td data-colname="' . __( 'Id Name', $this->text_domain ) . '">' . esc_html( $row->insert_element_id ) . '</td>';
				$html .= '<td data-colname="' . __( 'Display Category', $this->text_domain ) . '">' . esc_html( get_the_category_by_ID( $row->category_id ) ) . '</td>';
				$html .= '</tr>';
				echo $html;
			}

		} else {
			echo '<td colspan="7">' . __( 'Without registration', $this->text_domain ) . '</td>';
		}

		$html  = '</table>';
		$html .= '</div>';
		echo $html;

		require_once ( plugin_dir_path( __FILE__ ) . 'add-banner-admin-404.php' );

	}

	/**
	 * Information Message Render
	 *
	 * @since 1.0.0
	 */
	private function information_render () {
		$html  = '<div id="message" class="updated notice notice-success is-dismissible below-h2">';
		$html .= '<p>' . __( 'Deletion succeeds.', $this->text_domain ) . '</p>';
		$html .= '<button type="button" class="notice-dismiss">';
		$html .= '<span class="screen-reader-text">' . __( 'Dismiss this notice.', $this->text_domain ) . '</span>';
		$html .= '</button>';
		$html .= '</div>';
		echo $html;
	}
}