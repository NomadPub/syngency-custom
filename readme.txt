=== Syngency ===
Contributors: syngency
Tags: syngency
Requires at least: 5.8
Tested up to: 6.5
Stable tag: 1.4.1
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display Syngency divisions, models, and galleries on your WordPress website.

== Description ==

Syngency's WordPress plugin enables you to display your divisions, models, and galleries from Syngency on your WordPress website.
Any changes made in Syngency are reflected on your WordPress site instantly, and you have complete control of the way the division and model portfolio templates that are displayed on your site.

Important: Use of this plugin is in accordance with the [Syngency Terms of Service](https://syngency.com).

== Installation ==

From your WordPress dashboard

1. **Visit** Plugins > Add New
2. **Search** for "Syngency"
2. **Install and Activate** the `Syngency` plugin from the plugins page
3. **Visit** your Syngency account (eg: _yourdomain.syngency.com_) and click **Settings > API**, check the box labelled _Enable API Access_, click _Save_, and then copy the _API Key_.
4. **Paste** the API Key to the **Syngency > API Settings** section in WordPress. You'll also need to enter your Syngency domain (in the format `yourdomain.syngency.com`)

== Options ==

#### Create Division Pages ####
*Create and manage your division pages by checking each division and **Click** 'Save' to create division pages automatically.
*Toggle division page status by selecting 'Publish'/'Draft'.
*Create pages by also clicking on the "Shortcode" button and pasted into your Post / Page.

#### Appearance ####
Select which measurement fields are listed on the model portfolio template.

#### Gallery Image Size #####
Select which image size (Small/Medium/Large) will be used to display gallery images.

#### Gallery Images Link To ####
Select which image size (Small/Medium/Large) will be linked to from gallery images.

#### Templates ####
The **Division** and **Model** templates use a combination of HTML, CSS, [Liquid](https://www.shopify.com/partners/shopify-cheat-sheet), and Javascript (optional) to control the look and functionality of the pages rendered by the plugin. Any changes made to these templates will be reflected on your site.

== Usage ==

[Create a page](https://wordpress.org/support/article/pages/#creating-pages) for your first Syngency division, and place the following shortcode, along with a reference to the URL of the Syngency division you wish to display on that page:

`[syngency division="fashion-models"]`

Additionally, the `office` attribute, and division gender filter (men/women/boys/girls/non-binary) can be added to filter the division results:

`[syngency office="chicago" division="fashion-models/women"]`

The `office` attribute must be the name of the associated office subdomain you have added under **Settings > Domains** in Syngency.

== Changelog ==

= 1.4.0 =
*Release Date 9th April 2024*

* Fix - Division pages and models pages working correctly in PHP 8.0 
* Enhancement - Syngency plugin is now a Admin Panel Menu Item and no longer in the Admin 'Settings > Syngency' Menu.
* Enhancement - List of all divisions with checkboxes and shortcode preview, creates division pages automatically when you **Click** 'Save'.
* Enhancement - Toggle division page status from "Publish" or "Draft". 
* Enhancement - Templates > Model now displays Video & Audio files (YouTube, Vimeo, MP4, MP3)
* Enhancement - Admin Area frontend revamp

= 1.4.1 =
*Release Date 29th April 2024*

* Fix - Code Editor textbox displays under the header when scrolling
* Enhancement - New heading panel placed below the Syngency header with the "Save" Button fixed to the top.
* Enhancement - Admin area elements styled with custom styles and icons.
* Enhancement - New headers created with subheaders for page modifications under "Manage Division & Model Page Settings" and "Customize Templates".
* Enhancement - Copy "Shortcodes" by clicking on the shortcode button under Divisions.  
* Enhancement - Measurements header changed to "Apperance" and checkboxes replaced select menu.
* Enhancement - Template Code Editor styled in a Dark Theme.
* Enhancement - Registered pages has a new action to view division page / edit page
* Enhancement - Error messages styled.
* Enhancement - Notifications modal added.