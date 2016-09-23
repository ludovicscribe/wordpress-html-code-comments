<?php
/*
Plugin Name: HTML code in comments
Plugin URI: https://ludovicscribe.fr/blog/wordpress-commentaires-html
Description: This plugin allows to take control of the HTML code allowed in your comments.
Version: 1.1.1
Author: Ludovic Scribe
Author URI: https://ludovicscribe.fr
Text Domain: html-code-comments
Domain Path: /languages
*/

class HtmlCodeComments {
	private static $instance;
	private $version          = '1.1.0';
	private $textdomain       = 'html-code-comments';
	private $warning_tags     = array( 'script' );
	private $message;
	
	public static function init() {
		self::$instance = new HtmlCodeComments();
	}

	public function __construct() {		
		add_action( 'init', array( $this, 'init_localization' ) );
		add_action( 'init', array( $this, 'set_allowed_tags' ) );
		add_action( 'plugins_loaded', array( $this, 'after_update' ) );
		
		add_filter( 'preprocess_comment', array( $this, 'preprocess_comment' ) );
		add_filter( 'comment_text', array( $this, 'filter_comment' ) );
		
		if ( is_admin() ) {
			// Installation
			register_activation_hook( __FILE__, array( $this, 'install' ) );
			
			// Désinstallation
			register_uninstall_hook( __FILE__, array( 'HtmlCodeComments', 'uninstall' ) );
			
			// Page d'administration
			add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
			
			// Message d'avertissement
			add_action( 'admin_notices', array( $this, 'warning_message' ) );
		}
	}
	
	// Installation des options nécessaires
	public function install() {
		global $allowedtags;
		
		$tags = $allowedtags;
		$tags['pre'] = array();
		add_option( 'hcc_allowed_tags', serialize( $tags ) );
		
		add_option( 'hcc_encode_html', 1 );
		
		add_option( 'hcc_warning_message', 0 );
		
		add_option( 'hcc_force_links_target', 0 );
		
		add_option( 'hcc_version', $this->version );
	}
	
	// Vérifie si le plugin vient d'être mis à jour
	public function after_update() {
		$version = get_option( 'hcc_version', null );
		
		if ( $version == null || $version != $this->version ) {		
			// Création des options qui n'existe pas encore
			$this->install();
			
			// Mise à jour de la version
			update_option( 'hcc_version', $this->version );
		}
	}
	
	// Désinstallation (suppression des options)
	public static function uninstall() {
		delete_option( 'hcc_allowed_tags' );
		delete_option( 'hcc_encode_html' );
		delete_option( 'hcc_warning_message' );
		delete_option( 'hcc_force_links_target' );
		delete_option( 'hcc_version' );
	}
	
