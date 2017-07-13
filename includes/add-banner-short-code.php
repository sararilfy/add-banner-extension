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
	 * @param   string $args
	 * @return  string $html
	 */
	public function short_code_display ( $args ) {
		extract(
			shortcode_atts(
				array (
					'id'  => "",
					'alt' => ""
				),
				$args,
				$this->text_domain
			)
		);

		/* DB Connect */

		$html = 'bbb';
		return (string) $html;

	}

}