<?php
/**
 *  Path: wp-content/plugins/coursefactory-integration/inc/backend-login.php.
 *  Este archivo contiene el codigo de la pagina de login en la admistracion de coursefactory.
 *
 * @package Course Factory Integration
 */

if ( ! defined( 'ABSPATH' ) ) exit; 

if ( ! $api_key ) {
	echo '<div id="cfact_login_popup"></div>';
}

echo '<div id="cfact_login"></div>';
