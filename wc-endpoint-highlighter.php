<?php
/*
Plugin Name: WC Endpoint Highlighter
Plugin URI: https://github.com/obiPlabon/wc-endpoint-highlighter/
Description: "WooCommerce Endpoint" label is added to all WooCommerce endpoint menu items.
Version: 0.0.7
Author: Obi Plabon
Author URI: http://obiPlabon.im/
License: GPLv2 or later
Text Domain: wc-endpoint-highlighter
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright http://obiPlabon.im/
*/

if ( ! defined( 'ABSPATH' ) ) {
    die();
}

class Wc_Endpoint_Highlighter {
    
    public function __construct() {
        // Filter menu item and modify item label
        add_filter( 'wp_setup_nav_menu_item', array($this, 'highlight') );
    }

    /**
     * Add "WooCommerece Endpoint" label to all WooCommerce endpoint menu items
     * @param  object $item Menu item object
     * @return object       Modified menu item object
     */
    public function highlight( $item ) {
        if ( ! function_exists( 'WC' ) ) {
            return $item;
        }

        $endpoints = WC()->query->query_vars;

        if ( 'custom' === $item->type && (
            array_key_exists( $this->get_endpoint( $item->url ), $endpoints ) ||
            in_array( $this->get_endpoint( $item->url ), $endpoints ) ) ) {

            $item->title = ucwords( str_replace( '-', ' ', $item->title ) );
            $item->type_label = 'WooCommerce Endpoint';
        }
        return $item;
    }

    /**
     * Extract WooCommerce endpoint from url
     * @param  string $url Url that contains WooCommerce endpoint
     * @return string      Only WooCommerce endpoint
     */
    private function get_endpoint( $url ) {
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
