<?php
/**
 * Campus Page Template Wrapper
 *
 * Renders the page-campus block template within full WordPress head and footer context.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$campus_id = Kalalayaa_Context::get_current_campus_id();
if ( ! $campus_id || 'all' === $campus_id ) {
	$campus_id = 'kk-nagar';
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$template_file = get_theme_file_path( 'templates/page-campus.html' );
if ( file_exists( $template_file ) ) {
	echo do_blocks( file_get_contents( $template_file ) );
}
?>

<?php wp_footer(); ?>
</body>
</html>
