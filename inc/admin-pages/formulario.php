<?php
/**
 * File: formulario.php
 * Path: wp-content\plugins\coursefac-integration\inc\admin-pages\formulario.php
 * Description: Formulario de feedback.
 */

?>

<h1> <?php echo esc_html( __( 'Help us continue developing this wonderful tool', 'course_factory_integration' ) ); ?> </h1>
<h4> <?php echo esc_html( __( 'Do you have any suggestions to improve our WordPress plugin?', 'course_factory_integration' ) ); ?> </h4>


<div>
<span> <?php echo esc_html( __( 'You want us to keep you informed about the news of our plugin', 'course_factory_integration' ) ); ?> </span>
<button class="button-primary" >
	<a style="color:#fff" href="
	<?php
	bloginfo( 'url' );
	echo '?cfact_send_user_client&url_redirect=';
	bloginfo( 'url' );
	echo '/wp-admin/admin.php?page=course_factory_integration_feedback';
	?>
	"> <?php echo esc_html( __( 'Yes', 'course_factory_integration' ) ); ?> </a>
</button>
</div>

<h3>Comments</h3>

<form action="<?php bloginfo( 'url' ); ?>?cfac_send_feedback" method="post">
	<?php wp_nonce_field( 'cfac_send_feedback' ); ?>
	<div>
		<select name="cfac_send_feedbac_subjet" required >
			<option> <?php echo esc_html( __( 'Suggestion', 'course_factory_integration' ) ); ?>  </option>
			<option> <?php echo esc_html( __( 'Complaint', 'course_factory_integration' ) ); ?>  </option>
			<option> <?php echo esc_html( __( 'Praise', 'course_factory_integration' ) ); ?>  </option>
		</select>
	</div>
	<div>
		<p>Tu sugenrencia</p>
		<textarea required name="cfac_send_feedbac_msg" id="" cols="30" rows="10"></textarea>
	</div>    
	<button class="button-primary">enviar</button>
</form>
