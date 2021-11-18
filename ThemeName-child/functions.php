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
		$style = " style='" . $bg_color . $text_color .  $weight . "'";
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
** * orderby       order by option, the default is 'date'
** * order         order direction option (DESC/ASC), the default is 'DESC'
** Examples:
** [gc_box_posts format='rectangle' category_slug='meetings' tag_slug='2020' posts_per_row=3 showposts=6]
** [gc_box_posts format='circle' category_slug='hnv-blogs' showposts=5]
*/
function gc_boxposts_shortcode( $atts ){
	extract( shortcode_atts( array(
		'format' => 'rectangle',
		'post_type' => '',
		'category_slug' => '',
		'tag_slug' => '',
		'posts_per_row' => 5,
		'show_posts' => 5,
		'orderby' => 'date',
		'order'   => 'DESC'
	), $atts ) );
	$post_output = '<div class="gc-row-list" role="table"><div class="gc-center" role="row">';
	wp_reset_query();
	$n = 0;
	$args = array(
			'posts_per_page' => esc_attr( $show_posts ),
			'orderby' => esc_attr( $orderby ),
			'order' => esc_attr( $order ),
		);
	if( $post_type != '' ) {
		// custom post_type=team
		$args = array_merge( $args, array( 'post_type' => esc_attr( $post_type ) ) );
	}
	if( $category_slug != '' ) {
		// cat=2, category_name=recovery
		$args = array_merge( $args, array( 'category_name' => esc_attr( $category_slug ) ) );
	}
	if( $tag_slug != '' ) {
		// tag_id=2, 'tag' => 'bread,baking'
		$args = array_merge( $args, array( 'tag_name' => esc_attr( $tag_slug ) ) );
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
			$imgAlt = 'Image unknown';
			if( has_post_thumbnail()) {
				$imgId = get_post_thumbnail_id();
				$imgAlt = get_post_meta( $imgId, '_wp_attachment_image_alt', TRUE );
				if( $imgAlt == '' ) {
					$imgAlt = get_the_title( $imgId );
				}
				$med_imgSrc = wp_get_attachment_image_src( $imgId, 'medium');
				$imgUrl = $med_imgSrc[0];
			} else {
				$imgUrl = get_stylesheet_directory_uri().'/images/not_found.png';
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
add_shortcode( 'gc_box_posts', 'gc_boxposts_shortcode' );
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
** [gc_slider] returns the HTML code for a GC animate a slider.  [gc_slider]
** is a two part shortcode as follows [gc_slider]content[/gc_slider].  The
** content is imbedded and should be another list of shortcodes.  Also see the
** [gc_image_item] shortcode.
** Note:
**  That [gc_slider] will remove <br /> from the output.  If you want to
**  use a br in the imbedded content, try using a <br/> instead.
** Example:
**  [gc_slider type='image' aria_label='Beautiful sunrises on Lake Huron' milli_sec='5500' bg_color='#dddddd' text_color='brown']Your content here...[/gc_slider]
**
** Such that:
** * id         An id for the outer tag (unique value on the page).
** * type       Type/role of slider, option is img/list, default is none this is required,
** * aria_label Accessibility value for the slider, default is 'Marketing images'.
** * milli_sec  # of milliseconds to finish one full pass, default 5000 or 5 seconds.
** * header     Header for the slider, default is none,
** * footer     Footer for the slider, default is none,
** * bg_color   style background color applied to outer tag, default is none.
** * text_color style font color applied to outer tag, default is none.
** * border_color  style for border, if value then 1px solid border, (default is none)
**
** @return string div HTML Code as follows (the gc-slider-item div's are from
**   the [gc_image_item] shortcode):
**
** <div  id="is-1" class='gc-slider' role='slider' aria-label="Beautiful sunrises on Lake Huron" style='color: brown;background-color: #dddddd;' onmouseover='gc_slider_hover( this )' onmouseout='gc_slider_hover_leave( this )' data-millisec='5500'>
**     <div aria-hidden='true' class='gc-slider-header'>Sunrises</div>
**     <div aria-hidden='true' class='gc-slider-items'>
**
** <div  id="ii-1" class='gc-slider-item' role='img' style='color: black;background-color: #eeeeee;'>
**     <div class='gc-fadeInRightBig gc-img-slider-title'>
**         <p style='font-size: 60px;'>Beautiful sunrise</p>
**     </div>
**     <div class='gc-fadeInRight gc-img-slider-image'>
**         <img src='http://localhost:9137/wp-content/uploads/2021/10/img_2768_2400-1024x768.jpg' alt='Sunrise on Lake Huron'/>
**     </div>
** </div>
** <div  id="ii-2" class='gc-slider-item' role='img' style='color: brown;background-color: #eeeeee;'>
**     <div class='gc-fadeInLeft gc-img-slider-image'>
**         <img src='http://localhost:9137/wp-content/uploads/2021/10/img_2748_2400-1024x768.jpg' alt='Sunrise on Lake Huron'/>
**     </div>
**     <div class='gc-fadeInLeftBig gc-img-slider-title'>
**         <p style='font-size: 60px;'>Another sunrise</p>
**     </div>
** </div>
**
**     </div>
**     <div aria-hidden='true' class='gc-slider-footer'></div>
**     <div aria-hidden='true' class='gc-slider-counter'></div>
** </div>
*/
function gc_slider_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id' => '',
		'type' => '',
		'aria_label'	=> 'Marketing images',
		'milli_sec'		=> 5000,
		'header'		=> '',
		'footer'		=> '',
		'bg_color'		=> '',
		'text_color'	=> '',
		'border_color'	=> '',
	), $atts ) );
	// error_log( print_r( $a, 2) );
	return gc_slider_function( $id, $type, $aria_label, $milli_sec, $header, $footer, $bg_color, $text_color, $border_color, $content );
}
//
function gc_slider_function( $id, $type, $aria_label, $milli_sec, $header, $footer, $bg_color, $text_color, $border_color, $content ) {
	if( $type == '' ) {
		return '';
	}
	// Create ouptut snippets from the parameters.
	$ident = '';
	if( $id != '' ) {
		$ident = ' id="' . esc_attr( $id ) . '"';
	}
	$header_title = '';
	if( $header != '' ) {
		$header_title = esc_attr( $header );
	}
	$footer_content = '';
	if( $footer != '' ) {
		$footer_content = esc_attr( $footer );
	}
	$role = ' role="' . esc_attr( $type ) . '"';
	$hidden = " aria-hidden='true'";
	if( $type == "list" ) {
		$hidden = " aria-hidden='false'";
	}
	$header_div = "	<div" . $hidden . " class='gc-slider-header'>" . $header_title . "</div>\n";
	$footer_div = "	<div" . $hidden . " class='gc-slider-footer'>" . $footer_content . "</div>\n";
	$counter_div = "	<div" . $hidden . " class='gc-slider-counter'></div>\n";
	$hover = " onmouseover='gc_slider_hover( this )' onmouseout='gc_slider_hover_leave( this )'";
	$aria = ' aria-label="' . esc_attr( $aria_label ) . '"';
	$milli_data = " data-millisec='" . esc_attr( $milli_sec ) . "'";
	$background_color = '';
	if( $bg_color != '' ) {
		$background_color = "background-color: " . esc_attr( $bg_color ) . ";";
	}
	$color = '';
	if( $text_color != '' ) {
		$color = "color: " . esc_attr( $text_color ) . ";";
	}
	$border = '';
	if(  $border_color != '' ) {
		$border = "border: 1px solid " . esc_attr( $border_color ) . ";";
	}
	$style = '';
	if( $background_color != '' or $color != '' or $border != '' ) {
		$style = " style='" . $color . $background_color . $border . "'";
	}
	$stripped_content = gc_fix_do_shortcode( $content );
	$output = "<div" . $ident . " class='gc-slider'" . $style . $hover . $milli_data . ">\n" .
		$header_div .
		"	<div class='gc-slider-items' " . $role . $aria . $hidden . " aria-roledescription='carousel'>\n" .
		$stripped_content .
		"\n	</div>\n" .
		$footer_div .
		$counter_div .
		"</div>";
	return $output;
}
/*
** Register [gc_slider] that returns the HTML code for a GC slider wrapper.
*/
add_shortcode( 'gc_slider', 'gc_slider_shortcode' );
/*
** [gc_image_item] is used with the [gc_slider] shortcode.  This displays an
** image on one half of the screen and the title on the other half.  Both the
** image and the title slide in on the 'image_side'.  The animation is done
** by CSS @keyframes.
** Note:
**  That [gc_slider] will remove <br /> from the output.  If you want to
**  use a br in the imbedded content, try using a <br/> instead.
** Example:
**  [gc_image_item id='ii-1' image_id='22' image_title='Beautiful sunrise' image_side='right' bg_color='#dddddd' text_color='brown']
** Such that:
** * id              An id for the outer tag (unique value on the page).
** * image_id        Id for an image, use either image_id or image_url to get image (default is none),
** * image_title     Display message (title) beside the image, default is none, this is required,
** * title_font_size Font size of the image_title value, default is '60px', this is required.
** * image_side      Which side the image is on, options right/left, default is right, this is required.
** * image_url       Use either image_id or image_url to define which image, default is none,
** * image_alt       If used image_url, then define the alt image tag,
**                   if used image_id it can get the value from the image,
**                   default is none,
** * bg_color        style background color applied to outer tag, default is none.
** * text_color      style font color applied to outer tag, default is none.
**
** @return string div HTML Code as follows:
** <div  id="ii-1" class='gc-slider-item' role='img' style='color: black;background-color: #eeeeee;'>
**     <div class='gc-fadeInRightBig gc-img-slider-title'>
**         <p style='font-size: 60px;'>Beautiful sunrise</p>
**     </div>
**     <div class='gc-fadeInRight gc-img-slider-image'>
**         <img src='http://localhost:9137/wp-content/uploads/2021/10/img_2768_2400-1024x768.jpg' alt='Sunrise on Lake Huron'/>
**     </div>
** </div>
*/
function gc_image_item_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'id' => '',
		'image_id' => '',
		'image_title' => '',
		'title_font_size' => '60px',
		'image_side' => 'right',
		'image_url' => '',
		'image_alt' => '',
		'bg_color' => '',
		'text_color' => '',
	), $atts ) );
	//
	if( $image_id == '' and image_url == '' ) {
		return '';
	}
	if( $image_title == '' or $title_font_size == '' or $image_side == '' ) {
		return '';
	}
	// Create ouptut snippets from the parameters.
	if( strtolower($image_side) == 'left' ) {
		$img_side = 'Left';
		$tit_side = 'Left';
	} else {
		$img_side = 'Right';
		$tit_side = 'Right';
	}
	// Protect $image_url and $image_alt from update
	$image_url = esc_attr( $image_url );
	if( $image_id != '' ) {
		$img_id = absint( $image_id );
		$alt = get_post_meta( $img_id, '_wp_attachment_image_alt', TRUE );
		if( $alt != '' ) {
			$image_alt = $alt;
		}
		$lrg_img = wp_get_attachment_image_src( $img_id, 'large');
		if( $lrg_img ) {
			if( count( $lrg_img ) > 0 ) {
				$image_url = $lrg_img[0];
			}
		}
	}
	if( $image_url == '' ) {
		$image_url = get_stylesheet_directory_uri().'/images/not_found_land.png';
	}
	if( $image_alt == '' ) {
		$image_alt = 'Image unknown';
	}
	//
	$tit_tag = "	<div class='gc-fadeIn" . $tit_side . "Big gc-is-visible gc-img-slider-title'>\n" .
		"		<p style='font-size: " . esc_attr( $title_font_size ) . ";'>" . esc_attr( $image_title ) . "</p>\n" .
		"	</div>\n";
	$img_tag = "	<div class='gc-fadeIn" . $img_side . " gc-is-visible gc-img-slider-image'>\n" .
		"		<img src='" . $image_url . "' alt='" . $image_alt . "'/>\n" .
		"	</div>\n";
	if( $image_side == 'left' ) {
		$output = gc_slider_item_function( $id, 'img', '', $bg_color, $text_color, '', $img_tag . $tit_tag );
	} else {
		$output = gc_slider_item_function( $id, 'img', '', $bg_color, $text_color, '', $tit_tag . $img_tag );
	}
	return $output;
}
/*
** Register [gc_image_item] that returns the HTML code for a GC slider image item.
*/
add_shortcode( 'gc_image_item', 'gc_image_item_shortcode' );
/*
** [gc_slider_item] is used with the [gc_slider] shortcode.  This wrappers
** content.  [gc_slider_item] is a two part shortcode as follows:
** [gc_slider_item]content[/gc_slider_item]
** The animation is done by CSS @keyframes.
** Note:
**  That [gc_slider_item] will remove <br /> from the output.  If you want to
**  use a br in the imbedded content, try using a <br/> instead.
** Example:
**  [gc_slider_item id='si-1' animate='fade-right' bg_color='#dddddd' text_color='brown']
**   <div style="display: table-cell; vertical-align: middle; heigth: 100px;">Hello World</div>
**  [/gc_slider_item]
** Such that:
** * id            An id for the outer tag (unique value on the page).
** * type          Type/role of slider item, option is img/list (default is none),
** * animate       Options for fade-in animation (default is none),
**                 * fade-left
**                 * fade-big-left
**                 * fade-right
**                 * fade-big-right
**                 * fade-in
**                 * fade-up
**                 * fade-down
** * bg_color      style background color applied to outer tag, default is none.
** * text_color    style font color applied to outer tag, default is none.
** * border_color  style for border, if value then 1px solid border, (default is none)
**
** @return string div HTML Code as follows:
**  <div id="si-1" class="gc-slider-item gc-fadeInLeft gc-is-visible" aria-roledescription="slide" role="article" style="color: brown; background-color: #eeeeee; display: table;">
**   <div style="display: table-cell; vertical-align: middle; heigth: 100px;">Hello World</div>
**  </div>
*/
function gc_slider_item_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id' => '',
		'type' => '',
		'animate' => '',
		'bg_color' => '',
		'text_color' => '',
		'border_color' => '',
	), $atts ) );
	return gc_slider_item_function( $id, $type, $animate, $bg_color, $text_color, $border_color, $content );
}
//
function gc_slider_item_function( $id, $type, $animate, $bg_color, $text_color, $border_color, $content = null ) {
	// Create ouptut snippets from the parameters.
	$ident = '';
	if( $id != '' ) {
		$ident = ' id="' . esc_attr( $id ) . '"';
	}
	$role = '';
	if( $type != '' ) {
		$role = ' role="' . esc_attr( $type ) . '"';
	}
	$animateClass = gc_animation( $animate );
	$background_color = '';
	if( $bg_color != '' ) {
		$background_color = "background-color: " . esc_attr( $bg_color ) . ";";
	}
	$color = '';
	if( $text_color != '' ) {
		$color = "color: " . esc_attr( $text_color ) . ";";
	}
	$border = '';
	if(  $border_color != '' ) {
		$border = "border: 1px solid " . esc_attr( $border_color ) . ";";
	}
	$style = '';
	if( $background_color != '' or $color != '' or $border != '' ) {
		$style = " style='" . $border . $color . $background_color . "'";
	}
	$stripped_content = gc_fix_do_shortcode( $content );
	$item_div = "	<div " .$ident . " class='gc-slider-item" . $animateClass . "' aria-roledescription='slide'" . $role . $style . ">\n";
	return $item_div . "\n" . $stripped_content . "\n" . "	</div>\n";
}
/*
** Return $content with do_shortcode, but fixed as good as possible.
** The content will have <br /> removed from the output.  If you want to
** use a br in the imbedded content, try using a <br/> instead.
*/
function gc_fix_do_shortcode( $content ) {
	remove_filter( 'the_content', 'wpautop' );
	// sometimes do_shortcode still produces </p>content<p>
	if( substr( $content, 0, 4 ) == "</p>") {
		$len = strlen( $content );
		if( substr( $content, $len - 3, 3 ) == "<p>") {
			$content = substr( $content, 4, $len - 7 );
		}
	}
	// remove br from output
	$stripped_content = do_shortcode( str_replace(array('<br />' ), '', $content ) );
	add_filter( 'the_content', 'wpautop' );
	// error_log( $stripped_content );
	return $stripped_content;
}
/*
** Return an animation class
*/
function gc_animation( $animate ) {
	$animateClass = "";
	switch (strtolower($animate)) {
		case 'fade-left':
			$animateClass = " gc-fadeInLeft gc-is-visible";
			break;
		case 'fade-big-left':
			$animateClass = " gc-fadeInLeftBig gc-is-visible";
			break;
		case 'fade-right':
			$animateClass = " gc-fadeInRight gc-is-visible";
			break;
		case 'fade-big-right':
			$animateClass = " gc-fadeInRightBig gc-is-visible";
			break;
		case 'fade-in':
			$animateClass = " gc-fade-in gc-is-visible";
			break;
		case 'fade-up':
			$animateClass = " gc-fade-up gc-is-visible";
			break;
		case 'fade-down':
			$animateClass = " gc-fade-down gc-is-visible";
			break;
		default:
			$animateClass = "";
	}
	return $animateClass;
}
/*
** Register [gc_slider_item] that returns the HTML code for a GC slider wrapper.
*/
add_shortcode( 'gc_slider_item', 'gc_slider_item_shortcode' );
/*
** ===========================================================================
** [gc_posts_slider] returns the HTML code for a GC animate a slider.  The
** posts displayed can be a category, tag or custom post type.
** Example:
**  [gc_posts_slider id='ps-1' aria_label='Latest Meetings' category_slug='meetings' tag_slug='2020' show_posts=5 border_color='red']
**
** Such that:
** * id            An id for the outer tag (unique value on the page).
** * type          Type/role of slider, option is img/list (default is none this is required),
** * aria_label    Accessibility value for the slider (default is none),
** * milli_sec     # of milliseconds to finish one full pass (default 6000 or 6 seconds),
** * header        Header for the slider (default is none),
** * footer        Footer for the slider (default is none),
** * bg_color      style background color applied to outer tag (default is none),
** * text_color    style font color applied to outer tag (default is none),
** * border_color  style for border, if value then 1px solid border (default is none),
** * animate       Options for fade animation (default is fade-right),
**                 * fade-left
**                 * fade-big-left
**                 * fade-right
**                 * fade-big-right
**                 * fade-in
**                 * fade-up
**                 * fade-down
** * post_type     a custom post type (default to none),
** * category_slug a post category slug or comma seperated slugs (default is none),
**                 if blank the latest posts
** * tag_slug      a post tag slug or comma seperated slugs (default is none),
**                 if blank then see category_slug
** * show_posts    the number of posts to displayed (the default is 5),
** * show_date     include the date, option true/false (default is true),
** * show_author   include the author, option true/false (default is true),
** * orderby       order by option (default is 'date'),
** * order         order direction option DESC/ASC (default is 'DESC')
*/
function gc_posts_slider_shortcode( $atts ){
	extract( shortcode_atts( array(
		'id'			=> '',
		'type'			=> 'article',
		'aria_label'	=> '',
		'milli_sec'		=> 6000,
		'header'		=> '',
		'footer'		=> '',
		'bg_color'		=> '',
		'text_color'	=> '',
		'border_color'	=> '',
		//
		'animate'	=> 'fade-right',
		//
		'post_type'	=> '',
		'category_slug'	=> '',
		'tag_slug'	=> '',
		'show_posts'	=> 5,
		'show_date'	=> 'true',
		'show_author'	=> 'true',	
		'orderby'	=> 'date',
		'order'		=> 'DESC',
	), $atts ) );
	//
	$post_output = '<div class="gc-row-list" role="table"><div class="gc-center" role="row">';
	wp_reset_query();
	$n = 0;
	$args = array(
			'posts_per_page' => esc_attr( $show_posts ),
			'orderby' => esc_attr( $orderby ),
			'order' => esc_attr( $order ),
		);
	if( $post_type != '' ) {
		// custom post_type=team
		$args = array_merge( $args, array( 'post_type' => esc_attr( $post_type ) ) );
	}
	if( $category_slug != '' ) {
		// cat=2, category_name=recovery
		$args = array_merge( $args, array( 'category_name' => esc_attr( $category_slug ) ) );
	}
	if( $tag_slug != '' ) {
		// tag_id=2, 'tag' => 'bread,baking'
		$args = array_merge( $args, array( 'tag_name' => esc_attr( $tag_slug ) ) );
	}
	$events = new WP_Query( $args );
	$num_posts = $events->post_count;
	$posts_output = '';
	if ( $events->have_posts( ) ) :
		while( $events->have_posts( ) ) : $events->the_post( );
			//
			// get post url, title and image
			$postUrl = get_the_permalink();
			$postTitle = get_the_title( );
			$imgAlt = 'Image unknown';
			$imgTag = '';
			if( has_post_thumbnail()) {
				$imgId = get_post_thumbnail_id();
				$imgAlt = get_post_meta( $imgId, '_wp_attachment_image_alt', TRUE );
				if( $imgAlt == '' ) {
					$imgAlt = get_the_title( $imgId );
				}
				$med_imgSrc = wp_get_attachment_image_src( $imgId, 'thumbnail');
				$imgUrl = $med_imgSrc[0];
				$imgTag = '		<div class="gc-post-slider-image gc-fade-in gc-is-visible"><img src="'.$imgUrl.'" alt="' . $imgAlt . '" class="gc-post-slider-img" /></div>' . "\n";
			}
			if( strtolower( $show_date ) == 'true' ) {
				$postDate = '<span class="gc-post-slider-date"><i class="far fa-calendar-alt"></i>  Date: ' . get_the_date('m-d-Y') . ' &nbsp;</span>';
			} else {
				$postDate = '';
			}
			if( strtolower( $show_author ) == 'true' ) {
				$postAuthor = '<span class="gc-post-slider-author"><i class="far fa-user-circle"></i> By: '.get_the_author_posts_link().'</span>';
			} else {
				$postAuthor = '';
			}
			$dateAuthor = '';
			if( $postAuthor != '' or $postDate != '' ) {
				$dateAuthor = '	<div class="gc-post-slider-date-author">' . $postDate . $postAuthor . "</div>\n";
			}
			// output the HTML
			$post_output = "<div class='gc-post-slider-container'>\n" .
				'	<div class="gc-post-slider-title"><a href="' . $postUrl . '">' . $postTitle . "</a></div>\n" .
				$dateAuthor .
				"	<div class='gc-post-slider-image-text'>\n" .
				$imgTag .
				'		<p class="gc-post-slider-text">' . get_the_excerpt() . "</p>\n" .
				"	</div>\n</div>\n";
			$posts_output .= gc_slider_item_function( '', 'article', $animate, '', '', '', $post_output );
 		endwhile;
	endif;
	wp_reset_query();
	return gc_slider_function( $id, $type, $aria_label, $milli_sec, $header, $footer, $bg_color, $text_color, $border_color, $posts_output );
}
/*
** Register [gc_posts_slider] that returns the HTML code for a GC slider
** with posts content.
*/
add_shortcode( 'gc_posts_slider', 'gc_posts_slider_shortcode' );
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
//
?>