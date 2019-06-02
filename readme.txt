=== Add Banner Extension ===
Contributors: Sararilfy
Tags: post, posts, category
Requires at least: 4.7.2
Tested up to: 5.2.1
Stable tag: 2.0.9
License: GPLv2 or later

Register an image from the administration screen, and a different banner image is displayed for each category.

== Description ==

Let's add banner images to articles and direct users to your site or product.（Call To Action）
Since you can change banner images for each category, you can also guide users to sites that are more interested in users depending on the contents of the articles.
There is no need to embed same images in articles many times from the posting screen!

= About functions =
When you activate the plug-in, "Add banner" menu is added to the left main menu of the administration screen. Please register and edit from there.

Press the "Choose Image" button at Edit banner page, to open the Media Uploader.
Please select an existing image or upload an image.
The image URL can also be written as a relative path.

In the "How display", you can choose whether to display it under the body of the posted article or display it with a shortcode.

When displaying with shortcode, overwriting the short code number takes precedence. However, "id" is not displayed unless it is registered in the administration screen.

If you check "Filter by category", banner will be displayed on category page of registered category. Multiple images can be displayed in the same category. If you do not check it, the banner is displayed unconditionally on all pages.

You can set class and ID in the image. Please use it for measurement with tag manager and adjustment of style sheet.

When the banner is displayed, the banner image is surrounded by the following tags.
You can use it by adjusting the style sheet.
`
<div class="add-banner-extension-wrapper">
  <img src="sample.jpg" alt="sample">
</div>
`

= Attention =

* Depending on the theme and plugin you are using, the display position of the banner image may change or more than one banner may be displayed. The theme of "Twenty Seventeen" is confirmed to work.
* When "Filter by category" is checked, the corresponding post type is post only (post article page and category page). Supported Post Types are 'Post' only. Currently, 'Page' and 'Custom Post Types' are not supported. Also, it does not support 'Tags' or 'Custom Taxonomies'.

== Installation ==

* A plug-in installation screen is displayed in the WordPress admin panel.
* It installs in `wp-content/plugins`.
* The plug-in is activated.

== Frequently Asked Questions ==

= I want to display the image on the top of the article or sidebar. =
It is possible to paste the displayed shortcode to the applicable theme.

= I want to display image on all pages irrespective of categories. =
When registering a banner, please uncheck "filter by category" and register.

= What happens when multiple categories are linked to an article? =
Only one category is automatically selected, and if there is a banner image registering that category, it will be displayed.

= Do 'Tags' and 'Custom Taxonomies' correspond? =
It does not correspond. I would like to respond in the future.

= In the "Edit Banner" screen, the category you want to set is not displayed in the category to be displayed. =
Categories where articles are not published, it will not be displayed in the pull-down menu.

== Screenshots ==

1. The registered banner image list is displayed.

2. Banner image registration and edit screen. Items : Image URL (required), Image Alt Text (required), Link URL, Open New Tab, Class Name, Id Name, Display Category (required).

== Changelog ==

= 2.0.9 (2019-06-01) =
* WordPress version 5.2.1 operation check.

= 2.0.8 (2019-02-28) =
* WordPress version 5.1.0 operation check.

= 2.0.7 (2019-01-14) =
* WordPress version 5.0.3 operation check.

= 2.0.6 (2019-01-04) =
* WordPress version 5.0.2 operation check.

= 2.0.5 (2018-04-30) =
* WordPress version 4.9.5 operation check.

= 2.0.4 (2017-11-10) =
* WordPress version 4.8.3 operation check.

= 2.0.3 (2017-10-27) =
* WordPress version 4.8.2 operation check.

= 2.0.2 (2017-09-12) =
* Plugin re-translation.

= 2.0.1 (2017-09-12) =
* WordPress version 4.8.1 operation check.

= 2.0.0 (2017-07-23) =
* Added ability to display banner with short code
* Change the display of the banner so that it can be selected by "display with limited by category" or "indication without categorization, unconditionally"

= 1.0.2 (2017-05-19) =
* WordPress version 4.7.5 operation check.

= 1.0.1 (2017-04-25) =
* WordPress version 4.7.4 operation check.

= 1.0.0 (2017-04-09) =
* The first release.