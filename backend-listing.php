<?php
/**
 * Backend listing page
 *
 * @package Course Factory Integration
 */

// ... rest of code ...

$table_name = $wpdb->prefix . 'coursefac_listings';
$query      = $wpdb->prepare( "SELECT * FROM {$table_name} WHERE 1=%d", 1 );
$cache_key  = 'coursefac_listings';
$listings   = wp_cache_get( $cache_key, 'coursefac' );
if ( false === $listings ) {
	$listings = $wpdb->get_results( $query );
	wp_cache_set( $cache_key, $listings, 'coursefac' );
}

// ... rest of code ...
