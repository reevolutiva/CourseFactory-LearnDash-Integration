<?php
/**
 *  Path: wp-content/plugins/coursefactory-integration/inc/backend-listing.php.
 *  Este archivo contiene el codigo de la pagina de listing en la admistracion de coursefactory.
 *
 * @package Course Factory Integration
 */

if ( ! defined( 'ABSPATH' ) ) exit; 

// Listamos todos los proyectos.

$req_proyects = cfac_get_list_proyects( $api_key );
$req_proyects = json_decode( $req_proyects );

$proyectos = array();

// Calculamos cuantas veces debe iterar para hacer fech de todo.



// Guardamos la paginacion del proyecto.
$pagination = "";
$pages_number = 0 ;

#error_log( print_r( $req_proyects, true ) );

if( $req_proyects->pagination ){
	$pagination = $req_proyects->pagination;


	# 1. Preguntamos si hay más de una pagina.
	$offset = $pagination->count - $pagination->limit;
	
	// Si hay un exedente mayor a 0 es que tiene mas de una pagina y $offset es el numero de cursos que no caben
	// en esta página.
	if( $offset > 0 ){

		# 2. Calculamos cuantas veces debe iterar para hacer fetch de todo.
		$pages_number = $pagination->count / $pagination->limit ;


		// Si $pages_number > 1 significa que el numero de cursos no cabe en una sola pagina
		
		// if( $pages_number > 1 ){
			
		// 	// Si el numero de paginas es un numero entero.
		// 	if( is_int( $pages_number ) ){

		// 		// Si el numero de paginas es un numero entero.
		// 		$pages_number = $pages_number - 1;

		// 	}else{

		// 		// Si el numero de paginas no es un numero entero.
		// 		$pages_number = floor( $pages_number );

		// 	}

		// }
		
	}

}

// Obtenemos el id de cada proyecto y mediante ese ID Listamos todas las verciones de ese proyecto.
if ( $req_proyects->data ) {

	$proyects = $req_proyects->data;

	# ¿Necesitamos paginar?
	# Sí limit es igual a offset no lo necesitamos.

	if( $pagination->limit === $pagination->offset ){
		## No paginamos
	}

	# Sí limit no es igual a offset necesitamos paginar.
	if( $pagination->limit !== $pagination->offset ){

		# Si $pages_number es mayor que 1 y menor que 2 significa que el numero de cursos no cabe en una sola pagina, pero tampoco hay tantos como para llenar otra pagina entera y hay que hacer una 2da peticion.
		if( $pages_number > 1 && $pages_number < 2  ){
			
			// En la segunda peticion se desplaza ol ofset tantas veces como proyectos se contaron en la peticion ainterior.
			// De esta manera en la 2da peticion solo llegaran los proyectos que no estaban en la peticion anterior
			$second_req_proyects = cfac_get_list_proyects( $api_key, $pagination->limit );
			$second_req_proyects = json_decode( $second_req_proyects );

			# Iteramos los proyectos nuevos.
			foreach ($second_req_proyects->data as $item ) {
				# Los añadimos a la lista anterior.
				array_push( $proyects, $item );
			}			
		}

		# Si $pages_number es mayor que 2 y es un numero entero significa que el numero de cursos no cabe en una sola pagina, pero si hay suficientes como para llenar otra pagina entera y hay que hacer una más peticiones.
		if( $pages_number >= 2 && is_int( $pages_number ) ){

			# Se hacem tamtas peticiones como $paginas existan.
			for ($i=0; $i < $pages_number ; $i++) { 

				// El $offset se calcula multiplicando el limite por el numero de iteracion.
				$offset = $pagination->limit * $i;

				$aditional_req_proyects = cfac_get_list_proyects( $api_key, $offset  );
				$aditional_req_proyects = json_decode( $aditional_req_proyects );

				foreach ($aditional_req_proyects->data as $item ) {
					array_push( $proyects, $item );
				}
			}
		}

		if( $pages_number >= 2 && is_float( $pages_number )){

			$limit = round( $pages_number, 0 , PHP_ROUND_HALF_UP) ;

			# Se hacem tamtas peticiones como $paginas existan.
			for ($i=0; $i < $limit ; $i++) { 

				// El $offset se calcula multiplicando el limite por el numero de iteracion.
				$offset = $pagination->limit * $i;

				$aditional_req_proyects = cfac_get_list_proyects( $api_key, $offset  );
				$aditional_req_proyects = json_decode( $aditional_req_proyects );

				foreach ($aditional_req_proyects->data as $item ) {
					array_push( $proyects, $item );
				}
			}
		}
	}	



	/**
	 * Buscamos en wp_postmeta un post_id que tenga el meta_key = cfact_project_version_id y el meta_value = id del proyecto.
	 * Si lo encontramos es que hay un curso importado con ese proyecto. y si no lo encontramos es que no hay un curso importado con ese proyecto.
	 */

	$proyectos = array_map(
		function ( $e ) {

			// Obtenemos el id del proyecto de CourseFactory.
			$id = $e->id;

			global $wpdb;

			$table = $wpdb->prefix . 'postmeta';

			// Construimos la peticion SQL.
			// Ejecutamos la peticion SQL.
			$post_id = (int) $wpdb->get_var(
				$wpdb->prepare(
					"SELECT post_id FROM {$table} WHERE meta_key = %s AND meta_value = %s",
					array( 'cfact_project_version_id', $id )
				)
			);

			// Si el post_id es vacio es que no hay un curso importado con ese proyecto.
			$exits = 0 === $post_id ? false : true;

			if ( $exits ) {
				$e->exist   = 'true';
				$e->post_id = $post_id;
			} else {
				$e->exist = 'false';
			}

			// Retornamos el objeto con la propiedad exist.
			return $e;
		},
		$proyects
	);



	echo '<script>req_project_list = ' . wp_json_encode( $proyects ) . ';</script>';
	echo '<div id="cfact_list"></div>';


}
