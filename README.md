# BP Nouveau - Next Generation Template Packs


This repo is a work in progress and represents the work to bring the next generation of improved,radically updated and re-worked BuddyPress templates to completion.

The estimated time of arrival is hopefully to be around the end of the current BP 2.8 release cycle, however that may be delayed depending on how functional and tested the theme is.

## Some notes about the progess so far...

The initial backend prep has been provided by imath, adding the base templates and a good deal of new and customized functionality such as backbone views for component loops along with an advanced structure for includes below can be seen screen shots & explanations of some of the features imath has added to improve various components.

A new and updated approach to SCSS partial style files is provided and itteration over these to establish a whole new  styling and layout for this and future packs/themes is nearing completion.



### This repo is designed to work as a plugin and is fully functional representing a template pack and tools to manage template packs!

Once activated, this plugin will first create a new Admin tabs in the BuddyPress settings *Template Packs*. It displays a list of the available template packs for the site and it helped me to come back to Legacy while building the "BP Nouveau" one. This screenshot will explain itself what this UI could bring to the user...
![The Primary Nav Widget](https://cldup.com/bAj2DOrkq7.png)

N.B. For testing please add `define('SCRIPT_DEBUG', true);` to your wp-config.php file just below the wp_debug define or set from false to true if already present.

The supports column is there to inform what components are supported by the template pack. For instance, the "Retired" forums component is not supported by this template pack (for now...)

Another tool is more for developers: the directory tools/i18n of this repo contains a script to easily create a pot file for a standalone template pack. So far we haven't figured out this as Legacy is using the 'buddypress' text domain, but as it's possible with this plugin to add new template packs inside the `/wp-content/bp-templates` repository (or any other location using the `next_template_packs_locations` and `next_template_packs_url` filters by the way) I thought this possibility was lacking (`wp-plugin` doesn't match our needs i think).

### Primary nav, horizontally or vertically thanks to a widget!

I've added new templates to be able to load the primary nav dynamically: where it is today or in a widget. This leaves the choice to the user about the layout of this area. (horizontally or vertically)
![The Primary Nav Widget](https://cldup.com/a8FG-YCoMG.png)

### Javascript - updated and improved ###

A primary focus has been on Javascript and Ajax actions, by trying to split the huge buddypress.js file into smaller parts, loading it into the footer and loading smaller parts only when needed and by using json replies into the Ajax actions.

### A more dynamic activity stream

+ Search! Actually i've added search almost everywhere i could :)
+ "Timesinces" are updated thanks to Heartbeat
+ Dynamic tabs to inform if new activities are coming from members, friends, mentions...
+ Other Heartbeat improvements.
![The Activity stream](https://cldup.com/HA9o9VTHSI.png)

I haven't included the things i've been working on for the Activity post form, because it needs some more work on my side. But this [video](https://vimeo.com/142743652) demonstrates it.

### A new private messages UI

+ Rich text editor
+ single page App.
+ Use the @mentions script to contact any member of the community
![The compose screen](https://cldup.com/dYpurmRDeR.png)

+ New UI, looking a bit like a regular Email software :)
![The compose screen](https://cldup.com/4m3xDwXswY.png)

Here's a [full preview](https://vimeo.com/146148812) of this new UI.

An important choice i've made was to move the Site wide notices out of this UI because the objects are really different. I think this should live in the notifications component by the way.. So you'll find the sitewide notices into the WordPress Administration as a sub menu of the Users one.
![Add new notices](https://cldup.com/GBWOXYFWzW.png)

FYI, you'll find notice errors we'll need to fix [upstream](https://buddypress.trac.wordpress.org/ticket/6750)
![The bubble](https://cldup.com/0R4Uut2_5O.png)

Here's how it looks on the front-end, once the user clicks on the bubble:
![User's profile header](https://cldup.com/skiLBofHCv.png)

### A new Group's invite UI

Our current UI is really improvable imho. It lacks user feedback and the possibility to invite any member. It makes no sense to be so dependant of the Friends component to invite users to join a group imho.
So this UI will make sure you can invite any member, and if the friends component is active, narrow your search to these friends :
![The bubble](https://cldup.com/Zp3MkQ9ZsJ.png)

It's built like the Private Messages UI as a single page App and the Send Invites nav acts a bit like the checkout of an ecommerce website. You add users to it and when you're ready to invite them, you simply send the invite and as it's generating a mail, it could also send a message to explain why the user(s) should join the group.
![The bubble](https://cldup.com/SrHzWn8BXt.png)

Here's a full [preview](https://vimeo.com/145308971) of this new UI.


*TO BE CONTINUED!*



