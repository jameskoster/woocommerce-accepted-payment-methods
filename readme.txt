=== WooCommerce Accepted Payment Methods ===
Contributors: jameskoster
Tags: woocommerce, credit card, logo, payment
Requires at least: 4.0
Tested up to: 4.0
Stable tag: 0.7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Extends WooCommerce giving you the option to display accepted payment methods via widget, shortcode or template tag.

== Description ==

Sometimes you need to you want to inform your customers which payment methods are accepted on your WooCommerce store before they reach the checkout.

WooCommerce Accepted Payment Methods extends the WooCommerce settings allowing you to specify which payment methods your store accepts.

The specified payment methods can then be displayed on the frontend via a widget, a shortcode or by adding a template tag directly to your theme.

Please feel free to contribute on <a href="https://github.com/jameskoster/woocommerce-accepted-payment-methods">github</a>

== Installation ==

1. Upload `woocommerce-accepted-payment-methods` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Specify which payment methods you accept on the Checkout tab of the WooCommerce settings screen
4. Display your accepted methods via: Widget, Shortcode `[woocommerce_accepted_payment_methods]` or template tag `wc_accepted_payment_methods();`.
5. Done!

== Frequently Asked Questions ==

= Payment method x is missing, what gives? =

I've added some popular payment methods to begin with, if you want to see more let me know on <a href="http://twitter.com/jameskoster">twitter</a> or better yet, <a href="https://github.com/jameskoster/woocommerce-accepted-payment-methods">contribute on Github</a>.

== Screenshots ==

1. The Accepted Payment Methods options
2. The widget

== Changelog ==

= 0.6.0 - 12/09/2014 =
* Tweak - Specify box sizing in css.

= 0.6.0 - 04/18/2014 =
* New - cash on delivery symbol (Kudos chirag-v)
* New - Danish translation (props MamaTux)
* Fix - broken link in widget
* Tweak - Removed btc

= 0.5.0 - 04/02/2014 =
* WooCommerce 2.1 compatibility (now required WooCommerce 2.1).
* NL translation. Kudos @ramoonus

= 0.4 - 07/06/2013 =
* Added Bitcoin & BTC (Kudos piit79)
* Added Maestro

= 0.3 - 30/05/2013 =
* Added Discover
* Renamed widget to match WooCommerce core naming convention & added link to configure options
* Stripped object pass by reference
* Added en_GB po/mo

= 0.2.2 - 01/04/2013 =
* UI tweak to be inline with 2.0s slightly updated settings API
* Improved i18n (Kudos deckerweb)
* Added missing Gettext syntax (Kudos deckerweb)
* Changed loading call for textdomain (with correct textdomain) (Kudos deckerweb)
* Unified textdomain (Kudos deckerweb)
* Added default .po file for translators (Kudos deckerweb)
* Added full German translations (Kudos deckerweb)

= 0.2.1 - 07/02/2013 =
* styles correctly hooked into wp_enqueue_scripts();

= 0.2 - 16/01/2013 =
* Widget now uses title rather than 'label' option. Remove and re-add the widget to set the title when upgrading

= 0.1 =
Initial release.