<?php
/**
 * Path: wp-content\plugins\coursefactory-integration\inc\shorcodes\course-data.php
 * Este archivo contiene el codigo del shorcode para mostrar los datos de un curso.
 *
 * @package Course Factory Integration
 */

/**
 * Callback del shortcode [coursefac_course_data]
 *
 * @param [type] $atts Atributos del shorcode.
 * @return string Un string con el html del shorcode.
 */
function coursefac_course_data( $atts ) {

	// Obtengo el id del curso.
	$atts = shortcode_atts(
		array(
			'course-id' => '',
		),
		$atts,
		'coursefac_course_data'
	);

	// Obtengo los datos del curso.
	$cfact_project_meta         = get_post_meta( $atts['course-id'], 'cfact_project_meta', true );
	$cfact_project_outcome_list = get_post_meta( $atts['course-id'], 'cfact_project_outcome_list', true );

	// Desserializo.
	$cfact_project_meta         = unserialize( $cfact_project_meta );
	$cfact_project_outcome_list = unserialize( $cfact_project_outcome_list );

	$css = '.coursefac_course_data ol{
        list-style-type: upper-latin;

    }
    .coursefac_course_data ol ol{
        list-style-type: decimal;
    ';

	$html = '<style>' . $css . '</style>';

	$html .= "<div class='coursefac_course_data'>";

	// MetaData del curso.
	$goal_annotation  = $cfact_project_meta->goal_annotation;
	$about_annotation = $cfact_project_meta->about_annotation;
	$knowledge_level  = $cfact_project_meta->knowledge_level;
	$practical_level  = $cfact_project_meta->practical_level;
	$duration         = $cfact_project_meta->duration;

	$html .= '<p><b>' . __( 'Goal Annotation', 'coursefactory-integration' ) . ': </b>';
	$html .= $goal_annotation . '</p>';

	$html .= '<p><b>' . __( 'About Annotation', 'coursefactory-integration' ) . ': </b>';
	$html .= $about_annotation . '</p>';

	$html .= '<p><b>' . __( 'Knowledge Level', 'coursefactory-integration' ) . ': </b>';
	$html .= $knowledge_level . '</p>';

	$html .= '<p><b>' . __( 'Practical Level', 'coursefactory-integration' ) . ': </b>';
	$html .= $practical_level . '</p>';

	$html .= '<p><b>' . __( 'Duration', 'coursefactory-integration' ) . ': </b>';
	$html .= $duration . 'weeks</p>';

	// Objetivos de aprendisaje.
	$html .= '<h4>' . __( 'Learning Outcomes', 'coursefactory-integration' ) . '</h4>';
	$html .= '<ol>';

	foreach ( $cfact_project_outcome_list as $outcome ) {

		$html .= '<li> <p>' . $outcome->name . '</p>';

		$html .= '<ol>';

		$sub_outcome_list = $outcome->sub_outcome_list;

		foreach ( $sub_outcome_list as $sub_outcome ) {
			$html .= '<li> <p>' . $sub_outcome->name . '</p> </li>';
		}

		$html .= '</ol>';
	}

	$html .= '</ol>';
	$html .= '</div>';

	return $html;
}

// Registro shorcode.
add_shortcode( 'coursefac_course_data', 'coursefac_course_data' );
