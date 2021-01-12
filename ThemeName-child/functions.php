<?php
/*
** Twenty Twenty functions and definitions
*/
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() .
		'/style.css' );
}
/*
** ===========================================================================
** From: https://css-tricks.com/snippets/php/change-graphics-based-on-season/
**
** returns a string value of:
**  spring, summer, autumn or winter
** example, say in twenty-twenty theme copy header.php into
** child theme and change the following from:
**  <body <?php body_class(); ?>>
** to:
**  <body <?php body_class(gc_get_season( )); ?>>
*/
function gc_get_season( ) {
	/*
	** What is today's date - number
	*/
	$day = date("z");
	/*
	** Days of spring
	*/
	$spring_starts = date("z", strtotime("March 21"));
	$spring_ends   = date("z", strtotime("June 20"));
	/*
	** Days of summer
	*/
	$summer_starts = date("z", strtotime("June 21"));
	$summer_ends   = date("z", strtotime("September 22"));
	/*
	** Days of autumn
	*/
	$autumn_starts = date("z", strtotime("September 23"));
	$autumn_ends   = date("z", strtotime("December 20"));
	/*
	** If $day is between the days of spring, summer, autumn, and winter
	*/
	if( $day >= $spring_starts && $day <= $spring_ends ) :
		$season = "spring";
	elseif( $day >= $summer_starts && $day <= $summer_ends ) :
		$season = "summer";
	elseif( $day >= $autumn_starts && $day <= $autumn_ends ) :
		$season = "autumn";
	else :
		$season = "winter";
	endif;
	//
	return $season;
}
/* Register the above gc_get_season function for header */
add_action( 'wp_head', 'gc_get_season' );
/*
** ===========================================================================
** GiveCamp Animation
*/
function gc_custom_scripts() {
	wp_enqueue_script( 'gc-animation-js', get_stylesheet_directory_uri() . '/js/gc-animation.js', array( 'jquery' ), '', true );
}
/* Register the above custom animation scripts */
add_action( 'wp_enqueue_scripts', 'gc_custom_scripts' );
/*
** ===========================================================================
** Place additional shortcodes here.
**
** ===========================================================================
** [gc_counter] returns the HTML code for a GC animated counter.
** @return string div HTML Code as follows:
** <div class="gc_counter gc-show-once-on-scroll" id="ct-1" data-start="0" data-end="100" data-inc="5" data-interval="75">100</div>
*/
function gc_counter_shortcode( $atts ) {
	$a = shortcode_atts( array(
	 'id' => '',
	 'start' => 0,
	 'end' => 100,
	 'inc' => 5,
	 'interval' => 100
	), $atts );
	$id = '';
        if( $a['id'] != '' ) {
            $id = ' id="' . esc_attr( $a['id'] ) . '"';
        }
	$attrib = ' data-start="' . esc_attr( $a['start'] ) . '" data-end="' . esc_attr( $a['end'] ) . '" data-inc="' . esc_attr( $a['inc'] ) . '" data-interval="' . esc_attr( $a['interval'] ) . '"';
	$output = '<div class="gc-counter"' . $id . $attrib . '>' . esc_attr( $a['end'] ) . '</div>';
 return $output;
}
/* Register the above function as [gc_counter] shortcode */
add_shortcode( 'gc_counter', 'gc_counter_shortcode' );
/*
** ===========================================================================
** [gc_year] returns text of the current year.
*/
function gc_year_shortcode() {
	$year = date('Y');
	return $year;
}
/* Register the above function as [gc_year] shortcode */
add_shortcode('gc_year', 'gc_year_shortcode');
?>