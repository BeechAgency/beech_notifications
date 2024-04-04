# Beech Notifications

- Contributors: @joshwayman
- Donate link: https://https://github.com/beechagency/
- Tags: wordpress, notifications, no ads
- Requires at least: 6.3.1
- Tested up to: 6.4.4
- Stable tag: 6.4.2
- License: GPLv2 or later
- License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add popups and notifications to your site using the WYSIWYG editor. It is simple and stripped back and ad free. Updates are relased through the repo here on GitHub.

## Description 

Create different kinds of notifications on your site. Banners, top bars, toasts, sticky things on the right. You name it. More will be added in time.

Popup plugins typically kinda suck. They are either hella complicated, or just a wall of ads and spam. We were sick of it so built this.

It's simple to keep things simple. 

## Installation

This section describes how to install the plugin and get it working.

1. Upload `beech_notifications.zip` wordpress.
2. Configure the settings and it should just work
3. Dial in the CSS using the settings to make it better match your theme.

## Frequently Asked Questions

### Will you provide support?

No. This is as is and used for our purposes. It should work but we can't help troubleshoot it. Maybe log a bug in the issues thing and we'll try and resolve it.


### Everything looks stupid/broken

Hmm, that is a problem. CSS will be required to fix it. Ensure the plugin CSS is being loaded in and isn't conflicting with the theme CSS. You might need to add some more css yourself.

### What are the main CSS selectors?

Everything is based on the `.BEECH_notifications` selector. All notifications are placed within the primary notifications container and then placed with CSS accordingly. The titles are always `.BEECH_notifications h5` and the body text is `.BEECH_notifications p`. Note `.BEECH_notification` (singular) will also work, but stick to the plural version. The specific notification selectors are as follows:

- *Right corner* - `.BEECH_notifications .BEECH_notifications--right_corner`
- *Top Bar* - `.BEECH_notifications .BEECH_notifications--top_bar`
- *Toast (Bottom bar)* - `.BEECH_notifications .BEECH_notifications--toast`
- *Popup* - `.BEECH_notifications .BEECH_notifications--popup_dialog`


## Changelog 

### 1.2
* Options are now a thing! Hooray!
* Global test mode now an option for when you want to test your schnit
* Global disable notifications is an option
* Notification colours are now configurable.

### 1.1 
* Fixed a bug in the updater
* Added a plugin icon and banner

### 1.0
* Rebuilt the entire plugin based on a Class structure
* Notifications are now created and managed using Notifications under the Tools menu.

### 0.1
* Proof of concept release

## Roadmap

Moved to the roadmap page. [Go there and check it out.](https://github.com/BeechAgency/beech_notifications/blob/main/docs/ROADMAP.md)