## The Official Syngency plugin for WordPress ##

Display your Syngency divisions, models, and galleries, on your WordPress website.

### Installation ###

1. **Visit** Plugins > Add New
2. **Search** for "Syngency"
2. **Install and Activate** the `Syngency` plugin from the plugins page
3. **Visit** your Syngency account (eg: _yourdomain.syngency.com_) and click **Settings > API**, check the box labelled _Enable API Access_, click _Save_, and then copy the _API Key_.
4. **Paste** the API Key to the **Syngency > API Settings** section in WordPress. You'll also need to enter your Syngency domain (in the format `yourdomain.syngency.com`)

### Options ###

#### Create Division Pages ####
*Create and manage your division pages by checking each division and **Click** 'Save' to create division pages automatically.
*Toggle division page status by selecting 'Publish'/'Draft'.
Create pages by also clicking on the "Shortcode" button and pasted into your Post / Page.

#### Appearance ####
Select which measurement fields are listed on the model portfolio template.

#### Gallery Image Size #####
Select which image size (Small/Medium/Large) will be used to display gallery images.

#### Gallery Images Link To ####
Select which image size (Small/Medium/Large) will be linked to from gallery images.

#### Templates ####
The **Division** and **Model** templates use a combination of HTML, CSS, [Liquid](https://www.shopify.com/partners/shopify-cheat-sheet), and Javascript (optional) to control the look and functionality of the pages rendered by the plugin. Any changes made to these templates will be reflected on your site.

### Usage ###

**Method 2**
Create a page by checking each division and **Click** 'Save' to create division pages automatically.

**Method 1**
[Create a page](https://wordpress.org/support/article/pages/#creating-pages) for your first Syngency division, and place the following shortcode, along with a reference to the URL of the Syngency division you wish to display on that page:

`[syngency division="fashion-models"]`

Additionally, the `office` attribute, and division gender filter (men/women/boys/girls/non-binary) can be added to filter the division results:

`[syngency office="chicago" division="fashion-models/women"]`

The `office` attribute must be the name of the associated office subdomain you have added under **Settings > Domains** in Syngency.