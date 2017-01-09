<?php
/**
 * Plugin Name: WC Endpoint Highlighter
 * Plugin URI: http://obiPlabon.im/
 * Author: Obi Plabon
 * Author URI: http://obiPlabon.im/
 * 
 */

if ( !defined( 'ABSPATH' ) ) {
	die();
}

class Wc_Endpoint_Highlighter {
	
	public function __construct() {
		add_filter( 'wp_setup_nav_menu_item', array($this, 'highlight') );
	}

	public function highlight( $item ) {
		$endpoints = WC()->query->query_vars;

		if ( 'custom' === $item->type && (
			array_key_exists( $this->get_endpoint( $item->url ), $endpoints ) ||
			in_array( $this->get_endpoint( $item->url ), $endpoints ) ) ) {

			$item->title = ucwords( str_replace( '-', ' ', $item->title ) );
			$item->type_label = 'WooCommerce Endpoint';
		}
		return $item;
	}

	public function get_endpoint( $url ) {
		$url = rtrim( $url, '/&' );

		if ( false !== strripos( $url, '&' ) ) {
			$endpoint = strrchr( $url, '&' );
		} else {
			$endpoint = strrchr( $url, '/' );
		}
		return ltrim( $endpoint, '/&' );
	}

}

new Wc_Endpoint_Highlighter;
