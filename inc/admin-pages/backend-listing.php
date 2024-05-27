<?php

/**
 *  Path: wp-content/plugins/coursefactory-integration/inc/admin-pages/backend-listing.php.
 *  Este archivo contiene el codigo de la pagina de listing en la administracion de coursefactory.
 *
 * @package Course Factory Integration
 */

if ( ! defined( 'ABSPATH' ) ) exit; 

// Listamos todos los proyectos.
$req_proyects = cfac_get_list_proyects( $api_key );
$req_proyects = json_decode( $req_proyects );

$proyectos = array();

// Calculamos cuantas veces debe iterar para hacer fetch de todo.
if( isset( $req_proyects->pagination ) ){
	$pagination = $req_proyects->pagination;

	if( $pagination->limit === $pagination->offset ){
		// No paginamos
	}
	else{
		// Si $pages_number > 1 y menor que 2 significa que el numero de cursos no cabe en una sola pagina, pero tampoco hay tantos como para llenar otra pagina entera y hay que hacer una 2da peticion.
		if( $pagination->limit > 1 && $pagination->limit < 2 ){
			$second_req_proyects = cfac_get_list_proyects( $api_key, $pagination->limit );
			$second_req_proyects = json_decode( $second_req_proyects );

			foreach ($second_req_proyects->data as $item ) {
				array_push( $proyectos, $item );
			}
		}

		// Si $pages_number > 2 y es un numero entero significa que el numero de cursos no cabe en una sola pagina, pero si hay suficientes como para llenar otra pagina entera y hay que hacer una más peticiones.
		if( $pagination->limit >= 2 && is_int( $pagination->limit ) ){
			for ($i=0; $i < $pagination->limit ; $i++) { 
				$offset = $pagination->limit * $i;

				$aditional_req_proyects = cfac_get_list_proyects( $api_key, $offset );
				$aditional_req_proyects = json_decode( $aditional_req_proyects );

				foreach ($aditional_req_proyects->data as $item ) {
					array_push( $proyectos, $item );
				}
			}
		}

		if( $pagination->limit >= 2 && is_float( $pagination->limit )){
			$limit = round( $pagination->limit, 0 , PHP_ROUND_HALF_UP) ;

			for ($i=0; $i < $limit ; $i++) { 
				$offset = $pagination->limit * $i;

				$aditional_req_proyects = cfac_get_list_proyects( $api_key, $offset );
				$aditional_req_proyects = json_decode( $aditional_req_proyects );

				foreach ($aditional_req_proyects->data as $item ) {
					array_push( $proyectos, $item );
				}
			}
		}
	}
}

// Obtenemos el id de cada proyecto y mediante ese ID Listamos todas las verciones de ese proyecto.
if ( isset( $req_proyects->data ) ) {
	$proyectos = $req_proyects->data;

	// Buscamos en wp_postmeta un post_id que tenga el meta_key = cfact_project_version_id y el meta_value = id del proyecto.
	// Si lo encontramos es que hay un curso importado con ese proyecto. y si no lo encontramos es que no hay un curso importado con ese proyecto.
	$proyectos = array_map(
		function ( $e ) use ($api_key ) {
			$id = $e->id;
			global $wpdb;

			$table = $wpdb->prefix . 'postmeta';

			$post_id = (int) $wpdb->get_var(
				$wpdb->prepare(
					"SELECT post_id FROM {$table} WHERE meta_key = %s AND meta_value = %s",
					array( 'cfact_project_version_id', $id )
				)
			);

			$exits = 0 === $post_id ? false : true;

			if ( $exits ) {
				$e->exist   = 'true';
				$e->post_id = $post_id;
			} else {
				$e->exist = 'false';
			}

			// Add the API key to the project object
			$e->api_key = $api_key;

			return $e;
		},
		$proyectos
	);

	echo '<script>req_project_list = ' . wp_json_encode( $proyectos ) . ';</script>';
	echo '<div id="cfact_list"></div>';
}

// Add the API key variable at the beginning of the file
$api_key = 'your_api_key_here';

