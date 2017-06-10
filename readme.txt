=== Add Banner Extension ===
Contributors: Sararilfy
Tags: post, posts, category
Requires at least: 4.7.2
Tested up to: 4.8
Stable tag: 1.0.3
License: GPLv2 or later

Register an image from the administration screen, and a different banner image is displayed for each category.

== Description ==

Let's add banner images to articles and direct users to your site or product.（Call To Action）
Since you can change banner images for each category, you can also guide users to sites that are more interested in users depending on the contents of the articles.
There is no need to embed same images in articles many times from the posting screen!

= About functions =
When you activate the plug-in, "Add banner" menu is added to the left main menu. Please register and edit from there.

Press the "Choose Image" button to open the Media Uploader.
Please select an existing image or upload an image.
The image URL can also be written as a relative path.

It is displayed under the body of the posted article linked to the registered category.
Multiple images can be displayed in the same category.

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
* Supported Post Types are 'Post' only. Currently, 'Page' and 'Custom Post Types' are not supported. Also, it does not support 'Tags' or 'Custom Taxonomies'.

== Installation ==

* A plug-in installation screen is displayed in the WordPress admin panel.
* It installs in `wp-content/plugins`.
* The plug-in is activated.

== Frequently Asked Questions ==

= I want to display the image on the top of the article or sidebar. =
Currently, it can not be displayed.
I plan to be able to implement it with Shortcode in the future.

= I want to display image on all pages irrespective of categories. =
Currently, if you do not link to categories, it is not displayed.

= What happens when multiple categories are linked to an article? =
Only one category is selected, and if there is a banner image registering that category, it will be displayed.

= Do 'Tags' and 'Custom Taxonomies' correspond? =
It does not correspond. I would like to respond in the future.

= In the "Edit Banner" screen, the category you want to set is not displayed in the category to be displayed. =
It is not displayed unless articles are published in the category.

== Screenshots ==

1. The registered banner image list is displayed.

2. Banner image registration and edit screen. Items : Image URL (required), Image Alt Text (required), Link URL, Open New Tab, Class Name, Id Name, Display Category (required).

== Changelog ==

= 1.0.3 (2017-06-10) =
* WordPress version 4.8 operation check.

= 1.0.2 (2017-05-19) =
* WordPress version 4.7.5 operation check.

= 1.0.1 (2017-04-25) =
* WordPress version 4.7.4 operation check.

= 1.0.0 (2017-04-09) =
* The first release.