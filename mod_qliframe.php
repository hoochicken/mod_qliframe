<?php
/**
 * @package        mod_qliframe
 * @copyright    Copyright (C) 2022 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\WebAsset\WebAssetManager;

/** @var $params JRegistry */
/** @var $module stdClass */

require_once dirname(__FILE__) . '/helper.php';
$obj_helper = new modQliframeHelper($module, $params, Factory::getApplication()->getDocument()->getWebAssetManager());
$array = $obj_helper->initiateParams();
extract($array);

// if no url given, wie won't display anything :-)
if (empty($iframe_url)) return;

// add styles to DOM and scripts as well
$obj_helper->addStylesAndScripts($clicksolution, $scripts_afterclickloaded);

require JModuleHelper::getLayoutPath('mod_qliframe', $params->get('layout', 'default'));
