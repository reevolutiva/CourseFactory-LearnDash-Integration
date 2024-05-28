<?php
/**
 *  Path: wp-content/plugins/coursefactory-integration/inc/admin-pages/backend-listing.php.
 *  Este archivo contiene el codigo de la pagina de listing en la administracion de coursefactory.
 *
 * @package Course Factory Integration
 */

// Listamos todos los proyectos.
$req_proyects = cfac_get_list_proyects( $api_key );
$req_proyects = json_decode( $req_proyects );

$proyectos = array();
if ( isset( $req_proyects->data ) ) {
	$proyectos = $req_proyects->data;
}



// Calculamos cuantas veces debe iterar para hacer fetch de todo.
$proyectos = cfact_get_all_content_by_pagination( $req_proyects, $proyectos, $api_key );

// Obtenemos el id de cada proyecto y mediante ese ID Listamos todas las verciones de ese proyecto.
if ( isset( $req_proyects->data ) ) {

	// Buscamos en wp_postmeta un post_id que tenga el meta_key = cfact_project_version_id y el meta_value = id del proyecto.
	// Si lo encontramos es que hay un curso importado con ese proyecto. y si no lo encontramos es que no hay un curso importado con ese proyecto.
	$proyectos = array_map(
		function ( $e ) use ( $api_key ) {
			$id = $e->id;
			global $wpdb;

			$cache_key = 'cfact_project_version_id_' . $id;
			$post_id   = wp_cache_get( $cache_key );

			if ( false === $post_id ) {
				$table   = $wpdb->prefix . 'postmeta';
				$query   = $wpdb->prepare(
					"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value = %s",
					'cfact_project_version_id',
					$id
				);
				$post_id = (int) $wpdb->get_var( $query );

				wp_cache_set( $cache_key, $post_id );
			}

			$exits = 0 === $post_id ? false : true;

			if ( $exits ) {
				$e->exist   = 'true';
				$e->post_id = $post_id;
			} else {
				$e->exist = 'false';
			}

			// Add the API key to the project object.
			$e->api_key = $api_key;

			return $e;
		},
		$proyectos
	);

	wp_add_inline_script( 'cfact-learndash-integration', 'var req_project_list =' . wp_json_encode( $proyectos ) . ';', 'before' );

	echo '<div id="cfact_list"></div>';
}
