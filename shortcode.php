<?php 

function slider_func( $atts ){
	$a = shortcode_atts( array(
		'title' => 'something'
	), $atts );

	return "here is the title: {$a['title']}";
}
add_shortcode( 'slider', 'slider_func' );

?>
