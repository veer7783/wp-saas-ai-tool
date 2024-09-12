=== Trustloud Text Generator with MyCred Integration ===
Contributors: Trustloud
Tags: openai, text generation, mycred, points, ajax, api
Requires at least: 5.6
Tested up to: 6.3
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin allows users to generate text using the OpenAI API while integrating point deduction via the MyCred plugin. Users must have enough points in their MyCred balance to generate text. WordPress site hosting the AI tool use as SaaS

== Description ==

**OpenAI Text Generator with MyCred Integration** is a WordPress plugin that allows users to generate text using the OpenAI API, specifically leveraging the GPT-3.5 model. Before the API is called, the plugin checks if the user is logged in and has enough points in their MyCred wallet. Each API call deducts 5 points from the user's balance.

Key features:
- Integrates OpenAI text generation with WordPress.
- Checks if the user is logged in before generating text.
- Requires at least 5 MyCred points to generate text.
- Deducts 5 points for each generation.
- Provides error messages if the user doesn’t have enough points, isn’t logged in, or if an API error occurs.
- Customizable prompt based on user input.
- Fetches data using AJAX and handles responses gracefully on the front-end.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/trustloud-ai-text-generator` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Ensure that the [MyCred plugin](https://wordpress.org/plugins/mycred/) is installed and activated.
4. Set your OpenAI API key in the plugin settings (you’ll need an API key from OpenAI).
5. Use the provided shortcode `[trustloud_text_generator]` to display the text generation form on any page or post.

== Usage ==

1. Ensure that users are logged in and have enough points in their MyCred wallet.
2. Place the `[trustloud_text_generator]` shortcode wherever you want the form to appear.
3. Users can input a topic and generate a short story (or any desired prompt) based on the OpenAI API response.
4. Each time a user generates text, 5 points will be deducted from their balance.

== Frequently Asked Questions ==

= How does the plugin check user points? =
The plugin uses the MyCred plugin's `mycred_get_users_balance()` function to check the current user's balance before generating text.

= How do I set up the OpenAI API key? =
Once the plugin is installed, go to the plugin's settings page and input your OpenAI API key, which can be obtained from OpenAI's platform.

= What happens if the user does not have enough points? =
An error message is displayed, informing the user that they need at least 5 points to generate text.

= Can I change the number of points required? =
Yes, you can modify the point deduction amount by editing the line that calls `mycred_subtract()` in the plugin code.

== Screenshots ==

1. **Text Generation Form** - A simple form where users can input a topic and generate text using OpenAI.
2. **Error Handling** - Displays an error if the user doesn’t have enough points.
3. **Settings Page** - A page for setting your OpenAI API key.

== Changelog ==

= 1.0.0 =
* Initial release of the OpenAI text generation plugin with MyCred integration.
* Basic functionality for checking user points and generating text.
* AJAX-based text generation with real-time error feedback.

== Upgrade Notice ==

= 1.0.0 =
First release of then Trustloud AI Text Generator with MyCred Integration. 

== License ==

This plugin is licensed under the GPLv2 or later. You can find the full license text here: https://www.gnu.org/licenses/gpl-2.0.html
# wp-saas-tool
