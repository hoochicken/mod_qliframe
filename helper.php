<?php
/**
 * @package		mod_qlqliframe
 * @copyright	Copyright (C) 2024 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\WebAsset\WebAssetManager;


defined('_JEXEC') or die;

class ModQliframeHelper
{
    public $module;
    public \Joomla\Registry\Registry $params;
    /** @var WebAssetManager */
    public $wa;
    public $img_sfx = 'png';

	function __construct($module, $params, $wa)
    {
        $this->module = $module;
        $this->params = $params;
        $this->wa = $wa;
    }

    public static function recieveQliframeAjax()
    {
        $url = Factory::getApplication()->input->getString('iframe_url', '');
        require_once __DIR__ . '/php/classes/ModQliframeCachier.php';
        ModQliframeCachier::memorize($url);
    }

    public static function resetQliframeCacheAjax()
    {
        $url = Factory::getApplication()->input->getString('iframe_url', '');
        require_once __DIR__ . '/php/classes/ModQliframeCachier.php';
        ModQliframeCachier::forget();
    }

    /**
     * initiating parameters into useful variables
     * @return array
     */
    public function initiateParams()
    {
        $params = $this->params;

        $clicksolution = (int) $params->get('clicksolution', 0);
        $confirmtext = str_replace(['\'', '"', "\n", "\r"], [], strip_tags($this->getTextByParamOrLanguageOverride('confirmtext', Text::_('MOD_QLIFRAME_CONFIRMTEXTDEFAULT'))));
        $iframe_position = $params->get('iframe_position', 'bottom');
        $iframe_url = $params->get('iframe_url', '');
        $iframe_cache = (bool)$params->get('iframe_cache', false);
        $iframe_attributes = str_replace('"', '\'', addslashes($params->get('iframe_attributes', '')));
        $iframebuttonlabel = $this->getTextByParamOrLanguageOverride('iframebuttonlabel', Text::_('MOD_QLIFRAME_IFRAMEBUTTONLABELDEFAULT'));
        $iframebuttonDisabled = (3 <= $clicksolution) ? 'disabled' : '';
        $image =  $this->getImagePath($params->get('image', ''), $imageButton = $params->get('image_button', ''));
        $imageSrcAttribute = sprintf('src="%s"', $image);
        $imageButtonDisplay = !empty($image);
        $infotext = $params->get('info', '');
        $infotextDisplay = !empty(strip_tags($infotext));
        $pitatexts = $clicksolution <= 3 ? '' : str_replace(["\n", "\r", '~~~~'], '~~', $params->get('pitatexts', ''));
        $privacybutton = (bool) $params->get('privacybutton', false);
        $privacybuttonlabel = $params->get('privacybuttonlabel', Text::_('MOD_QLIFRAME_PRIVACYBUTTON'));
        $privacyItemId = $params->get('privacyItemId', false);
        $privacylinkRoute = Route::_('index.php?Itemid=' . $privacyItemId);
        $privacyReadText = $this->getTextByParamOrLanguageOverride('privacyReadText', Text::_('MOD_QLIFRAME_PRIVACYREADTEXTDEFAULT'));
        $privacyReadTextDisplay = !empty(strip_tags($privacyReadText));
        $scripts_afterclickloaded = $params->get('scripts_afterclickloaded', '');
        $unique = uniqid();
        $unique_key = 'qliframe_' . $unique;

        return [
            'clicksolution' => $clicksolution,
            'confirmtext' => $confirmtext,
            'privacybutton' => $privacybutton,
            'privacybuttonlabel' => $privacybuttonlabel,
            'privacyItemId' => $privacyItemId,
            'privacylinkRoute' => $privacylinkRoute,
            'privacyReadText' => $privacyReadText,
            'privacyReadTextDisplay' => $privacyReadTextDisplay,
            'iframe_url' => $iframe_url,
            'iframe_attributes' => $iframe_attributes,
            'iframe_cache' => $iframe_cache,
            'iframe_position' => $iframe_position,
            'image' => $image,
            'imageButton' => $imageButton,
            'imageButtonDisplay' => $imageButtonDisplay,
            'imageSrcAttribute' => $imageSrcAttribute,
            'infotext' => $infotext,
            'infotextDisplay' => $infotextDisplay,
            'iframebuttonDisabled' => $iframebuttonDisabled,
            'iframebuttonlabel' => $iframebuttonlabel,
            'pitatexts' => $pitatexts,
            'scripts_afterclickloaded' => $scripts_afterclickloaded,
            'unique' => $unique,
            'unique_key' => $unique_key,
            ];
	}

    /**
     * returns parameter value
     * if parameter value is empty, default is returned
     * if parameter value is a jtext PLACEHOLDER for language override, this language override is returned
     * @param string $parameterName
     * @param string $default
     * @return string
     */
    private function getTextByParamOrLanguageOverride(string $parameterName, string $default = ''): string
    {
        $value = $this->params->get($parameterName, $default);
        $keyLanguage = trim(strip_tags($value));
        $valueLanguage = Text::_($keyLanguage);
        if ($keyLanguage !== $valueLanguage) $value = $valueLanguage;
        return $value;
    }

    public function addStylesAndScripts(int $clicksolution, string $scripts = '')
    {
        $height = (int) $this->params->get('iframe_height', 400);
        $this->wa->registerStyle('mod_qliframe', 'mod_qliframe/styles.css');
        $this->wa->useStyle('mod_qliframe');
        if (0 < $height) $this->wa->addInlineStyle(sprintf('.qliframe iframe {height:%spx;}', $height));
        $this->wa->registerScript('mod_qliframe', 'mod_qliframe/script.js');
        $this->wa->useScript('mod_qliframe');
        $this->wa->registerScript('mod_qliframe_ajax', 'mod_qliframe/qliframe_ajax.js');
        $this->wa->useScript('mod_qliframe_ajax');

        if (!empty(trim($scripts)) && 0 === $clicksolution) {
            $this->wa->registerScript('mod_qliframe', 'mod_qliframe/script.js');
            $this->wa->useScript('mod_qliframe');
        }
    }

    private function getImagePath(string $customMedia, string $imagePredefined): ?string
    {
        if (empty($imagePredefined)) {
            return null;
        }
        if ('custom' === $imagePredefined && !empty($customMedia)) {
            return Uri::root() . '/' . $customMedia;
        }
        return Uri::root() . 'modules/' . $this->module->module . '/images/' . $imagePredefined . '.' . $this->img_sfx;
    }
}
