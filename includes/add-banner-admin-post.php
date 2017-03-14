<?php

/**
 * Class add_Banner_Extension_Admin_Post
 *
 * @author Yoshie Nakayama
 * @since  1.0.0
 */
class add_Banner_Extension_Admin_Post {

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
		$html .= '<h1 class="wp-heading-inline">' . __( 'Edit Banner', $this->text_domain ) . '</h1>';
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
		$html .= '<th scope="row"><label for="banner-image-url">' . __( 'Image URL', $this->text_domain ) . ' <span class="description">(' . __( 'required', $this->text_domain ) . ')</span></label></th>';
		$html .= '<td>';

		if ( !empty( $options['image_url'] ) ) {
			$html .= '<img id="banner-image-view" src="' . esc_attr( $options['image_url'] ) . '" alt="' . esc_attr( $options['image_alt'] ) . '">';
		} else {
			$html .= '<img id="banner-image-view" src="' . plugins_url( '../images/no-image.png', __FILE__ ) . '" alt="No image to show" width="200">';
		}

		$html .= '<input name="banner-image-url" type="text" id="banner-image-url" value="' . esc_attr( $options['image_url'] ) . '" class="large-text" autofocus required>';
		$html .= '<button type="button" id="media-upload" class="button">' . __( 'Choose Image', $this->text_domain ) . '</button>';
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-image-alt">' . __( 'Image Alt Text', $this->text_domain ) . ' <span class="description">(' . __( 'required', $this->text_domain ) . ')</span></label></th>';
		$html .= '<td>';
		$html .= '<input name="banner-image-alt" type="text" id="banner-image-alt" value="' . esc_attr( $options['image_alt'] ) . '" class="regular-text" required>';
		$html .= '<p class="description">' . __( 'Enter the text of alt attribute.', $this->text_domain ) . '</p>';
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-image-link">' . __( 'Link URL', $this->text_domain ) . '</label></th>';
		$html .= '<td>';
		$html .= '<input name="banner-image-link" type="text" id="banner-image-link" value="' . esc_attr( $options['link_url'] ) . '" class="large-text" placeholder="'. esc_url ( home_url() ) .'">';
		$html .= '<p class="description">' . __( 'You can set a link to the image if you enter url.', $this->text_domain ) . '</p>';
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-image-target">' . __( 'Open New Tab', $this->text_domain ) . '</label></th>';
		echo $html;

		$html  = '<td><label>';

		if ( !isset( $options['open_new_tab'] ) || $options['open_new_tab'] == 0 ) {
			$html .= '<input name="banner-image-target" type="checkbox" id="banner-image-target" value="0">';
		} else {
			$html .= '<input name="banner-image-target" type="checkbox" id="banner-image-target" value="1" checked>';
		}

		$html .= __( 'Open link in new tab', $this->text_domain ) . '</label></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-element-class">' . __( 'Class Name', $this->text_domain ) . '</label></th>';
		$html .= '<td>';
		$html .= '<input name="banner-element-class" type="text" id="banner-element-class" value="' . esc_attr( $options['insert_element_class'] ) . '" class="regular-text">';
		$html .= '<p class="description">' . __( 'You can add the class(es) in the banner image. "class=" is unnecessary.', $this->text_domain ) . '<br />' . __( 'Separate them with a One-byte space, if you want to set multiple.', $this->text_domain ) . '</p>';
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-element-id">' . __( 'Id Name', $this->text_domain ) . '</label></th>';
		$html .= '<td>';
		$html .= '<input name="banner-element-id" type="text" id="banner-element-id" value="' . esc_attr( $options['insert_element_id'] ) . '" class="regular-text">';
		$html .= '<p class="description">' . __( 'You can add the id in the banner image. "id=" is unnecessary.', $this->text_domain ) . '</p>';
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-display-category">' . __( 'Display Category', $this->text_domain ) . ' <span class="description">(' . __( 'required', $this->text_domain ) . ')</span></label></th>';
		$html .= '<td>';
		echo $html;

		$args = array(
			'name'         => 'banner-display-category',
			'id'           => 'banner-display-category',
			'selected'     => $options['category_id'],
			'hierarchical' => 1
		);
		wp_dropdown_categories( $args );

		$html  = '<p class="description">' . __( 'Images are displayed only when the selected category are attached to the post.', $this->text_domain ) . '</p>';

		$html .= '</td>';
		$html .= '</tr>';
		$html .= '</table>';

		echo $html;

		submit_button();

		$html  = '</form>';
		$html .= '</div>';
		echo $html;

		require_once ( plugin_dir_path( __FILE__ ) . 'add-banner-admin-upload.php' );
	}

	/**
	 * Information Message Render
	 *
	 * @since 1.0.0
	 */
	private function information_render () {
		$html  = '<div id="message" class="updated notice notice-success is-dismissible below-h2">';
		$html .= '<p>' . __( 'Add Banner Extension Information Update.', $this->text_domain ) . '</p>';
		$html .= '<button type="button" class="notice-dismiss">';
		$html .= '<span class="screen-reader-text">' . __( 'Dismiss this notice.', $this->text_domain ) . '</span>';
		$html .= '</button>';
		$html .= '</div>';
		echo $html;
	}
}