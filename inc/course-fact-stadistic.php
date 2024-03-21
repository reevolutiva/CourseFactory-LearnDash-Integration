<?php
/**
 * Path: wp-content/plugins/coursefactory-integration/inc/course-fact-stadistic.php
 * Aqui se declara la function encargada de enviar las estadisticas del plugin.
 *
 * @package Course Factory Integration */

/**
 * Esta funcion envia al servidor de estadisticas de Reevolutiva los datos de la activacion del plugin.
 *
 * @param string $evento El evento que se quiere enviar ( activation, imported, set-apiKey, diactivation ) .
 * @return void
 */
function cfact_integration_send_stadistic( $evento ) {

	$ip      = '';
	$dominio = '';

	// Obtenemos la IP del usuario.
	if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {

		// Sanitizamos $ip.
		$ip = sanitize_url( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );

	}

	// Obtenemos el dominio del sitio.
	if ( isset( $_SERVER['HTTP_HOST'] ) ) {

		// Sanitizamos $dominio.
		$dominio = sanitize_url( wp_unslash( $_SERVER['HTTP_HOST'] ) );
	}

	// Obtenemos el timestamp actual en este formato 12-05-2014.
	$timestamp = gmdate( 'd-m-Y' );

	$body = array(
		'regist' => array(
			'IP'        => $ip,
			'timestamp' => $timestamp,
			'dominio'   => $dominio,
			'evento'    => $evento,
		),
	);

	if ( 'activation' === $evento || 'imported' === $evento || 'set-apiKey' === $evento || 'diactivation' === $evento ) {
		wp_remote_post(
			'https://coursefactory.reevolutiva.cl/wp-json/reev/v1/stadistic',
			array(
				'body' => wp_json_encode( $body ),
			)
		);
	}
}
