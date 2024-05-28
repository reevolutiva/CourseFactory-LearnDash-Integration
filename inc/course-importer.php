/**
 * Esta funcion se encarga de crear un curso en LearnDash. Hace una insercion en
 * la tabla wp_posts con el post_type sfwd-courses y crea un custom field con el
 * id del proyecto en CourseFactory. El post-content tendra un custom field con el
 * id del proyecto en CourseFactory.
 * 
 * @param array $course_importer_data Datos del curso
 * @return string
 */
