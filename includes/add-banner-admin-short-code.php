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
	 * @param   array  $args
	 * @return  string $html
	 */
//	public function short_code_display ( $args ) {
//		extract( shortcode_atts( array (
//			'id'    => "",
//			'posts' => "5",
//			'sort'  => 0
//		), $args ) );
//		$instance = array(
//			'id'    => $id,
//			'posts' => $posts,
//			'sort'  => $sort
//		);
//		/** DB Connect */
//		$db      = new Posted_Display_Admin_Db();
//		$results = $db->get_options( esc_html( (int) $id ) );
//		$html    = '';
//		if ( $results ) {
//			$cookie_name = $this->text_domain . '-' . esc_html( (int) $id );
//			$query_args  = $db->set_query( $results, $instance, $cookie_name );
//			$query       = new WP_Query( $query_args );
//			if ( $query->have_posts() ) {
//				/** Display ShortCode body. */
//				$html = '<ul>' . PHP_EOL;
//				while ( $query->have_posts() ) {
//					$query->the_post();
//					if ( has_post_thumbnail( get_the_ID() ) ) {
//						$images = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
//					} else {
//						$images[0] = isset( $results['template_no_image'] ) ? $results['template_no_image'] : '';
//					}
//					$html .= '<li>' . PHP_EOL;
//					$items = array(
//						"title"       => get_the_title(),
//						"excerpt"     => get_the_excerpt(),
//						"image"       => $images[0],
//						"date"        => get_the_time( get_option( 'date_format' ) ),
//						"link"        => get_the_permalink(),
//						"tag"         => get_the_tag_list( '', '', '' ),
//						"category"    => get_the_category_list( '', '', get_the_ID() ),
//						"author_name" => get_the_author()
//					);
//					$html .= $db->set_template( $results['template'], $items );
//					$html .= '</li>' . PHP_EOL;
//				}
//				wp_reset_postdata();
//				$html .= '</ul>';
//			}
//		}
//		return (string) $html;
//	}
}