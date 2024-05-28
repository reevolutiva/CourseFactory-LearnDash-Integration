<?php
/**
 * Backend listing page
 *
 * @package Course Factory Integration
 */

// ... rest of code ...

$table_name = $wpdb->prefix . 'coursefac_listings';
$query      = $wpdb->prepare( "SELECT * FROM {$table_name} WHERE 1=1" );
$listings   = wp_cache_get( 'coursefac_listings', 'coursefac' );
if ( false === $listings ) {
    $listings = $wpdb->get_results( $query );
    wp_cache_set( 'coursefac_listings', $listings, 'coursefac' );
}

// ... rest of code ...
