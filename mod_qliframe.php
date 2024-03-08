<?php
/**
 * @package        mod_qliframe
 * @copyright    Copyright (C) 2024 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Ql\Module\Qliframe\Site;

// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\Registry;
use ModQliframeHelper;

/** @var $params Registry */
/** @var $module \stdClass */

require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/php/classes/ModQliframeCachier.php';
$obj_helper = new ModQliframeHelper($module, $params, Factory::getApplication()->getDocument()->getWebAssetManager());

$input = Factory::getApplication()->input;
$qliframe_reset_cache = (bool)$input->getBool('qliframe_reset_cache', 0);
if ($qliframe_reset_cache) {
    ModQliframeHelper::resetQliframeCacheAjax();
}

$array = $obj_helper->initiateParams();
extract($array);

// if no url given, wie won't display anything :-)
if (empty($iframe_url)) return;

// add styles to DOM and scripts as well
$obj_helper->addStylesAndScripts($clicksolution, $scripts_afterclickloaded);

require ModuleHelper::getLayoutPath('mod_qliframe', $params->get('layout', 'default'));
