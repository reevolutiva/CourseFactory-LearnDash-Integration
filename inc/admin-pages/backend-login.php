<?php
/**
 *  Path: wp-content/plugins/coursefactory-integration/inc/backend-login.php.
 *  Este archivo contiene el codigo de la pagina de login en la admistracion de coursefactory.
 *
 * @package Course Factory Integration
 */

if( ! $api_key ){
    echo '<div id="cfact_login_popup"></div>';
}


if ( isset( $_GET['set-api_key'] ) && isset( $_GET['api-key'] ) && ! empty( $_GET['api-key'] ) ) {

		
    $api_key_data    = sanitize_text_field( wp_unslash( $_GET['api-key'] ) );
    $keepme_informed = isset( $_GET['keepme-informed'] ) ? sanitize_text_field( wp_unslash( $_GET['keepme-informed'] ) ) : 'false';

    if ( update_option( 'cfact_keepme_informed', $keepme_informed ) ) {
        add_option( 'cfact_keepme_informed', $keepme_informed );
    }

    cfact_ld_api_key_mannger( 'add', $api_key_data );

    cfact_integration_send_stadistic( 'set-apikey' );

    $url  = 'https://coursefactory.reevolutiva.cl/?fluentcrm=1&route=contact&hash=34cf89d2-797e-4174-ba3d-411b75ff24e6';
    $args = cfact_get_client_data();

    if($keepme_informed){
        $request = wp_remote_post( $url, $args );
        $body    = wp_remote_retrieve_body( $request );
        $body    = json_decode( $body );

        if( $body->success ): 
            
            ?>
            <script>
                location.href = `${location.origin}/wp-admin/admin.php?page=course_factory_integration`
            </script>
            <?php

        endif;        
    }
    

}

echo '<div id="cfact_login"></div>';