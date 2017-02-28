<?php

/**
 * Class add_Banner_Extension_Admin_Post
 *
 * @author Yoshie Nakayama
 * @since  1.0.0
 */
class add_Banner_Extension_Admin_Post {
	/**
	 * add_Banner_Extension_Admin_List constructor.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {

		/**
		 * Update Status
		 *
		 * "ok" : Successful update
		 */
		$status = "";

		/** DB Connect */
		$db = new add_Banner_Extension_Admin_Db();

		/** Set Default Parameter for Array */
		$options = array(
			"id"                    => "",
			"image_url"             => "",
			"image_alt"             => "",
			"link_url"              => "",
			"open_new_tab"          => 0,
			"insert_element_class"  => "",
			"insert_element_id"     => "",
			"category_id"           => 0
		);

		/** Key Set */
		if ( isset( $_GET['add_banner_extension_id'] ) && is_numeric( $_GET['add_banner_extension_id'] ) ) {
			$options['id'] = esc_html( $_GET['add_banner_extension_id'] );
		}

		/** DataBase Update & Insert Mode */
		if ( isset( $_POST['add_banner_extension_id'] ) && is_numeric( $_POST['add_banner_extension_id'] ) ) {
			$db->update_options( $_POST );
			$options['id'] = $_POST['add_banner_extension_id'];
			$status = "ok";
		} else {
			if ( isset( $_POST['add_banner_extension_id'] ) && $_POST['add_banner_extension_id'] === '' ) {
				$options['id'] = $db->insert_options( $_POST );
				$status = "ok";
			}
		}

		/** Mode Judgment */
		if ( isset( $options['id'] ) && is_numeric( $options['id'] ) ) {
			$options = $db->get_options( $options['id'] );
		}

		$this->page_render( $options, $status );

	}

	/**
	 * Page Render.
	 *
	 * @param array $options
	 * @param string $status
	 */
	private function page_render ( $options, $status ) {
		$html  = '';
		$html .= '<div class="wrap">';
		$html .= '<h1 class="wp-heading-inline">Add New Banner</h1>';
		echo $html;

		switch ( $status ) {
			case "ok":
				$this->information_render();
				break;
			default:
				break;
		}

		$html  = '<form method="post" action="">';
		$html .= '<input type="hidden" name="add_banner_extension_id" value="' . esc_attr( $options['id'] ) . '">';
		$html .= '<table class="form-table">';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-image-url">Image URL <span class="description">(required)</span></label></th>';
		$html .= '<td>';

		if ( !empty( $options['image_url'] ) ) {
			$html .= '<img id="banner-image-view" src="' . esc_url( $options['image_url'] ) . '" alt="' . esc_attr( $options['image_alt'] ) . '" width="200">';
		} else {
			$html .= '<img id="banner-image-view" src="' . plugins_url( '../images/no-image.gif', __FILE__ ) . '" alt="image" width="200">';
		}

		$html .= '<input name="banner-image-url" type="text" id="banner-image-url" value="' . esc_attr( $options['image_url'] ) . '" class="large-text" autofocus required>';
		$html .= '<button id="media-upload">Choose Image</button>';
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-image-alt">Image Alt Text <span class="description">(required)</span></label></th>';
		$html .= '<td><input name="banner-image-alt" type="text" id="banner-image-alt" value="' . esc_attr( $options['image_alt'] ) . '" class="regular-text" required></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-image-link">Link URL</label></th>';
		$html .= '<td><input name="banner-image-link" type="text" id="banner-image-link" value="' . esc_attr( $options['link_url'] ) . '" class="large-text" placeholder="'. esc_url ( home_url() ) .'">';
		echo $html;

		$html  = '<br><label for="banner-image-target">';

		if ( !isset( $options['open_new_tab'] ) || $options['open_new_tab'] == 0 ) {
			$html .= '<input name="banner-image-target" type="checkbox" id="banner-image-target" value="0">';
		} else {
			$html .= '<input name="banner-image-target" type="checkbox" id="banner-image-target" value="1" checked>';
		}

		$html .= 'Open New Tab</label></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-element-class">Insert Element Class</label></th>';
		$html .= '<td><input name="banner-element-class" type="text" id="banner-element-class" value="' . esc_attr( $options['insert_element_class'] ) . '" class="regular-text"></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-element-id">Insert Element Id</label></th>';
		$html .= '<td><input name="banner-element-id" type="text" id="banner-element-id" value="' . esc_attr( $options['insert_element_id'] ) . '" class="regular-text"></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-display-category">Display Category <span class="description">(required)</span></label></th>';
		$html .= '<td>';
		echo $html;

		$args = array(
			'name'         => 'banner-display-category',
			'id'           => 'banner-display-category',
			'selected'     => $options['category_id'],
			'hierarchical' => 1
		);
		wp_dropdown_categories( $args );

		$html  = '</td>';
		$html .= '</tr>';
		$html .= '</table>';

		echo $html;

		submit_button();

		$html  = '</form>';
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
		$html .= '<p>Add Banner Extension Information Update.</p>';
		$html .= '<button type="button" class="notice-dismiss">';
		$html .= '<span class="screen-reader-text">Dismiss this notice.</span>';
		$html .= '</button>';
		$html .= '</div>';
		echo $html;
	}
}