=== AutoROICalc for WooCommerce ===
Contributors: autoroicalc
Donate link: https://autoroicalc.com/
Tags: woocommerce, roi, e-commerce analytics, marketing insights, cost of goods, sales metrics
Requires at least: 3.0.1
Requires PHP: 8.0
Tested up to: 6.4.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Optimize WooCommerce sales with insightful reporting. Track ROI, analyze order profitability, and boost marketing efficiency.

== Description ==

Enhance your WooCommerce store's sales reporting and gain valuable insights into the ROI of your marketing efforts. Effortlessly track the profitability of your orders, factoring in the cost of goods sold. Make data-driven decisions to optimize your marketing channels and boost your bottom line.

AutoROICalc for WooCommerce Plugin is an extension for WooCommerce which enables custom orders performance tracking using third-party online service, autoroicalc.com.

The Plugin functionality is discarded on the sites where the WooCommerce is not installed.

An assumption for using the Plugin is to have a user account created and active at autoroicalc.com. The Plugins send the WooCommerce orders data to autoroicalc.com servers using public AutoROICalc API end-points.

The Plugin at this state only collects your WooCommerce orders performance data and sends it to the third-party service. Thus, the reporting part lies in the third-party service.

* Please find more information about the AutoROICalc third-party service [here](https://autoroicalc.com).
* Please see the AutoROICalc third-party [Terms of Service](https://autoroicalc.com/terms-of-service/) and [Privacy Policy](https://autoroicalc.com/privacy-policy/).

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the entire `auto-roi-calc-for-woocommerce` folder to the `/wp-content/plugins/` directory (or use WordPress native installer in Plugins -> Add New Plugin).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Set your AutoROICalc API credentials and select your product cost of goods meta field in *WooCommerce -> Settings -> AutoROICalc*.

An assumption to accurately calculate the profit is to have properly set up and filled out the product cost of goods meta field.

== How to Use ==

This section describes how to use the plugin.

1. **Activate the Plugin:**
   - After installing the plugin, navigate to the 'Plugins' menu in WordPress.
   - Activate "AutoROICalc for WooCommerce."

2. **Configure Settings:**
   - Go to the WooCommerce settings page.
   - Look for the "AutoROICalc" section.
   - Configure the plugin settings. Input your AutoROICalc API user name and password. Select your cost of goods (purchasing price) meta field.

3. **Track ROI:**
   - Let the plugin report your WooCommerce orders performance.
   - Utilize the detailed sales analytics to optimize your marketing strategies.

The plugin automatically calculates, collects and sends the relevant records (at this time order revenue, profit and order count) to the AutoROICalc user account.
It populates response from the AutoROICalc to the autoRoiCalcResponse meta field of an order with a recapitulation of records sent for further troubleshooting, if applicable.

== Changelog ==

= 1.0.0 =
* Initial version

== Frequently Asked Questions ==

= Does this Plugin use a 3rd Party or external service? =

Yes, the Plugin uses an external service (autoroicalc.com) where it sends your WooCommerce order information as the order revenue, or profit (if applicable). Your data is transmitted securely over an encrypted connection (HTTPS). This encryption ensures that the information sent from your WordPress/WooCommerce site and the autoroicalc.com server remains confidential and protected from unauthorized access. The data is sent exclusively to the public AutoROICalc API.

= Where can I find more information about AutoROICalc API? =

You can read more about AutoROICalc API integration at [autoroicalc.com/api-documentation](https://autoroicalc.com/api-documentation/)

= Are there any Terms of Service and a Privacy Policy? =

Here you can find the [Terms of Service](https://autoroicalc.com/terms-of-service/) and [Privacy Policy](https://autoroicalc.com/privacy-policy/).

= Will there be a feature to see some reporting directly on a WordPress site? =

Yes, we have this feature on our roadmap. We will push more on this feature development when more users are keen to have this. At this stage, there's a demand to transfer their WooCommerce orders performance data comfortably.

== Screenshots ==

1. The Plugin adds a new "AutoROICalc" tab to WooCommerce Settings for the Plugin setup.