=== WordPress Posted Display ===
Contributors: sararilfy
Tags: post, posts, category
Requires at least: 4.7.2
Tested up to: 4.7.2
Stable tag: 1.0.0

Insert a banner image below the body of the article page. You can change the banner by category.

== Description ==

Plug-in Posted Display Widget & ShortCode Add. You can also save and display your browsing history to Cookie.

* Save your browsing history of the posts to Cookie, you can view the information in the widget and the short code.
* You can create a widget and a short code that can display the posts in any.
* You can view the information in the widget and the short code posts that belong to any category ID.(Multiple specified)
* You can view the information in the widget and the short code posts that belong to any tag ID.(Multiple specified)
* You can view the information in the widget and the short code posts that belong to any user ID.(Multiple specified)

**In a post page or fixed page**

You can use the short code in the post page or fixed page. It is possible to get a short code with the registered template list, use Copy.
You can specify the maximum number to be displayed by changing the value of the posts.

[ Example ]
`
<?php
if ( shortcode_exists( 'wp-posted-display' ) ) {
	echo do_shortcode( '[wp-posted-display id="1" posts="5" sort="0"]' );
}
?>
`

= ShortCode Params Sorted by =
* sort="0": Input order
* sort="1": Date descending order
* sort="2": Date ascending order
* sort="3": Random

== Installation ==

* A plug-in installation screen is displayed in the WordPress admin panel.
* It installs in `wp-content/plugins`.
* The plug-in is activated.

== Screenshots ==

1. Create an HTML template to be output in the Widget.

2. "Posted Display" has been added to the Widget. Display to select the template you created.

== Changelog ==

= 1.0.0 (2017-03-XX) =
* The first release.

== Contact ==

* email to foundationmeister[at]outlook.com
* twitter @miiitaka