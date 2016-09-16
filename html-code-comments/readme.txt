=== HTML Code Comments ===
Contributors: ludovicscribe
Tags: html, code, comment, tag
Requires at least: 1.5.2
Tested up to: 4.6.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This very light plugin allows to put HTML code in comments. The code inside "code" and "pre" tags will be automatically encoded.

== Description ==

WordPress allows only some HTML tags in comments to prevent XSS vulnerabilities. The not allowed tags are simply deleted when
comment is posted.

Sometimes, you may have to put HTML code in your comments to answer your visitor's questions. In that case, you generally put
your HTML code between two tags : `code` and `pre`.

This plugin automatically encode HTML tags which are between `pre` and `code` tags. So WordPress will not delete your HTML code
and your code will be visible on the web-page.


= Comming soon =

In a few days, I will publish an evolution which will allow to simply edit the list of allowed HTML tags in comments. Check for plugin updates regullary !

= Links =

* The Github repository (if you want to contribute) : https://github.com/ludovicscribe/wordpress-html-code-comments
* The plugin page on my website : https://ludovicscribe.fr/blog/wordpress-commentaires-html

== Installation ==

1. Unzip the downloaded zip file.
2. Upload the `html-code-comments` folder and its contents into the `wp-content/plugins/` directory of your WordPress installation
3. Activate HTML Code Comments from Plugins page.
5. Post comment with HTML content (ex : Hi ! This is HTML code : &lt;code&gt;&lt;div class=&quot;foo&quot;&gt;Verry usefull&lt;/div&gt;&lt;/code&gt;).
6. Enjoy HTML code successfully displayed in your comment ;)