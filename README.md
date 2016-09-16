# HTML code in comments

This very light WordPress plugin allows to put HTML code in comments. The code inside "code" and "pre" tags will be automatically encoded.

## Details

WordPress allows only some HTML tags in comments to prevent XSS vulnerabilities. The not allowed tags are simply deleted when
comment is posted.

Sometimes, you may have to put HTML code in your comments to answer your visitor's questions. In that case, you generally put
your HTML code between two tags : `code` and `pre`.

This plugin automatically encode HTML tags which are between `pre` and `code` tags. So WordPress will not delete your HTML code
and your code will be visible on the web-page.

## How to use

Automated installation :

1. On the plugin addition page, enter "html code comments" in the search field
2. Click the install button on the "HTML Code Comments" plugin
3. Wait for installaltion end and click the activate button.

Manual installation :

1. Unzip the downloaded zip file.
2. Upload the `html-code-comments` folder and its contents into the `wp-content/plugins/` directory of your WordPress installation
3. Activate HTML Code Comments from Plugins page.

You can now post comment with HTML content (ex : Hi ! This is HTML code : &lt;code&gt;&lt;div class=&quot;foo&quot;&gt;Verry usefull&lt;/div&gt;&lt;/code&gt;) and enjoy your HTML code successfully displayed in your comment.

## Comming soon

In a few days, I will publish an evolution which will allow to simply edit the list of allowed HTML tags in comments. Check for plugin updates regullary !

## Links

The plugin page on WordPress : https://wordpress.org/plugins/html-code-comments/

The plugin page on my website : https://ludovicscribe.fr/blog/wordpress-commentaires-html