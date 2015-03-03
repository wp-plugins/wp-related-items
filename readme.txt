=== WP Related Items (WRI) ===
Contributors: WebshopLogic
Donate link: http://webshoplogic.com/donation-wp-related-items-lite/
Tags: related, related items, related posts, relationship, cross relationship, up-sell, cross-sell, similar, webshop, e-commerce, custom posttype, yarpp, yet another related posts plugin, woocommerce, thumbnails, automatic relationship, manual relationship
Requires at least: 3.7.1
Tested up to: 4.1
Stable tag: 1.1.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
WP Related Items plugin offers different types of similar contents for your users. For example some related products can be displayed to your posts.    

== Description ==

WP Related Items plugin offers different types of similar contents for your users. For example some related products can be displayed to your similar posts. This makes connections of your site contents visible to your clients, increasing business efficiency.

Would you like to offer some related products to your blog posts? Do you need offer up-sell or cross-sell products? Do you have an event calendar plugin, and want to suggest some programs connected to an article? Do you have a custom movie catalog plugin and want to associate some articles to your movies?

Using cross type relationship management functions, WRI makes it possible to associate a post, page, or other custom post type to other posts, pages or custom post types, ensures widely configurable relatedness settings, sophisticated cross-relation adjustments. WRI uses the most popular YARPP relationship handling plugin in the background, extending its functionality, retaining its advantages.

WRI combines automatic, manual and common categorization based relationship management. Some functions are available in the PRO version.

You can set attributes that define how to display different type of related items for every reference item type. Such a matrix-like way you can specify all necessary variations of display settings.

This version ensures built in WooCommerce custom product support. 

Please find more information on the product documentation page: http://webshoplogic.com/product/wp-related-items-lite-wri-wordpress-plugin/

PRO version Plugin Page: http://webshoplogic.com/product/wp-related-items-pro-wri-wordpress-plugin/

= Available languages =
* English
* Spanish - translated by Andrew Kurtis - WebHostingHub 
* Hungarian - tranlated by WebshopLogic

== Installation ==

* Upload the plugin to the '/wp-content/plugins/' directory.
* Activate it through the 'Plugins' menu in WordPress.
* Configure the plugin: Settings -> WP Related Items (WRI)

== Frequently Asked Questions ==

=You can find FAQ here:=
http://webshoplogic.com/product/wp-related-items-lite-wri-wordpress-plugin/#tab-faq&noscroll

== Screenshots ==

1. Displaying related items (e.g. related products similar to a post)

2. General settings page

3. Related items settings page

4. Special settings for a reference post type (e.g. for "post" post type)

5. Related items widget settings

6. Manual relationship administration (pro)

7. Common categories for different type of items to gain similarity between them (pro)


== Changelog ==

= 1.1.6 =
* fix: change mktime fv to time (Strict standards)
* modified: new acf version
* new related items positioning option on "WooCommerce Product page" 
* fix link problem in list mode

= 1.1.5 =
* fix: empty array problem at manual relationship admin

= 1.1.4 =
* fix: Manual relationship meta box empty problem (admin_init action needed instead of add_meta_boxes, because of ACF speciality)
* fix: duplicate manual items on the manualy related (remote) side

= 1.1.3 =
* fix: Manual relationship meta box display problem, in case of some custom post types 

= 1.1.2 =
* fix: manual relationship field LOV wri_used_post_types problem
* New options: Disable YARPP related.css stylesheet, Disable YARPP widget.css stylesheet, Disable WRI styles-wri-thumbnails_woocommerce.css stylesheet for new YARPP and WooCommerce versions in case of using custom stylesheets.

= 1.1.1 =
* fix: problem of disabling wordpress.org update for PRO version

= 1.1.0 =
* Same functionality as 1.0.8 
* fix versioning problem

= 1.0.8 =
* fix: version handling problem
* fix: problem of disabling wordpress.org update for PRO version

= 1.0.7 =
* fix: disable wordpress.org update for PRO version

= 1.0.6 =
* New Spanish translation - translated by Andrew Kurtis - WebHostingHub
* Fix: Post and Product post type was wired in manual relationship ACF field, it is set up dynamycally now
* Fix: Advanced Custom Fields plugin conflict

= 1.0.5 =
* Advanced, completely general possibility to turn on any custom post type (if show_ui parameter of custom post type is true). It is turn on yarpp_support argument of all post types selected by the user.
* Hide WRI Similarity Marker Category column on post admin pages
* New parameter: Use YARPP title if WRI title is not set (wri-widget.php, template-wri-before_loop.php, wri-admin-page.php)
* Pass wri_widget_mode attribute is part of yarpp_related_options (to not show a title row inside widget content) 
* "Hide related products displayed by WooCommerce" option
* Hungarian language version
* Clarification of labels
* Fix: Handling some checkbox of Admin panel

= 1.0.4 =
* Put back advanced-custom-fields/acf.php sub-plugin header information, and change it to WordPress does not realize it as a plugin header, because it caused "The plugin does not have a valid header" error.

= 1.0.3 =
* Delete advanced-custom-fields/acf.php sub-plugin header, to resolve "The plugin does not have a valid header" error.

= 1.0.2 =
* Repair plugin header comment signs, to try to resolve "The plugin does not have a valid header" error.

= 1.0.1 =
* Delete assets folder from plugin folder (move it to svn root)
* Insert donation link into admin page
* Insert donation link into WordPress Plugin Directory (readme.txt)
* Modify readme.txt text

= 1.0 =
* First version


== Upgrade Notice ==

= 1.0 =
* First version

