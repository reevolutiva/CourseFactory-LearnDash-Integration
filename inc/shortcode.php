<?php
/**
 * Path: wp-content/plugins/coursefactory-integration/inc/shortcode.php
 * Este archivo contiene el codigo de los shorcodes que include el plugin de WordPress.
 * Tambien hace la llamada a otros archivos que contienen codigo de shorcodes.
 *
 * @package Course Factory Integration. */

/**
 * Esta funcion contiene el codigo del shorcode [vite_front_shorcode]
 * Este shorcode se encarga de renderizar el front de la aplicacion.
 *
 * @param [type] $atts Atributos del shorcode.
 * @return string $shorcode  */
function vite_front_shorcode_callback( $atts ) {
	$atts = shortcode_atts(
		array(
			'filter' => 'employe',
		),
		$atts
	);

	$shorcode = "<div id='my-front'></div>";

	return $shorcode;
}

add_shortcode( 'vite_front_shorcode', 'vite_front_shorcode_callback' );

require 'shorcodes/course-data.php';

require 'shorcodes/topic-content.php';
