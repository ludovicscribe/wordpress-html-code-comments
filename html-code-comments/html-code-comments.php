<?php
/*
Plugin Name: HTML code in comments
Plugin URI: https://ludovicscribe.fr/blog/wordpress-commentaires-html
Description: This very light plugin allows to put HTML code in comments. The code inside "code" and "pre" tags will be automatically encoded.
Version: 1.0.1
Author: Ludovic Scribe
Author URI: https://ludovicscribe.fr
*/

// Ajout de la balise pre dans la liste des balises autorisées
function hcc_allow_html_tags() {
   global $allowedtags;
   $allowedtags['pre'] = array();
}

add_action( 'init', 'hcc_allow_html_tags' );  

// Remplacement des caractères contenus dans les balises pre et code par leurs entités HTML
function hcc_preprocess_comment( $data ) {
	$data['comment_content'] = preg_replace_callback( '/<(code|pre).*>(.*)<\/\1/isU' , 'hcc_encode_html', $data['comment_content'] );
	return $data;
}

add_filter( 'preprocess_comment', 'hcc_preprocess_comment' );

function hcc_encode_html( $matches ) {
	return str_replace( $matches[2], htmlentities($matches[2]), $matches[0] );
}