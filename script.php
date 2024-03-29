<?php
/**
* Plaquette 3D module  - Joomla Module 
* Version			: 3.1.0
* Package			: Joomla 4.x/5.x
* copyright 		: Copyright (C) 2023 ConseilGouz. All rights reserved.
* license    		: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/
// No direct access to this file
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Filesystem\Folder;
use Joomla\CMS\Version;
use Joomla\Filesystem\File;

class mod_cg_plaquette_3dInstallerScript
{
	private $min_joomla_version      = '4.0.0';
	private $min_php_version         = '7.4';
	private $name                    = 'CG Plaquette 3D';
	private $exttype                 = 'module';
	private $extname                 = 'mod_cg_plaquette_3d';
	private $previous_version        = '';
	private $dir           = null;
	private $lang = null;
	private $installerName = 'simpleisotopeinstaller';
	public function __construct()
	{
		$this->dir = __DIR__;
		$this->lang = Factory::getLanguage();
		$this->lang->load($this->extname);
	}
    function preflight($type, $parent)
    {
		// To prevent installer from running twice if installing multiple extensions
		if ( ! file_exists($this->dir . '/' . $this->installerName . '.xml'))
		{
			return true;
		}

		if ( ! $this->passMinimumJoomlaVersion())
		{
			$this->uninstallInstaller();

			return false;
		}

		if ( ! $this->passMinimumPHPVersion())
		{
			$this->uninstallInstaller();

			return false;
		}
		$xml = simplexml_load_file(JPATH_SITE . '/modules/'.$this->extname.'/'.$this->extname.'.xml');
		$this->previous_version = $xml->version;
		
    }
    
    function install($parent)
    {
    }
    
    function uninstall($parent)
    {
    }
    
    function update($parent)
    {
    }
    
    function postflight($type, $parent)
    {
		if (($type=='install') || ($type == 'update')) { // remove obsolete dir/files
			$this->postinstall_cleanup();
		}
		
        switch ($type) {
            case 'install': $message = Text::_('ISO_POSTFLIGHT_INSTALLED'); break;
            case 'uninstall': $message = Text::_('ISO_POSTFLIGHT_UNINSTALLED'); break;
            case 'update': $message = Text::_('ISO_POSTFLIGHT_UPDATED'); break;
            case 'discover_install': $message = Text::_('ISO_POSTFLIGHT_DISC_INSTALLED'); break;
        }

		// Uninstall this installer
		$this->uninstallInstaller();

		return true;
    }
	private function postinstall_cleanup() {
		$obsloteFolders = ['assets'];
		// Remove plugins' files which load outside of the component. If any is not fully updated your site won't crash.
		foreach ($obsloteFolders as $folder)
		{
			$f = JPATH_SITE . '/modules/'.$this->extname.'/' . $folder;

			if (!@file_exists($f) || !is_dir($f) || is_link($f))
			{
				continue;
			}

			Folder::delete($f);
		}
		$obsloteFiles = ["helper.php","page_3d.js"];
		foreach ($obsloteFiles as $file)
		{
			$f = JPATH_SITE . '/modules/'.$this->extname.'/' . $file;
			if (@is_file($f))
			{
				File::delete($f);
			}
		}
		$j = new Version();
		$version=$j->getShortVersion(); 
		$version_arr = explode('.',$version);
		if (($version_arr[0] >= "4") || (($version_arr[0] == "3") && ($version_arr[1] == "10"))) {
			// Delete 3.9 and older language files
			$langFiles = [
				sprintf("%s/language/en-GB/en-GB.%s.ini", JPATH_SITE, $this->extname),
				sprintf("%s/language/en-GB/en-GB.%s.sys.ini", JPATH_SITE, $this->extname),
				sprintf("%s/language/fr-FR/fr-FR.%s.ini", JPATH_SITE, $this->extname),
				sprintf("%s/language/fr-FR/fr-FR.%s.sys.ini", JPATH_SITE, $this->extname),
			];
			foreach ($langFiles as $file) {
				if (@is_file($file)) {
					File::delete($file);
				}
			}
		}
		// remove obsolete update sites
		$db = Factory::getDbo();
		$query = $db->getQuery(true)
			->delete('#__update_sites')
			->where($db->quoteName('location') . ' like "%432473037d.url-de-test.ws/%"');
		$db->setQuery($query);
		$db->execute();
		// Simple Isotope is now on Github
		$query = $db->getQuery(true)
			->delete('#__update_sites')
			->where($db->quoteName('location') . ' like "%conseilgouz.com/updates/mod_cg_plaquette%"');
		$db->setQuery($query);
		$db->execute();

	}
	// Check if Joomla version passes minimum requirement
	private function passMinimumJoomlaVersion()
	{
		if (version_compare(JVERSION, $this->min_joomla_version, '<'))
		{
			Factory::getApplication()->enqueueMessage(
				Text::sprintf(
					'NOT_COMPATIBLE_UPDATE',
					'<strong>' . JVERSION . '</strong>',
					'<strong>' . $this->min_joomla_version . '</strong>'
				),
				'error'
			);

			return false;
		}

		return true;
	}

	// Check if PHP version passes minimum requirement
	private function passMinimumPHPVersion()
	{

		if (version_compare(PHP_VERSION, $this->min_php_version, 'l'))
		{
			Factory::getApplication()->enqueueMessage(
				Text::sprintf(
					'NOT_COMPATIBLE_PHP',
					'<strong>' . PHP_VERSION . '</strong>',
					'<strong>' . $this->min_php_version . '</strong>'
				),
				'error'
			);

			return false;
		}

		return true;
	}
	
	private function uninstallInstaller()
	{
		if ( ! is_dir(JPATH_PLUGINS . '/system/' . $this->installerName)) {
			return;
		}
		$this->delete([
			JPATH_PLUGINS . '/system/' . $this->installerName . '/language',
			JPATH_PLUGINS . '/system/' . $this->installerName,
		]);
		$db = Factory::getDbo();
		$query = $db->getQuery(true)
			->delete('#__extensions')
			->where($db->quoteName('element') . ' = ' . $db->quote($this->installerName))
			->where($db->quoteName('folder') . ' = ' . $db->quote('system'))
			->where($db->quoteName('type') . ' = ' . $db->quote('plugin'));
		$db->setQuery($query);
		$db->execute();
		Factory::getCache()->clean('_system');
	}
	
}