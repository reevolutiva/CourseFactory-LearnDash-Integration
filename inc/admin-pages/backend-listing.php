<?php
/**
 *  Path: wp-content/plugins/coursefactory-integration/inc/backend-listing.php.
 *  Este archivo contiene el codigo de la pagina de listing en la admistracion de coursefactory.
 *
 * @package Course Factory Integration
 */

 // Listamos todos los proyectos.

 $req_proyects = cfac_get_list_proyects( $api_key );
 $req_proyects = json_decode( $req_proyects );

 $proyectos = array();

 // Obtenemos el id de cada proyecto y mediante ese ID Listamos todas las verciones de ese proyecto.
 if ( $req_proyects->data ) {

     $proyects = $req_proyects->data;



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