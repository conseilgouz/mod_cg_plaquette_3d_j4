/**
* CG Plaquette 3D - Joomla Module 
* Version			: 3.0.0
* Package			: Joomla 4.x
* copyright 		: Copyright (C) 2022 ConseilGouz. All rights reserved.
* license    		: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* From              : https://tympanus.net/codrops/2012/09/25/3d-restaurant-menu-concept/
*/
jQuery(document).ready(function(){
	jQuery('.subform-repeatable-group').each(function() {
		$this = jQuery(this);
		$lib = $this.attr("data-group");
		$ix = parseInt($lib.substring($lib.length - 1, $lib.length)) + 1; // page #
		jQuery("[data-group="+$lib+"] #result").html("Page "+$ix);
	});
})