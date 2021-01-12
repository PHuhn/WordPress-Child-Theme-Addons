/*
** ===========================================================================
** Detect request animation frame
** https://cssanimation.rocks/scroll-animations/
** https://codepen.io/donovanh/pen/aWyPpP
*/
var scroll = window.requestAnimationFrame ||
		// IE Fallback
		function( callback ){ window.setTimeout( callback, 1000/60 ) };
// variables for loop function
var elementsToShow = document.querySelectorAll( '.gc-show-on-scroll' );
var elementsToShowOnce = document.querySelectorAll( '.gc-show-once-on-scroll' );
var countersToShowOnce = document.querySelectorAll( 'div.gc-counter' );
//
function loop( ) {
	//
	if( elementsToShow.length > 0 ) {
		Array.prototype.forEach.call(elementsToShow, function( element ){
			if ( isElementInViewport( element ) ) {
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
	scroll( loop );
}
// Call the loop for the first time
loop( );
// Helper function from: http://stackoverflow.com/a/7557433/274826
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
//
// ===========================================================================
// gc_counter
// Recursively loop until end
function gc_counter_loop( div, start, end, inc, int ) {
	if( div == undefined || div == null || start > end || inc < 1 || int < 10 || int > 999 ) {
		console.log( `gc_counter_loop: ERROR, ${start} ${end} ${inc} ${int}` );
		console.log( div );
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
