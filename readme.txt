=== WP Related Items (WRI) ===
Contributors: WebshopLogic
Donate link: http://webshoplogic.com/donation-wp-related-items-lite/
Tags: related, related items, related posts, relationship, cross relationship, up-sell, cross-sell, similar, webshop, e-commerce, custom posttype, yarpp, yet another related posts plugin, woocommerce, thumbnails, automatic relationship, manual relationship
Requires at least: 3.7.1
Tested up to: 3.7.1
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
WP Related Items plugin makes visible every kind of hidden connections of your site for your business. 

== Description ==

Would you like to offer some related products to your blog posts? Do you need offer up-sell or cross-sell products? Do you have an event calendar plugin, and want to suggest some programs connected to an article? Do you have a custom movie catalog plugin and want to associate some articles to your movies?

Using cross relationship management functions, WRI makes it possible to associate a post, page, or other custom post type to other posts, pages or custom post types, ensures widely configurable relatedness settings, sophisticated cross-relation adjustments. WRI uses the most popular YARPP relationship handling plugin in the background, extending its functionality, retaining its advantages.

WRI combines automatic, manual and common categorization based relationship management. Some functions are available in the PRO version.

You can set attributes that define how to display different type of related items for every reference item type. Such a matrix-like way you can specify all necessary variations of display settings.

This version ensures built in WooCommerce custom product support. 

Author website: http://webshoplogic.com/

Pro version Plugin Page: http://webshoplogic.com/product/wp-related-items-wri-plugin/

= Configuration options =

You can chose which post types would like to use (e.g. posts, product, pages). You can set separately how different type of related items should be displayed for PAGEs, POSTs or for CUSTOM POST TYPEs (e.g. for PRODUCTs or EVENTs). Position, order of blocks, order of related items, match threshold, number of displayed related items limit, format (list or widgets), custom templates can be configured for each reference post types – related post type pair in the matrix. This is very important, because every post type has specific features you would like to be treated. 
Related items can be displayed right after the reference item, or on sidebar widgets.

= PRO version =

Cross taxonomies can be used to increase similarities using common categorization between different post types. For example, you can switch on WordPress standard post categories for products, so the post category assignment option appears not only on post edit page but on products admin page also. In this way, different post types can be in the same category, increasing the similarity rates between them.

Manual assignment of items is possible. This way you can define explicit relationship between different items (e.g. assign some product to a post or two related posts to each other)

= Features =
* Easy cross-relation adjustments
* Selectable post types
* Unique settings for every reference-related item type pairs
* Display Thumbnails
* Related items widgets
* Native WooCommerce support
* Extendable custom post type handling
* Template Customization
* Includes .mo and .po files for localization
* YARPP support

= Pro features =
* Manually recorded relationships
* Common categories and tags for different item types
* More relationship widget options
* Display positioning (top or bottom of content)
* Related items for archive pages
Pro version Plugin Page: http://webshoplogic.com/product/wp-related-items-wri-plugin/

= Upcoming features =
* Native support of further WP based e-commerce solutions

= Available languages =
* English
* Spanish - translated by Andrew Kurtis - WebHostingHub 
* Hungarian - tranlated by WebshopLogic

== Installation ==

* Upload the plugin to the '/wp-content/plugins/' directory.
* Activate it through the 'Plugins' menu in WordPress.
* Configure the plugin: Settings -> WP Related Items (WRI)

== Frequently Asked Questions ==

= Where is the detailed description of admin panel? =

Find detailed description for each field on admin page.

= What is reference post type? =

Post type for which you want to display the related items. 

= What is related post type? =

Post types which you want to display as similar items.

= It is possible to use widgets for display related items? =

Yes, you can use WP Related Items (WRI) widget to display related items on the sidebar. More widget can be used, if you want display different related posts. Widgets can work contextual way, for different reference post type.

= Does WRI support WooCommerce products? =

Yes, WRI supports WooCommerce products natively.

= Does WRI support other custom post types? =

Yes. WRI uses the YARPP plugin that supports custom post types. Please find more information in YARPP documentation.

= What causes that related items do not appear? =

The problem may be caused by several reasons:

a. It is possible that the relevancy of similar products is lower than the match threshold, so YARPP can't find any related items. 
Try to use lower match threshold using one of the following ways:
- set lower threshold value for every post type on “Related Types” tab of “WP Related Items” options page.
- or leave the above fields empty and set “Match threshold” on "Related Posts (YARPP)" options page. (If you can’t find these settings on YARPP admin page, you should switch on "Relatedness options" section using "Screen Options" tab on the upper right corner of YARPP options page.)
You can try to enter the value 1 as threshold, and if you get related items, you can increase the value (if the value is too low, less relevant items will be displayed). So you can find the optimal threshold value.

b. After you change WP Related Items settings, you may need to save YARPP settings also in Settings -> Related Posts (YARPP) menu, to refresh them. So please push “Save Changes” button on “Related Posts (YARPP)” options page.

c. Try to increase relevancy between different types of post by using same words on the title or content or if you have pro version, use common categories or tags between different types of items.


== Screenshots ==

1. Displaying related items (e.g. related products similar to a post)

2. General settings page

3. Related items settings page

4. Special settings for a reference post type (e.g. for "post" post type)

5. Related items widget settings

6. Manual relationship administration (pro)

7. Common categories for different type of items to gain similarity between them (pro)


== Changelog ==

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

