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
		$this->page_render();
	}

	private function page_render () {
		$html  = '';
		$html .= '<div class="wrap">';
		$html .= '<h1>test</h1>';
		$html .= '<table class="wp-list-table">';
		$html .= '<tr>';
		$html .= '<td>td</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div>';
		echo $html;

	}
}