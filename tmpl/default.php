<?php
/**
* CG Plaquette 3D - Joomla Module 
* Version			: 3.0.3
* Package			: Joomla 4.x
* copyright 		: Copyright (C) 2022 ConseilGouz. All rights reserved.
* license    		: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* From              : https://tympanus.net/codrops/2012/09/25/3d-restaurant-menu-concept/
*/
// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;

$baseurl 		= URI::base();
$titles = array(Text::_('CG_3D_OPENCLOSE') , Text::_('CG_3D_CLOSE') , Text::_('CG_3D_TURN') , Text::_('CG_3D_BACK') , Text::_('CG_3D_OPEN'), Text::_('CG_3D_TURN') );

PluginHelper::importPlugin('content');

$pageList = $params->get('pageList');
$pages = [];
$ix = 0;
$thumb = "";
foreach ($pageList as $item) {
	$img_str = "<img loading='lazy' src='";
	if ($thumb == "") {
		$img_str = "<img src='";
	}
	if ($item->cg_page_type == 'img') {
		$page = $img_str.$baseurl.$item->file."' title='".$titles[$ix]."' />";
	} else { // text : apply contents plugins updates
		$item_tmp = new stdClass;
		$item_tmp->text = $item->text;
		$item_tmp->params = $params;
		Factory::getApplication()->triggerEvent('onContentPrepare', array ('com_content.article', &$item_tmp, &$item_tmp->params, 0));		
		$text = $item_tmp->text;
		$page = $img_str.$baseurl."media/mod_cg_plaquette_3d/img/vide.jpg' title='".$titles[$ix]."'><div class='cg_3d_text' id='page_".($ix + 1)."'>".$text."'</div>";
	}
	$pages[] = $page;
	if ($thumb == "") {
		$thumb = $page;
	}
    $ix += 1;
}
for ($i = $ix; $i < 6; $i++) { // on force le nombre de pages pour être à 6 pages
	$pages[] = "<img src='".$baseurl."media/mod_cg_plaquette_3d/img/pasdimage.jpg' title='".$titles[$i]."' />";
}
if ($thumb == "") {
	$thumb = "<img src='".$baseurl."media/mod_cg_plaquette_3d/img/pasdimage.jpg' ";
}
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx',''));
?>
<div class="cg_plq_3d <?php echo $moduleclass_sfx;?>" id="cg_plq_3d_<?php echo $module->id;?>" data="<?php echo $module->id;?>">
	<header>
		<a class="cg-photo" id="cg_photo_<?php echo $module->id;?>" data="<?php echo $module->id;?>"><?php echo $thumb;?></a>
	</header>
	<section class="cg_plq_3d_main d-none d-sm-block" id="cg_plq_3d_main_<?php echo $module->id;?>">
		<div class="cg-3d-container">
			<div class="rm-wrapper">
				<div class="rm-cover">
					<div class="rm-front">
						<div class="rm-content">
						<?php echo $pages[0]; // page 1 ?>
						</div><!-- /rm-content -->
					</div><!-- /rm-front -->
					<div class="rm-back">
						<?php echo $pages[1]; // page 2 ?>
					</div><!-- /rm-back -->
				</div><!-- /rm-cover -->
				<div class="rm-middle">
					<div class="rm-content">
						<?php echo $pages[2]; // page 3 ?>
					</div><!-- /rm-content -->
					<div class="rm-back">
						<?php echo $pages[5]; // page 6 ?>
					</div><!-- /rm-back -->
				</div><!-- /rm-middle -->
				<div class="rm-right">
					<div class="rm-back">
						<span class="rm-backpage" title="<?php echo Text::_('CG_3D_BACK_TITLE'); ?>" data="<?php echo $module->id;?>"><?php echo Text::_('CG_3D_LIB_BACK'); ?></span>
						<span class="rm-close" title="<?php echo Text::_('CG_3D_CLOSE_TITLE'); ?>" data="<?php echo $module->id;?>"><?php echo Text::_('CG_3D_LIB_CLOSE'); ?></span>
						<?php echo $pages[3]; // page 4 ?>
					</div><!-- /rm-back -->
					<div class="rm-front">
						<?php echo $pages[4]; // page 5 ?>
					</div><!-- /rm-back -->
				</div><!-- /rm-right -->
			</div><!-- /rm-wrapper -->
			<div>
				<span class="rm-close-all" title="<?php echo Text::_('CG_3D_CLOSEALL_TITLE'); ?>">X</span>
			</div>
		</div><!-- /cg-3d-container -->
	</section>
	<section class="cg_plq_3d_main .d-block .d-sm-none" id="cg_plq_3d_small_<?php echo $module->id;?>">
		<div class="cg-3d-container">
			<div class="rm-wrapper">
						<?php echo $pages[0]; // page 1 ?>
						<?php echo $pages[1]; // page 2 ?>
						<?php echo $pages[3]; // page 3 ?>
						<?php echo $pages[4]; // page 4 ?>
						<?php echo $pages[5]; // page 5 ?>
						<?php echo $pages[6]; // page 6 ?>
			</div><!-- /rm-wrapper -->
			<div>
				<span class="rm-close-all" title="<?php echo Text::_('CG_3D_CLOSEALL_TITLE'); ?>">X</span>
			</div>
		</div><!-- /cg-3d-container -->
	</section>
</div>


