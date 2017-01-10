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
		$db = new add_Banner_Extension_Admin_Db();
		if ( isset( $_POST['add_banner_extension_id'] ) && $_POST['add_banner_extension_id'] === '' ) {
			$db->insert_table( $_POST );
			$this->information_render();
		}

		$this->page_render();
	}

	private function page_render () {
		$html  = '';
		$html .= '<div class="wrap">';
		$html .= '<h1>Add New Banner</h1>';
		$html .= '<form method="post" action="">';
		$html .= '<input type="hidden" name="add_banner_extension_id" value="">';
		$html .= '<table class="form-table">';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-image-url">Image URL</label></th>';
		$html .= '<td><input name="banner-image-url" type="text" id="banner-image-url" value="" class="regular-text" autofocus></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-image-alt">Image Alt</label></th>';
		$html .= '<td><input name="banner-image-alt" type="text" id="banner-image-alt" value="" class="regular-text" autofocus></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-image-link">Link URL</label></th>';
		$html .= '<td><input name="banner-image-link" type="text" id="banner-image-link" value="" class="regular-text" autofocus>';
		$html .= '<br><label for="banner-image-target"><input name="banner-image-target" type="checkbox" id="banner-image-target" value="1">Open New Tab</label></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<th scope="row"><label for="banner-element-class">Insert Element Class</label></th>';
		$html .= '<td><input name="banner-element-class" type="text" id="banner-element-class" value="" class="regular-text" autofocus></td>';
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