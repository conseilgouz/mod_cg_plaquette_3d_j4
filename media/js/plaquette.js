/**
* CG Plaquette 3D - Joomla Module 
* Version			: 3.0.3
* Package			: Joomla 4.x
* copyright 		: Copyright (C) 2022 ConseilGouz. All rights reserved.
* license    		: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* From              : https://tympanus.net/codrops/2012/09/25/3d-restaurant-menu-concept/
*/
document.addEventListener('DOMContentLoaded', function() {
	mains = document.querySelectorAll('.cg_plq_3d');
	for(var i=0; i<mains.length; i++) {
		var $this = mains[i];
		myid = $this.getAttribute("data");
		go_plaquette(myid);
	}
});
function go_plaquette(myid) {	
	var $main = document.querySelector( '#cg_plq_3d_main_'+myid),	
		$small = document.querySelector( '#cg_plq_3d_small_'+myid),
		$thumb = document.querySelector('#cg_photo_'+myid),
		$wrapper = $main.querySelector('.rm-wrapper'),
		$cover = $main.querySelector( 'div.rm-cover' ),
		$middle = $main.querySelector( 'div.rm-middle' ),
		$right = $main.querySelector( 'div.rm-right' ),
		$close = $right.querySelector('span.rm-close'),
		$back = $right.querySelector('span.rm-backpage'),
		$closeall = $main.querySelector('span.rm-close-all');
		$closeallsmall = $small.querySelector('span.rm-close-all');

	['click', 'touchstart'].forEach(type => {
		$closeall.addEventListener( type, function( event ) {
			removeClass($cover, 'rm-open rm-nodelay rm-in' );
			removeClass($right, 'rm-open rm-nodelay rm-in' );
			removeClass($wrapper,'return');
			removeClass($main,"cg_show");
			return false;
		});
		$closeallsmall.addEventListener( type, function( event ) {
			removeClass($small,"cg_show");
			return false;
		});
		$cover.addEventListener( type, function( event ) {
			if (!hasClass($wrapper,'return')) {
				toggleClass($cover, 'rm-open' );
				if (hasClass($cover,'rm-open') && !(hasClass($right,'rm-open'))) toggleClass($right,'rm-open');
				if (!hasClass($cover,'rm-open') && (hasClass($right,'rm-open'))) toggleClass($right,'rm-open');
				return false;
			}
		} );
		$close.addEventListener( type, function( event ) {
			var myid = this.getAttribute("data");
			$main = document.querySelector('#cg_plq_3d_main_'+myid),	
			$cover = $main.querySelector( 'div.rm-cover' ),
			$right = $main.querySelector( 'div.rm-right' ),
			removeClass($cover,'rm-open rm-nodelay rm-in' );
			removeClass($right, 'rm-open rm-nodelay rm-in' );
			return false;
		} );
		$right.addEventListener (type, function (event) {
			if (!hasClass($wrapper,'return')) {
			toggleClass($right,'rm-open' );
			return false;
			}
		});
		$middle.addEventListener (type, function (event) {
			toggleClass($wrapper,'return');
		});
		$back.addEventListener (type, function (event) {
			toggleClass($wrapper,'return');
		});
		$thumb.addEventListener(type,function(){ 
			var myid = this.getAttribute("data");
			$main = document.querySelector( '#cg_plq_3d_main_'+myid);	
			$small = document.querySelector( '#cg_plq_3d_small_'+myid);	
			if (!hasClass($main,'cg_show') && window.screen.width > 575)  addClass($main,"cg_show");
			if (!hasClass($small,'cg_show') && window.screen.width < 576)  addClass($small,"cg_show");
			return false;
		});
	});
	document.onkeydown = function(evt) { // Cancel Key
    evt = evt || window.event;
    cancelKeypress = (evt.keyCode==27);
    if (cancelKeypress) {
		removeClass($cover, 'rm-open rm-nodelay rm-in' );
		removeClass($right,'rm-open rm-nodelay rm-in' );
		removeClass($wrapper,'return')
		removeClass($main,"cg_show");
		removeClass($small,"cg_show");
		return false;
    }
};
// from https://code.tutsplus.com/tutorials/from-jquery-to-javascript-a-reference--net-23703
hasClass = function (el, cl) {
    var regex = new RegExp('(?:\\s|^)' + cl + '(?:\\s|$)');
    return !!el.className.match(regex);
}
addClass = function (el, cl) {
    el.className += ' ' + cl;
},
removeClass = function (el, cl) {
    var regex = new RegExp('(?:\\s|^)' + cl + '(?:\\s|$)');
    el.className = el.className.replace(regex, ' ');
},
toggleClass = function (el, cl) {
    hasClass(el, cl) ? removeClass(el, cl) : addClass(el, cl);
};

};
