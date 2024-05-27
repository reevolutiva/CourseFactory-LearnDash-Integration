<?php
/**
 *  Path: wp-content/plugins/coursefactory-integration/inc/backend.php.
 *  Este archivo contiene el codigo de la pagina de admistracion de coursefactory.
 *
 * @package Course Factory Integration
 */

$cookie = cfact_get_wp_cookie();


$api_key = cfact_ld_api_key_mannger( 'get' );

/**
 * Esta funcion retorna un array con los siguientes datos del WordPress del usuario: 'name', 'description', 'url', 'admin_email', 'language
 *
 * @return string
 */
function bloginfo_array() {
	$fields = array( 'name', 'description', 'url', 'admin_email', 'language' );
	$data   = array();
	foreach ( $fields as $field ) {
		$data[ $field ] = get_bloginfo( $field );
	}
	return $data;
}

$backend_i18n = cfact_backend_i18n();

?>
<script>
// Aquí entrego las varaiabels desde PHP hacia REACT JS.
const bakendi18n = <?php echo wp_json_encode( $backend_i18n ); ?>;
let req_project_list = false;
const cfact_blog_info = <?php echo wp_json_encode( bloginfo_array() ); ?>;
const cfact_current_user = <?php echo wp_json_encode( wp_get_current_user() ); ?>; 
const CFACT_PLUGIN_URL_COURSE_LOG ="<?php echo esc_url( plugins_url( 'coursefactory-integration/course-log.json' ) ); ?>"; 
let cfact_learndash_integration_apiKey = "<?php echo esc_html( $api_key ); ?>";
const wpApiCookie = "<?php echo esc_html( $cookie ); ?>";

</script>
<?php

// Seccion donde se elimina el APIKEY de course factory.
if ( isset( $_GET['delete-api_key'] ) ) {

	cfact_ld_api_key_mannger( 'delete' );
	?>
	<script>
		location.href = `${location.origin}/wp-admin/admin.php?page=course_factory_integration`;
	</script>
	<?php
	die();

}

// Seccion de listing.
if ( $api_key && ! isset( $_GET['cfact_view_config'] ) ) {
	require 'backend-listing.php';
}

// Seccion para logearse en course-factory.
if ( ! $api_key || isset( $_GET['cfact_view_config'] ) ) {
	require 'backend-login.php';
}