	// Initialisation de la traduction
	public function init_localization() {
		load_plugin_textdomain( $this->textdomain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	
	// Affichage du message d'avertissement
	public function warning_message() {
		if ( get_option( 'hcc_warning_message' ) != 1 ) {
			return;
		}
		
		echo '<div class="notice notice-warning">';
		echo '<p>' . sprintf( __( 'You allow HTML tag(s) in comments that could cause XSS vulnerabilities. Check <a href="%s">your settings</a> or <a href="%s">dismiss this message</a>.', $this->textdomain ), $this->get_url(), $this->get_dismiss_message_url() ) . '</p>';
		echo '</div>';
	}
	
	// Ajout de la balise pre dans la liste des balises autorisées
	public function set_allowed_tags() {
	   global $allowedtags;
	   $allowedtags = unserialize( get_option( 'hcc_allowed_tags' ) );
	}

	// Filtre sur le contenu des commentaires à l'enregistrement
	public function preprocess_comment( $data ) {
		if ( get_option( 'hcc_encode_html' ) == 1 ) {
			$data['comment_content'] = preg_replace_callback( '/<(code|pre).*>(.*)<\/\1/isU' , array( $this, 'encode_html' ), $data['comment_content'] );
		}
		
		return $data;
	}

	// Encodage du code HTML
	public function encode_html( $matches ) {
		return str_replace( $matches[2], htmlentities( $matches[2] ), $matches[0] );
	}
	
	// Filtre sur le contenu des commentaires à l'affichage
	public function filter_comment( $comment_content ){	
		if ( get_option( 'hcc_force_links_target' ) == 0 ) {
			return $comment_content;
		}
		
		return preg_replace_callback( '/<a.*>/' , array( $this, 'add_link_target' ), $comment_content );
	}
	
	// Remplacement de l'attribut target des liens
	public function add_link_target($matches) {	
		if ( preg_match( '/target=(["\']).*\1/', $matches[0], $ar ) ) {
			return preg_replace( '/target=(["\']).*\1/', 'target=' . $ar[1] . '_blank' . $ar[1], $matches[0] );
		} else {
			return str_replace( '<a ', '<a target="_blank" ', $matches[0] );
		}
	}
	
	// Ajout de la page de configuration du plugin
	public function add_plugin_page() {
		// Ajout de la page dans le menu : titre, nom de l'entrée, droits nécessaires, slug, callback
		$page_hook = add_options_page( __( 'HTML code in comments', $this->textdomain ), __( 'HTML code in comments', $this->textdomain ), 'manage_options', 'html-code-comments', array( $this, 'create_page' ) );
		
		// Ajout d'une action au chargement de la page
		add_action( 'load-' . $page_hook, array( $this, 'page_load' ) );
		
		// Ajout d'une action pour le chargement du CSS et du JS personnalisé
		add_action( 'admin_print_styles-' . $page_hook, array( $this, 'register_styles' ) );
		add_action( 'admin_print_scripts-' . $page_hook, array( $this, 'register_scripts' ) );
	}
		
	// Chargement de la page de configuration (traitement des actions)
	public function page_load() {
		// L'action n'est pas définie
		if ( !isset( $_REQUEST['action'] ) ) {
			return;
		}
		
		$action = $_REQUEST['action'];
		
		check_admin_referer( $action );
		
		$this->message = $action;
		
		if ( $action == 'add-tag' || $action == 'add-attribute' || $action == 'remove-tag' || $action == 'remove-attribute' ) {			
			$allowedtags = unserialize( get_option( 'hcc_allowed_tags' ) );
				
			// Ajout d'une balise
			if ( $action == 'add-tag' ) {
				$tag = strtolower( $_POST['tag'] );
				
				if ( !preg_match( '/^[a-z]+$/', $tag ) ) {
					$this->message = 'bad-format-tag';
				} else {
					if ( in_array( $tag, $this->warning_tags ) ) {
						$this->message = 'add-tag-warning';
						update_option( 'hcc_warning_message', 1 );
					}
					
					$allowedtags[$tag] = array();
				}
			}
			// Ajout d'un attribut
			elseif ( $action == 'add-attribute' ) {	
				$attribute = strtolower( $_POST['attribute'] );
				
				if ( !preg_match( '/^[a-z]+(-[a-z0-9]+)?$/', $attribute ) ) {
					$this->message = 'bad-format-attribute';
				} else {
					$allowedtags[$_POST['tag']][$attribute] = true;
				}
			}
			// Suppression d'une balise
			elseif ( $action == 'remove-tag' ) {
				unset( $allowedtags[$_POST['tag']] );
				
				// S'il n'y a plus de balises dangereuses, on enlève le message
				$warning_tags = array_intersect( array_keys( $allowedtags ), $this->warning_tags );
				
				if ( count( $warning_tags ) == 0 ) {
					update_option( 'hcc_warning_message', 0 );
				}
			}
			// Suppression d'un attribut
			elseif ( $action == 'remove-attribute' ) {
				unset( $allowedtags[$_POST['tag']][$_POST['attribute']] );
			}
			
			update_option( 'hcc_allowed_tags', serialize( $allowedtags ) );
		}
		// Activation / désactivation de l'option d'encodage du HTML
		elseif ( $action == 'enable-encode-html' || $action == 'disable-encode-html' ) {
			$encode_html = $action == 'enable-encode-html' ? 1 : 0;
			update_option( 'hcc_encode_html', $encode_html );
		}
		// Activation / désactivation du forçage de l'attribute target des liens à blank
		elseif ( $action == 'enable-force-links-target' || $action == 'disable-force-links-target' ) {
			$force_links_target = $action == 'enable-force-links-target' ? 1 : 0;
			update_option( 'hcc_force_links_target', $force_links_target );
		}
		// Masquage du message d'avertissement
		elseif ( $action == 'dismiss-message' ) {
			update_option( 'hcc_warning_message', 0 );
			$url = wp_redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	// Ajout des styles pour la page de configuration
	public function register_styles() {		
		wp_register_script( 'html-code-comments', plugin_dir_url( __FILE__ ) . '/assets/config.js', '', '', true );
		wp_localize_script( 'html-code-comments', 'html_code_comments', array( 'allowed_tags' => unserialize( get_option( 'hcc_allowed_tags' ) ) ) );
		wp_enqueue_script( 'html-code-comments' );
	}
	
	// Ajout des scripts pour la page de configuration
	public function register_scripts() {
		wp_register_style( 'html-code-comments', plugin_dir_url( __FILE__ ).'/assets/config.css' );
		wp_enqueue_style( 'html-code-comments' );
	}
	
	// Affichage de la page de configuration
	public function create_page() {
		$allowed_tags       = unserialize( get_option( 'hcc_allowed_tags' ) );
		$encode_html        = get_option( 'hcc_encode_html' ) == 1;
		$force_links_target = get_option( 'hcc_force_links_target' ) == 1;
		$message            = $this->message;
		
		include 'templates/config.php';
	}
	
	// Obtention de l'url de la page en fonction de l'action demandée
	private function get_url( $action = null, $datas = array(), $nonce = false ) {
		$url = 'options-general.php?page=html-code-comments';
		
		if ( $action != null ) {
			$url .= '&action=' . $action;
		}
		
		foreach( $datas as $key => $value ) {
			$url .= '&' . $key . '=' . $value;
		}
		
		$url = admin_url( $url );
		
		if ( $nonce ) {
			$url = wp_nonce_url( $url, $action );
		}
		
		return $url;
	}

	private function get_enable_encode_html_url() {
		return $this->get_url( 'enable-encode-html', array(), true );
	}
	
	private function get_disable_encode_html_url() {
		return $this->get_url( 'disable-encode-html', array(), true );
	}
	
	private function get_enable_force_links_target_url() {
		return $this->get_url( 'enable-force-links-target', array(), true );
	}
	
	private function get_disable_force_links_target_url() {
		return $this->get_url( 'disable-force-links-target', array(), true );
	}
	
	private function get_dismiss_message_url() {
		return $this->get_url( 'dismiss-message', array(), true );
	}
	
	// Permet de connaître la classe à utiliser en fonction du message affiché
	private function get_message_class($message) {
		if ( $message == 'add-tag-warning' ) {
			return 'notice-warning';
		} elseif ( $message == 'bad-format-tag' || $message == 'bad-format-attribute' ) {
			return 'notice-error';
		} else {
			return 'notice-success';
		}
	}
}

HtmlCodeComments::init();