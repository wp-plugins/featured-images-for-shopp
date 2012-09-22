=== Featured Images for Shopp ===
Contributors: WebsiteBakery, digitalsky
Donate link: http://freshlybakedwebsites.net/say-thanks-with-a-beer/
Tags: ecommerce, post thumbs
Requires at least: 3.4.2
Tested up to: 3.4.2
Stable tag: 1.0.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Adds post thumbnails to Shopp products - providing an additional image that can be used independently of the
product gallery images.

== Description ==

Adding post thumbnail (or featured image) support to Shopp means products can now have a new representative
image that is completely independent of the product gallery. One simple use case for this is using a thumbnail
on the category pages and maintaining a completely different set of gallery images on the product page.

* Post thumbnails are regular images uploaded using WordPress's media tools - just as you would expect! - they
can be used from any theme template, not unlike regular post thumbs.
* Get creative! You are not limited in how you use these new images.

Written by [Barry Hughes](http://freshlybakedwebsites.net/) of [Freshly Baked Websites](http://freshlybakedwebsites.net/
"Website design and development from Vancouver Island, BC, Canada"] with support from Chris Jumonville of
[Digital Sky Design](http://www.digitalskydesign.com/).

== Installation ==

Featured Images for Shopp can be installed like any other plugin.

* Upload the `shoppfeaturedimages` directory to the `wp-content/plugins` directory
* Or install it using the tools built in to WordPress's Install Plugins page
* Activate!

== Frequently Asked Questions ==

= Are product thumbnails stored in the database? =

No. Even if you have configured Shopp to store its images in the database, Featured Images for Shopp simply
pulls in WordPress's own media handling tools so any post thumbs will be saved as regular files and can be
re-used across posts/products.

= Can I change the post thumb size! =

Of course.

== Screenshots ==

No screenshots are currently available.

== Changelog ==

= 1.0.0 =
* Initial release

= 1.0.1 =
* Public release
* Minor fix during the registered_post_type callback

== Upgrade Notice ==

This is a simple plugin and you should be able to simply write over the old version during any future
updated.