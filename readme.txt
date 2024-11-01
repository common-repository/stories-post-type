=== Plugin Name ===
Contributors: Fran_Ontanaya
Donate link: http://bestseller.franontanaya.com/
Tags: custom post, custom taxonomies
Requires at least: 3.0.0
Tested up to: 3.0.4
Stable tag: 1.2.2

Adds a custom post type called Stories with a last stories widget, three taxonomies: Works, Sections and Licenses, and a shortcode to list all works.

== Description ==

This plugin adds a Stories custom post type with thumbnails and revisions enabled and three taxonomies: Works, Sections and Licenses.

The Works taxonomy can be sorted by drag and drop. You can embed the list of works in any entry using the &#91;indexofstories&#93; shortcode. The taxonomies Sections and Licenses are prefilled the first time you run the plugin with some common terms.

The plugin adds also a widget to display the latest stories with their title, thumbnail and taxonomic classification. A default image is displayed when thumbnails are enabled in the widget options but the story has no featured image selected.

It contains actions to add the custom post type to Anthologize and Google XML Sitemap plugins, and includes Spanish and Catalonian translations.

== Installation ==

1. Add it from your plugins page, or upload the zip with WordPress' built-in tool, or unzip it to 'wp-content/plugins'.
2. Activate it.
3. Start creating Stories, or switch regular posts to stories with a plugin like Post Type Switcher.

== Frequently Asked Questions ==

= There are already generic plugins to manage custom posts and taxonomies. What's the point of this one? =

I created this plugin for a group of writers that needed to publish fiction online. Our requeriments were very specific; also, in these cases, deciding the proper structure of content and taxonomies is even more complicated than just deciding to use a custom post type. 

With a pre-cooked post type there is less need to set-up and configure anything, and since we use the same structure, we can share whatever we learn about how to improve it or connect it with common platforms (i. e. 'robot' magazines). 

= I'd love to have a similar plugin for a different kind of content =

Sure! Start a thread in the forum to discuss what would be a good structure for that kind of content. Once I feel this plugin is polished I plan to merge it into a generic core with several premade post type templates.

== Screenshots ==

1. The new custom post and the related taxonomies are displayed in the sidebar of the administration panel.

== Changelog ==
= 1.2.2 =
* Escaped all HTML output as PHP echos.
* Compatibility bump to 3.0.4.

= 1.2.1 =
* Removed trailing line break

= 1.2 =
* Added widget description
* Readied for the plugin directory
* Added [indexofstories] shortcode to output the complete Works taxonomy tree.

= 1.1 =
* Added temporary support for Stories custom post type to Anthologize plugin
* Added support for thumbnails to Stories.
* Added recent stories widget

= 1.0 =
* First release. 

== Upgrade Notice ==

= 1.0 =
First release. You don't need to use this plugin if you are using Bestseller Theme for WordPress 0.5.0 or lesser.
