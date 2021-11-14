/*
** ===========================================================================
** Various sources
**  https://cssanimation.rocks/scroll-animations/
**  https://codepen.io/donovanh/pen/aWyPpP
** isElementInViewport function from:
**  http://stackoverflow.com/a/7557433/274826
** gc_marquee based on:
**  https://www.sanwebcorner.com/2016/07/marquee-text-without-marquee-tag-using.html
*/
/**
** JavaScript code for child theme add-on.
** File: gc-animation.js
*/
/**
** Detect request animation frame.
**
** Get various collections/arrays of CSS classes.  Including:
** * .gc-show-on-scroll
** * .gc-show-once-on-scroll
** * .gc-counter
** * .gc-marquee
*/
var gc_scroll = window.requestAnimationFrame ||
	// IE Fallback
	function( callback ){ window.setTimeout( callback, 1000/60 ) };
// variables for gc_loop function
var elementsToShow = document.querySelectorAll( '.gc-show-on-scroll' );
var elementsToShowOnce = document.querySelectorAll( '.gc-show-once-on-scroll' );
var countersToShowOnce = document.querySelectorAll( 'div.gc-counter' );
var marqueesToShowOnce = document.querySelectorAll( 'div.gc-marquee > .gc-scrollingtext' );
var gc_sliders = document.querySelectorAll( '.gc-slider' );
/**
** Function: gc_loop
** Loop on an interval to check the viewport.  If an element is being
** displayed or not being displayed.
*/
function gc_loop( ) {
	//
	if( elementsToShow.length > 0 ) {
		Array.prototype.forEach.call(elementsToShow, function( element ){
			if ( isElementInViewport( element ) ) {
				gc_call_writers( element );
				element.classList.add('gc-is-visible');
			} else {
				element.classList.remove('gc-is-visible');
			}
		} );
	}
	//
	if( elementsToShowOnce.length > 0 ) {
		Array.prototype.forEach.call(elementsToShowOnce, function( element ){
			if ( element.classList.contains('gc-is-visible') === false ) {
				if ( isElementInViewport( element ) ) {
					gc_call_writers( element );
					element.classList.add('gc-is-visible');
				}
			}
		} );
	}
	//
	if( countersToShowOnce.length > 0 ) {
		Array.prototype.forEach.call(countersToShowOnce, function( gc_counter ) {
			if ( gc_counter.classList.contains('gc-is-visible') === false ) {
				if ( isElementInViewport( gc_counter ) ) {
					gc_counter.classList.add('gc-is-visible');
					var st = parseInt( gc_counter.dataset.start );
					var ed = parseInt( gc_counter.dataset.end );
					var inc = parseInt( gc_counter.dataset.inc );
					var int = parseInt( gc_counter.dataset.interval );
					// console.log( `[gc_counter]: ${st} ${ed} ${inc} ${int}` );
					gc_counter_loop( gc_counter, st, ed, inc, int );
				}
			}
		} );
	}
	//
	setTimeout( function( ) { 
		gc_scroll( gc_loop );
	}, 50 );
}
// Call the gc_loop for the first time
gc_loop( );
/**
** Function: isElementInViewport
** If an element is being displayed or not being displayed.
** @param {*} el: dom element to check if it is currently in view
** @returns boolean value (true if element is in view port)
*/
function isElementInViewport( el ) {
	// special bonus for those using jQuery
	if ( typeof jQuery === "function" && el instanceof jQuery) {
		el = el[0];
	}
	var rect = el.getBoundingClientRect( );
	return (
		( rect.top <= 0 && rect.bottom >= 0 )
		|| ( rect.bottom >= ( window.innerHeight || document.documentElement.clientHeight )
			&& rect.top <= ( window.innerHeight || document.documentElement.clientHeight ) )
		|| ( rect.top >= 0 &&
			rect.bottom <= ( window.innerHeight || document.documentElement.clientHeight ) )
	);
}
// ===========================================================================
/**
** Function: gc_counter
** Recursively loop until end number.
** @param {*} div: document selector containing gc-counter class
** @param {*} start: initial count value 
** @param {*} end: endding count value
** @param {*} inc: increamental (step) value
** @param {*} int: timeout interval
** @returns void
*/
function gc_counter_loop( div, start, end, inc, int ) {
	if( div == undefined || div == null || start > end || inc < 1 || int < 10 || int > 999 ) {
		console.error( `gc_counter_loop: ERROR, ${start} ${end} ${inc} ${int}` );
		console.error( div );
		return;
	}
	setTimeout( function( ) { 
		if( start < end ) {
			div.innerText = start;
			var st = start + inc;
			gc_counter_loop( div, st, end, inc, int );
		} else {
			div.innerText = end;
		}
	}, int );
}
// ===========================================================================
/**
** Function: gc_marquee_loop
** Recursively loop on the animation after one pass.
** See gc_marquee_shortcode in functions.php
** @param {*} gc_marquee: dom element of the marquee
** @param {*} millisec: timeout interval
** @param {*} txtWidth: text width
** @param {*} parWidth: parent element width
** @returns void
*/
function gc_marquee_loop( gc_marquee, millisec, txtWidth, parWidth ) {
	if( gc_marquee == undefined || gc_marquee == null || millisec < 1000 ) {
		console.error( `gc_marquee_loop: ERROR, ${millisec} ${txtWidth} ${parWidth}` );
		return;
	}
	setTimeout( function( ) {
		gc_marquee.animate( [{ right: -txtWidth + 'px' }, { right: parWidth + 'px' }],
			{ duration: millisec } );
		gc_marquee_loop( gc_marquee, millisec, txtWidth, parWidth );
	}, millisec );
}
/**
** if statement: marqueesToShowOnce exists
** Gather parameters and then call the first animation and then call
** gc_marquee_loop function.
*/
if( marqueesToShowOnce.length > 0 ) {
	Array.prototype.forEach.call(marqueesToShowOnce, function( gc_marquee ) {
		var millisec = parseInt( gc_marquee.dataset.millisec );
		var txtWidth = gc_marquee.offsetWidth;
		var parWidth = gc_marquee.parentElement.offsetWidth;
		gc_marquee.animate( [{ right: -txtWidth + 'px' }, { right: parWidth + 'px' }],
			{ duration: millisec } );
		gc_marquee_loop( gc_marquee, millisec, txtWidth, parWidth );
	} );
}
// ===========================================================================
/**
** Function: gc_call_writers (gc_wordWriter/gc_typeWriter)
** Check if the CSS class contains one of the writer classes.
** @param {*} element: dom element containing writer class
*/
function gc_call_writers( element ) {
	if( element.classList.contains( 'gc-is-visible' ) === false ) {
		if( element.classList.contains( 'gc-word-writer' ) === true ) {
			var millisec = parseInt( element.dataset.millisec );
			gc_wordWriter( element, element.innerHTML, millisec );
		}
		if( element.classList.contains( 'gc-type-writer' ) === true ) {
			var millisec = parseInt( element.dataset.millisec );
			gc_typeWriter( element, element.innerHTML, millisec );
		}
	}
}
/**
** Function: gc_wordWriter
** Type out the content a word at a time
** @param {*} el: dom element with gc-word-writer class
** @param {*} txt: text string to split into words
*/
function gc_wordWriter( el, txt, speed ) {
	var _i = 0;
	var _words = txt.split(' ');
	el.innerHTML = '';
	function gc_wordLoop() {
		if (_i < _words.length) {
			el.innerHTML += _words[_i] + ' ';
			_i++;
			setTimeout( gc_wordLoop, speed );
		}
	}
	gc_wordLoop( ); // Call the loop for the first time
}
/**
** Function: gc_typeWriter
** type out the content a leter at a time
** @param {*} el: dom element with gc-type-writer class
** @param {*} txt: text string to to display leter at a time
*/
function gc_typeWriter( el, txt, speed ) {
	var _i = 0;
	el.innerHTML = '';
	function gc_typeLoop() {
		if (_i < txt.length) {
			el.innerHTML += txt.charAt(_i);
			_i++;
			setTimeout( gc_typeLoop, speed );
		}
	}
	gc_typeLoop( ); // Call the loop for the first time
}
// =======================================================================
/**
** Get all sliders, loop through the items and set display
** to none and block.  The slider has the following:
** slider
**   header
**   items
**     item #0
**     ...
**     item #n
**   footer
**   counter
*/
if( gc_sliders.length > 0 ) {
	Array.prototype.forEach.call( gc_sliders, function( gc_slider ) {
		var millisec = parseInt( gc_slider.dataset.millisec );
		var items = gc_slider.children[1];
		var count = items.children.length - 1;
		var counter = gc_slider.children[3];
		// process first slider item without delay
		var idx = gc_slider_shift( gc_slider, items, millisec, count, count, 'table' );
		gc_slider_counter( counter, idx, count );
		var interval = setInterval( function() {
			idx = gc_slider_shift( gc_slider, items, millisec, idx, count, 'table' );
			gc_slider_counter( counter, idx, count );
		}, millisec );
	} );
}
/**
** Function: gc_slider_shift
** Turns off the display of the current child and moves to the 
** next child and turns that item to display on.
** @param {*} gc_slider: dom element with gc-slider class
** @param {*} items:     dom elements of slide-items of gc-slider element
** @param {*} millisec:  timeout interval
** @param {*} idx:       the current index (idx of count)
** @param {*} count:     the total count of slides (idx of count)
** @param {*} display:   display type, currently 'table'
* @returns 
*/
function gc_slider_shift( gc_slider, items, millisec, idx, count, display ) {
	if ( gc_slider.classList.contains('gc-paused') === false ) {
		items.children[idx].style.display = 'none';
		idx = ( idx === count ? 0 : ++idx );
		items.children[idx].style.display = display;
		// console.log( `${gc_slider.id} ${idx}, ${millisec}, ${count}` );
	}
	return idx;
}
/**
** Function: gc_slider_counter
** Construct the display of the counter of "# of #", example "1 of 3"
** @param {*} gc_slider: dom element with gc-slider class
** @param {*} idx:       the current index (idx of count)
** @param {*} count:     the total count of slides (idx of count)
** @returns idx that was passed
*/
function gc_slider_counter( gc_slider, idx, count ) {
	gc_slider.innerHTML = `${idx + 1} of ${count + 1}`;
	return idx;
}
/**
** Function: gc_slider_hover
** Add a class of paused to the element.  Aria requirement to be able
** to pause the slider/carousel.
** @param {*} element: dom hovered element with gc-slider class
** @returns false
*/
function gc_slider_hover( element ) {
	element.classList.add('gc-paused');
	return false;
}
/**
** Function: gc_slider_hover_leave
** Remove a class of paused to the element.
** @param {*} element: dom hovered element with gc-slider class
** @returns false
*/
function gc_slider_hover_leave( element ) {
	element.classList.remove('gc-paused');
	return false;
}
// = End of image slider =
// ===========================================================================
