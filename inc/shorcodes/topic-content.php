<?php
// ... rest of the code ...

wp_enqueue_script( 'topic-content-script', plugins_url( 'topic-content.js', __FILE__ ), array( 'jquery'), true );

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
