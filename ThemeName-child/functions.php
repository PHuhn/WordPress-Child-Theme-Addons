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
/*
** Add the above gc_get_season function to the environment
*/
add_action( 'wp_head', 'gc_get_season' );
/*
** ===========================================================================
** GiveCamp Animation
*/
function gc_custom_scripts() {
	wp_enqueue_script( 'gc-animation-js', get_stylesheet_directory_uri() . '/js/gc-animation.js', array( 'jquery' ), '', true );
}
/*
** Register the above custom animation scripts
*/
add_action( 'wp_enqueue_scripts', 'gc_custom_scripts' );
/*
** ===========================================================================
** Place additional shortcodes here.
*/
/*
** ===========================================================================
** [gc_counter] returns the HTML code for a GC animated counter.
** This counts from one number to another with a short interval between each
** display of a number.
** [gc_counter id="cups-1" start="1000" end="2000" inc="50" interval="80"]
** Such that:
** * id         An id for the outer tag (unique value on the page).
** * start      Starting number, default 0.
** * end        Ending number, default 100.
** * inc        Increament number, default 5.
** * interval   # of milliseconds to between each increament, default 100 or 1/10 th of a seconds.
**
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
/*
** Register [gc_counter] that returns the HTML code for a GC animated counter.
*/
add_shortcode( 'gc_counter', 'gc_counter_shortcode' );
/*
** ===========================================================================
** [gc_marquee] returns the HTML code for a GC animated marquee/ticker.
** [gc_marquee id="marq-1" text="Short marquee text!" milli-sec="16000" height="75" bg-color="black" text-color="#dddddd" text-tag="h3" margin="15" weight="bold"]
** Such that:
** * id         An id for the outer tag (unique value on the page).
** * text       Text for the marquee.
** * milli-sec  # of milliseconds to finish one full pass, default 20000 or 20 seconds.
** * height     style height applied to outer tag, default 28px.
** * bg-color   style background color applied to outer tag (system default).
** * text-color style font color applied to outer tag (system default).
** * text-tag   HTML inner tag value, default is p.
** * margin     style applied to inner tag, if 5 then would look like 'margin 5px auto;'.
** * weight     font-weight style applied to inner tag, default is none.
**
** @return string div HTML Code as follows:
** <div class="gc_marquee gc-show-once-on-scroll" id="ct-1" data-start="0" data-end="100" data-inc="5" data-interval="75">100</div>
*/
function gc_marquee_shortcode( $atts ) {
	$a = shortcode_atts( array(
	 'id' => '',
	 'text' => '',
	 'milli-sec' => 20000,
	 'height' => '',
	 'bg-color' => '',
	 'text-color' => '',
	 'text-tag' => 'p',
	 'margin' => '',
	 'weight' => ''
	), $atts );
	if( $a['text'] == '' ) {
		return '';
	}
	// Create ouptut snippets from the parameters.
	$id = '';
	if( $a['id'] != '' ) {
		$id = ' id="' . esc_attr( $a['id'] ) . '"';
	}
	$text = esc_attr( $a['text'] );
	$aria = " aria-label='" . $text . "'";
	$milli_sec = " data-millisec='" . esc_attr( $a['milli-sec'] ) . "'";
	// outer tag
	$height = '';
	if( $a['height'] != '' ) {
		$height = "height: " . esc_attr( $a['height'] ) . "px;";
	}
	$bg_color = '';
	if( $a['bg-color'] != '' ) {
		$bg_color = "background-color: " . esc_attr( $a['bg-color'] ) . ";";
	}
	$text_color = '';
	if( $a['text-color'] != '' ) {
		$text_color = "color: " . esc_attr( $a['text-color'] ) . ";";
	}
	$outer_style = '';
	if( $height != '' or $bg_color != '' or $text_color != '' ) {
		$outer_style = " style='" . $height . $bg_color . $text_color . "'";
	}
	// inner tag
	$text_tag = esc_attr( $a['text-tag'] );
	$margin = '';
	if( $a['margin'] != '' ) {
		$margin = "margin: " . esc_attr( $a['margin'] ) . "px auto;";
	}
	$weight = '';
	if( $a['weight'] != '' ) {
		$weight = "font-weight: " . esc_attr( $a['weight'] ) . ";";
	}
	$inner_style = '';
	if( $margin != '' or $weight != '' ) {
		$inner_style = " style='" . $margin . $weight . "'";
	}
	//
	$output = "<div class='gc-marquee' role='marquee'" . $id . $aria . $outer_style . ">\n";
	$output .= "	<" . $text_tag . " class='gc-scrollingtext' aria-hidden='true'" . $milli_sec . $inner_style . ">" . $text . "</" . $text_tag . ">\n</div>";
 return $output;
}
/*
** Register [gc_marquee] that returns the HTML code for a GC animated marquee.
*/
add_shortcode( 'gc_marquee', 'gc_marquee_shortcode' );
/*
** ===========================================================================
** [gc_type_writer] returns the HTML code for a GC type writer.
** [gc_type_writer id="tw-1" text="Short marquee text!" type="letter" milli-sec="100" bg-color="black" text-color="#dddddd" text-tag="h3" weight="bold"]
** Such that:
** * id         An id for the tag (id value must be unique on the page).
** * text       Text for the type writer.
** * type	    Options of letter/word, (defeault is letter)
** * milli-sec  # of milliseconds between typing, default 50 or 1/20 seconds.
** * bg-color   style background color applied to the tag (system default).
** * text-color style font color applied to the tag (system default).
** * text-tag   HTML tag value, default is p.
** * weight     font-weight style applied to inner tag, default is none.
**
** @return string of HTML Code as follows:
** <h3 class="gc-show-once-on-scroll gc-word-writer" id="tw-1" data-millisec="200" style="background-color: black;color: #dddddd;font-weight: bold;">Short marquee text!</h3>
*/
function gc_type_writer_shortcode( $atts ) {
	$a = shortcode_atts( array(
	 'id' => '',
	 'text' => '',
	 'type' => 'letter',
	 'milli-sec' => 50,
	 'bg-color' => '',
	 'text-color' => '',
	 'text-tag' => 'p',
	 'weight' => ''
	), $atts );
	if( $a['text'] == '' ) {
		return '';
	}
	// Create ouptut snippets from the parameters.
	$id = '';
	if( $a['id'] != '' ) {
		$id = ' id="' . esc_attr( $a['id'] ) . '"';
	}
	$text = esc_attr( $a['text'] );
	$class =' class="gc-show-once-on-scroll gc-type-writer"';
	if( $a['type'] == 'word' ) {
		$class = ' class="gc-show-once-on-scroll gc-word-writer"';
	}
	$milli_sec = " data-millisec='" . esc_attr( $a['milli-sec'] ) . "'";
	$bg_color = '';
	if( $a['bg-color'] != '' ) {
		$bg_color = "background-color: " . esc_attr( $a['bg-color'] ) . ";";
	}
	$text_color = '';
	if( $a['text-color'] != '' ) {
		$text_color = "color: " . esc_attr( $a['text-color'] ) . ";";
	}
	$text_tag = esc_attr( $a['text-tag'] );
	$weight = '';
	if( $a['weight'] != '' ) {
		$weight = "font-weight: " . esc_attr( $a['weight'] ) . ";";
	}
	$style = '';
	if( $bg_color != '' or $text_color != '' or $weight != '' ) {
		$style = " style='" . $height . $bg_color . $text_color .  $weight . "'";
	}
	//
	$output = "<" . $text_tag . $id . $class . $milli_sec . $style . ">" . $text . "</" . $text_tag . ">";
 return $output;
}
/*
** Register [gc_type_writer] that returns the HTML code for a GC type writer.
*/
add_shortcode( 'gc_type_writer', 'gc_type_writer_shortcode' );
/*
** ===========================================================================
** [gc_box_posts]
** * format		   rectangle or circle, the default is rectangle
** * post_type     a custom post type, default to none.
** * category_slug a post category slug or comma seperated slugs,
**                 if blank the latest posts
** * tag_slug      a post tag slug or comma seperated slugs,
**                 if blank then see category_slug
** * posts_per_row the number of posts displayed in a row,
**                 the default is 5
** * showposts     the number of posts to displayed,
**                 the default is 5
** Examples:
** [gc_box_posts format='rectangle' category_slug='meetings' tag_slug='2020' posts_per_row=3 showposts=6]
** [gc_box_posts format='circle' category_slug='hnv-blogs' showposts=5]
*/
function gc_boxposts_function( $atts ){
	extract( shortcode_atts( array(
		'format' => 'rectangle',
		'post_type' => '',
		'category_slug' => '',
		'tag_slug' => '',
		'posts_per_row' => 5,
		'show_posts' => 5
	), $atts ) );
	$post_output = '<div class="gc-row-list" role="table"><div class="gc-center" role="row">';
	wp_reset_query();
	$n = 0;
	$args = array( 'posts_per_page'=>$show_posts );
	if( $post_type != '' ) {
		// custom post_type=team
		$args = array_merge( $args, array( 'post_type' => $post_type ) );
	}
	if( $category_slug != '' ) {
		// cat=2, category_name=recovery
		$args = array_merge( $args, array( 'category_name' => $category_slug ) );
	}
	if( $tag_slug != '' ) {
		// tag_id=2, 'tag' => 'bread,baking'
		$args = array_merge( $args, array( 'tag_name' => $tag_slug ) );
	}
	$events = new WP_Query( $args );
	$num_posts = $events->post_count; 
	if ( $events->have_posts( ) ) :
		while( $events->have_posts( ) ) : $events->the_post( );
			// setup data to be displayed
			// count the # of posts
			$n++;
			// after each item place endItemDiv div
			if( $n % $posts_per_row == 0 ) {
				$endItemDiv = '<div class="gc-box-item-last"></div>';
				if( $n != $num_posts ) {
					$endItemDiv .= '</div><div class="gc-center" role="row">';
				}
			} else {
				$endItemDiv = '<div class="gc-box-item-row"></div>';
			}
			// get post url, title and image
			$postUrl = get_the_permalink();
			$postTitle = gc_word_trim( get_the_title(), 38 );
			$imgAlt = 'No image';
			if( has_post_thumbnail()) {
				$imgId = get_post_thumbnail_id();
				$imgAlt = get_post_meta( $imgId, '_wp_attachment_image_alt', TRUE );
				if( $imgAlt == '' ) {
					$imgAlt = get_the_title( $imgId );
				}
				$med_imgSrc = wp_get_attachment_image_src( $imgId, 'medium');
				$imgUrl = $med_imgSrc[0];
			} else {
				$imgUrl = get_template_directory_uri().'/images/not_found.png';
			}
			// output the HTML
			if( $format == 'circle' ) {
				$post_output .= '<div class="gc-box-item" role="cell">
					<a href="'.$postUrl.'">
						<div class="gc-circle-tag"><img src="'.$imgUrl.'" alt="'.$imgAlt.'" /></div>
						<p>'.$postTitle.'</p>
					</a>
				</div>
				'.$endItemDiv;
			} else {
				$post_output .= '<div class="gc-box-item" role="cell">
					<a href="'.$postUrl.'">
						<div class="gc-rect-image"><img src="'.$imgUrl.'" alt="'.$imgAlt.'" /></div>
						<div class="gc-rect-content"><p>'.$postTitle.'</p></div>
					</a>
				</div>
				'.$endItemDiv;
			}
 		endwhile;
	endif;
	// Cleanup
	$post_output .= '<div class="gc-box-item-last"></div></div></div>';
	wp_reset_query();
	return $post_output;
}
add_shortcode( 'gc_box_posts', 'gc_boxposts_function' );
/*
** Truncate the string on the last word before max_len.
*/
function gc_word_trim( $str, $max_len )
{
	if( strlen( $str ) > $max_len ) {
		// 4 is ' ...' characters
		$elipse = ' ...';
		$pos = strrpos( substr( $str, 0, $max_len - 3 ), ' ' );
		if( $pos == false ) {
			return( substr( $str, 0, $max_len - 4 ) . $elipse );
		} else {
			return substr( $str, 0, $pos ) . $elipse;
		}
	}
	return $str;
}
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