<?php
/**
 * Path: wp-content/plugins/coursefactory-integration/inc/class/cfact-ld-section-heading.php
 * Este fichero contiene un clase que representa un encabezado de seccion de un curso de LearnDash.
 *
 * @package Course Factory Integration */

/**
 * CFact_LD_Section_Heading.
 * Esta clase representa una seccion de un curso de LearnDash.
 */
class CFact_LD_Section_Heading {

	/** La posición de la sección en el curso.
	 *
	 * @var int
	 */
	public $order;

	/** El título de la sección.
	 *
	 * @var string
	 */
	public $post_title;

	/** El identificador único de la sección.
	 *
	 * @var int
	 */
	public $ID;

	/** Indica si la sección está expandida o no.
	 *
	 * @var bool
	 */
	public $expanded;

	/** El árbol de la sección.
	 *
	 * @var array
	 */
	public $tree;

	/** El tipo de la sección.
	 *
	 * @var string
	 */
	public $type;

	/** La URL asociada a la sección.
	 *
	 * @var string
	 */
	public $url;

	/**
	 * Constructor de la clase.
	 *
	 * @param int    $order      La posición de la sección en el curso.
	 * @param string $post_title El título de la sección.
	 */
	public function __construct( $order, $post_title ) {
		$this->order      = $order;
		$this->post_title = $post_title;
		$this->ID         = wp_rand( 0, 99999 );
		$this->expanded   = false;
		$this->tree       = array();
		$this->type       = 'section-heading';
		$this->url        = '';
	}
}
