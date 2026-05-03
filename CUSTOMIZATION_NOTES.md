# Syngency Plugin - Posewell Models Custom Version

## Overview
This is a customized fork of the Syngency WordPress plugin (v1.4.1) specifically configured for Posewell Models. The plugin has been modified to:
1. Fix critical 404 errors on portfolio pages
2. Display custom branding throughout the admin interface
3. Prevent automatic updates from overwriting customizations

## Files Modified

### 1. `syngency.php` (Main Plugin File)
**Changes:**
- **Plugin Name**: Changed from "Syngency" to "Syngency (Posewell Models Custom)"
- **Version**: Updated to `1.4.1-posewell-1`
- **Author**: Changed to "Posewell Models (based on Syngency)"
- **Author URI**: Changed to `https://posewellmodels.com/`
- **Plugin URI**: Changed to `https://posewellmodels.com`
- **Added auto-update prevention**: Two filters prevent WordPress from automatically updating this plugin:
  - `auto_update_plugin` filter returns `false` for this plugin
  - `pre_set_site_transient_update_plugins` filter removes update notifications

### 2. `readme.txt` (Plugin Readme)
**Changes:**
- **Plugin Name**: "Syngency (Posewell Models Custom)"
- **Contributors**: Changed to `posewellmodels`
- **Tags**: Added `models, portfolio, gallery`
- **Tested up to**: Updated to `6.7`
- **Stable tag**: `1.4.1-posewell-1`
- **Description**: Rewritten to indicate this is a custom version for Posewell Models
- **Added notice**: "**This is a custom fork and will not receive automatic updates from the original Syngency plugin.**"

### 3. `admin/class-syngency-admin.php` (Admin Interface)
**Changes:**
- **Menu Title**: Changed from "Syngency" to "Syngency PM" (shorter for admin menu)
- **Page Title**: Changed to "Syngency (Posewell Models)"
- **Menu Icon**: Changed from custom SVG logo to WordPress dashicons camera icon (`dashicons-camera`)
- **Admin Header**: Replaced complex SVG logo with simple text header: "📸 Posewell Models Syngency"
- **Settings Header**: Changed from "Syngency Settings" to "Plugin Settings"

## Bug Fixes Already Applied

All critical issues from the original plugin have been fixed:

1. ✅ **Rewrite Rules**: Fixed empty `activate_syngency()` function - now properly registers and flushes rewrite rules
2. ✅ **Query Vars**: `model` query var properly registered
3. ✅ **PHP 8 Compatibility**: All `get_option()` calls include default empty array `[]`
4. ✅ **Init Hook**: Rewrite rules registered on every `init` hook via `add_rewrite_rules()` method
5. ✅ **HTTPS**: All API calls use `https://` protocol
6. ✅ **Performance**: Removed unnecessary `flush_rewrite_rules()` calls on every page load

## Installation Instructions

1. Upload the modified plugin files to `/wp-content/plugins/syngency/`
2. Deactivate and reactivate the plugin in WordPress admin
3. OR visit **Settings → Permalinks** and click "Save Changes" to flush rewrite rules
4. Portfolio URLs should now work correctly

## Testing

After installation, verify:
- ✅ Division galleries display correctly
- ✅ Individual portfolio pages work (e.g., `/divisions/female/portfolios/ashley-avery`)
- ✅ Admin menu shows "Syngency PM" with camera icon
- ✅ Admin header displays "📸 Posewell Models Syngency"
- ✅ No update notifications appear for this plugin

## Future Maintenance

Since automatic updates are disabled:
- Manual updates will be required when WordPress core changes affect plugin compatibility
- Security patches from the original Syngency plugin will need to be manually reviewed and merged
- Keep track of the custom version number (`1.4.1-posewell-1`) for future updates

## Original Issues Reference

For reference, the original issues that were fixed can be found in the `ISSUES.md` file in this repository. These fixes are retained in this custom version.
