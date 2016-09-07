<?php
/*
Plugin Name: HTML code in comments
Plugin URI: http://ludovicscribe.fr/blog/wordpress-commentaires-html
Description: Permet d'encoder le code HTML contenu dans les balises <code>&lt;code&gt;</code> et <code>&lt;pre&gt;</code> des commentaires.
Version: 1.0
Author: Ludovic Scribe
Author URI: http://ludovicscribe.fr
*/

// Ajout de la balise pre dans la liste des balises autorisées
function comment_post_allow_html_tags() {
   global $allowedtags;
   $allowedtags['pre'] = array();
}

add_action( 'init', 'comment_post_allow_html_tags' );  

// Remplacement des caractères contenus dans les balises pre et code par leurs entités HTML
function preprocess_comment_encode_html( $data ) {
	$data['comment_content'] = preg_replace_callback( '/<(code|pre).*>(.*)<\/\1/isU' , 'comment_encode_html', $data['comment_content'] );
	return $data;
}

add_filter( 'preprocess_comment', 'preprocess_comment_encode_html' );

function comment_encode_html( $matches ) {
	return str_replace( $matches[2], htmlentities($matches[2]), $matches[0] );
}