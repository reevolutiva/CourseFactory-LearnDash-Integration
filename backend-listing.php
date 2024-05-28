<?php

// ... rest of code ...

$table_name = $wpdb->prefix . 'coursefac_listings';
$query      = "SELECT * FROM {$table_name}";
$listings   = $wpdb->get_results( $query );

// ... rest of code ...
