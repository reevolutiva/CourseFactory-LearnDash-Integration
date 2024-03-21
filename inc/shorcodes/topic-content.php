<?php
/**
 * Path: wp-content\plugins\coursefactory-integration\inc\shorcodes\topic-content.php
 * Este archivo contiene el codigo del shorcode para mostrar una caja de comentarios dentro del cpt-topic.
 *
 * @package Course Factory Integration */

/**
 * Callback del shortcode [coursefac_topic_content]
 *
 * @param [type] $atts Atributos del shorcode.
 * @return string [coursefac_topic_content]
 */
function coursefac_topic_content( $atts ) {

	// Obtengo el id del curso.
	$atts = shortcode_atts(
		array(
			'topic' => '',
		),
		$atts,
		'coursefac_topic_content'
	);

	$html  = '<div>';
	$html .= '<h3>' . $atts['topic'] . '</h3>';
	$html .= "<div id='topic_comment_box'></div>";
	$html .= '</div>';

	return $html;
}

// Registro shorcode.
add_shortcode( 'coursefac_topic_content', 'coursefac_topic_content' );

add_action( 'wp_footer', 'coursefac_topic_content_js' );

/**
 * Funcion que se encarga de renderizar el componente de comentarios en el footer.
 *
 * @return void
 */
function coursefac_topic_content_js() {
	?>

	<script>

		if(location.href.includes("topics")){
			const topic_comment_box = document.querySelector('#topic_comment_box');
			if(topic_comment_box){
				topic_comment_box.append(document.querySelector('.wp-block-comments'));
			}
			
		}    

	</script>

	<?php
}
