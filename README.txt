=== Plugin Name ===
Contributors: enriquemorillo
Tags: blockchain, authorship, register, proof of existence
Requires at least: 4.0
Tested up to: 5.1.1
Stable tag: 4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Mingrana WP register your posts in Ethereum Blockchain.

== Description ==

Mingrana WP registers your posts in the Ethereum Blockchain.

How it works is described below:

*   The plugin convert the content of your post into PDF.
*   The plugin calculates the SHA256 hash.
*   The plugin sends to Mingrana Server the hash and the PDF in order to stamp the hash in Ethereum Blockchain.
*   When you refresh the post status, an stamp is shown in your post.

PD: You will need and [Mingrana.com API Key](https://mingrana.com/ "Ask for an Mingrana API Key") to use it. You can ask for it in the link.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wp-mingrana` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the ‘Plugins’ screen in WordPress.
3. Use the `Settings` -> `WP MIngrana` screen to configure the plugin.

== Changelog ==
= 1.0.0 =
* First stable version.
= 1.0.4 =
* Improve Server Class.

== Screenshots ==

1. screenshot-1.png