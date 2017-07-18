<?php
/**
 * Admin ShortCode Settings
 *
 * @author Yoshie Nakayama
 * @since  2.0.0
 */
class Add_Banner_Extension_ShortCode {
	/**
	 * Text Domain.
	 *
	 * @var string
	 */
	private $text_domain;

	/**
	 * Add_Banner_Extension_ShortCode constructor.
	 *
	 * @since  2.0.0
	 * @param  String $text_domain
	 */
	public function __construct( $text_domain ) {
		$this->text_domain = $text_domain;
	}

	/**
	 * ShortCode Display.
	 *
	 * @since   2.0.0
	 * @access  public
	 * @param   array $args
	 * @return  string $html
	 */
	public function short_code_display ( $args ) {
		extract(
			shortcode_atts(
				array (
					'id'              => "",
					'image_alt'       => "",
					'filter_category' => "",
					'category_id'     => ""
				),
				$args,
				$this->text_domain
			)
		);

		/* DB Connect */
		$db = new add_Banner_Extension_Admin_Db();
		$banner = $db->get_options( $args['id'] );

		if ( !empty( $banner ) ) {

			if (array_key_exists('image_alt', $args) && $args['image_alt'] != '') {
				$image_alt = $args['image_alt'];
			} else {
				$image_alt = $banner['image_alt'];
			}

			if (array_key_exists('filter_category', $args) && $args['filter_category'] != '') {
				$filter_category = $args['filter_category'];
			} else {
				$filter_category = $banner['filter_category'];
			}

			if (array_key_exists('category_id', $args) && $args['category_id'] != '') {
				$category_id = $args['category_id'];
			} else {
				$category_id = $banner['category_id'];
			}

			$html = '';

			if ($filter_category == '1') {
				if (is_single() || is_category()) {

					$categories = get_the_category();

					if (count($categories) > 0) {

						if ($categories[0]->cat_ID == $category_id) {
							$html .= $this->banner_create($banner, $image_alt);
						}

					}

				}

			} elseif ($filter_category == '0') {
				$html .= $this->banner_create($banner, $image_alt);
			}

			return (string) $html;

		}

	}

	/**
	 * Banner Create.
	 *
	 * @since 2.0.0
	 * @param array $options
	 * @param string $image_alt
	 * @return string $html
	 */
	private function banner_create ( $options, $image_alt ) {

		$html = '<div class="add-banner-extension-wrapper">';
		if ( !empty( $options['link_url'] ) ) {
			if ( $options['open_new_tab'] == 1 ) {
				$html .= '<a href="' . esc_url( $options['link_url'] ) . '" target="_blank">';
			} else {
				$html .= '<a href="' . esc_url( $options['link_url'] ) . '">';
			}
		}

		$html .= '<img src="' . esc_url( $options['image_url'] ) . '" alt="' . esc_attr( $image_alt ) . '"';

		if ( !empty( $options['insert_element_class'] ) ) {
			$html .= ' class="' . esc_attr( $options['insert_element_class'] ) . '"';
		}

		if ( !empty( $options['insert_element_id'] ) ) {
			$html .= ' id="' . esc_attr( $options['insert_element_id'] ) . '"';
		}

		$html .= '>';

		if ( !empty( $options['image_url'] ) ) {
			$html .= '</a>';
		}
		$html .= '</div>';

		return $html;
	}

}