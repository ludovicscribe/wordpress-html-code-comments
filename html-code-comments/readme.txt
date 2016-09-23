=== HTML Code Comments ===
Contributors: ludovicscribe
Tags: html, code, comment, tag
Requires at least: 1.5.2
Tested up to: 4.6.1
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows to take control of the HTML code allowed in your comments.

== Description ==

= Allowed tags edition =

WordPress allows only some HTML tags in comments to prevent XSS vulnerabilities. The not allowed tags are simply deleted when a
comment is posted. The allowed tags are stored in a global WordPress variable that you have to edit if you want add allowed tags.
With this plugin, you can simply edit this variable and add an HTML tag or an attribute to the allowed tags list. There is no file
to edit, you just have to go on the plugin configuration page and edit the allowed tags list. It's easy and efficient !

= HTML tags encoding =

Sometimes, you may have to put HTML code in your comments to answer your visitor's questions. In that case, you generally put
your HTML code between two tags : `code` and `pre`. This plugin automatically encode HTML tags which are between `pre` and `code`
tags. So WordPress will not delete your HTML code and your code will be visible on the web-page.

= Force link's target =

When your visitors put links in comments, WordPress automatically add the attribute `rel="nofollow`. It's really usefull for your
site's SEO but you perhaps don't want your visitors follow this links and they leave your site. With this plugin, you can choose
to force `target` attribute value to `_blank` in all links of your comments. So, the links will be opened in new window, your visitors
don't leave your site and you are happy.

= Contribute =

As you can see, my English is not perfect. If you want to correct me, you are welcome !

You can contact me on my website or do a pull request on Github ;)

= Links =

The Github repository (if you want to contribute) : https://github.com/ludovicscribe/wordpress-html-code-comments

The plugin page on my website : https://ludovicscribe.fr/blog/wordpress-commentaires-html

== Installation ==

Automatic installation :

1. On the plugin addition page, enter "html code comments" in the search field
2. Click the install button on the "HTML Code Comments" plugin
3. Wait for installaltion end and click the activate button.

Manual installation :

1. Unzip the downloaded zip file.
2. Upload the html-code-comments folder and its contents into the wp-content/plugins/ directory of your WordPress installation
3. Activate HTML Code Comments from Plugins page.


Next, go on the "HTML code in comments" page in "Settings" section of your WordPress administration and set your allowed tags and enable
or disable options. Finally, enjoy !

== Screenshots ==

1. List of alled HTML tags and attributes
2. Allowed HTML tags and attribuutes edition forms
3. Advanced configuration (options)

== Changelog ==

= v2.0 =

**Publication date :** 09/21/2016
 
**Features :**

	- Configuration of allowed HTML tags and attributes
	- Forcing of `target` attributes value to `_blank`
	- Adding an option to enable or disable HTML code encoding

= v1.0 =

**Publication date :** 09/15/2016

**Features :**

	- Encoding of HTML code between `code` and `pre` tags.