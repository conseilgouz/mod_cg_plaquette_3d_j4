<?php
/**
* CG Plaquette 3D - Joomla Module 
* Version			: 3.0.4
* Package			: Joomla 4.x
* copyright 		: Copyright (C) 2022 ConseilGouz. All rights reserved.
* license    		: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* From              : https://tympanus.net/codrops/2012/09/25/3d-restaurant-menu-concept/
*/
// no direct access
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Uri\Uri;

$modulefield	= 'media/mod_cg_plaquette_3d/';

//Get this module id
$nummod_sf		= $module->id;
$num_sf		= 'mod'.$nummod_sf;

// JHtml::_('jquery.framework');
$wa = Factory::getDocument()->getWebAssetManager();
if ($params->get('cssp3d')) $wa->addInlineStyle($params->get('cssp3d')); 
$wa->registerAndUseStyle('3d',$modulefield.'css/plaquette.css');
if ((bool)Factory::getConfig()->get('debug')) { // Mode debug
	Factory::getDocument()->addScript(''.URI::base(true).'/media/mod_cg_plaquette_3d/js/plaquette.js'); 
} else {
	$wa->registerAndUseScript('3d',$modulefield.'js/plaquette.js');
}
require ModuleHelper::getLayoutPath('mod_cg_plaquette_3d', $params->get('layout', 'default'));
?>