<?php
/**
 * @package		mod_qliframe
 * @copyright	Copyright (C) 2024 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// no direct access
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\WebAsset\WebAssetManager;

/** @var JRegistry $params */
/** @var stdClass $module */
/** @var int $clicksolution */
/** @var string $confirmtext */
/** @var bool $privacybutton  */
/** @var string $privacybuttonlabel  */
/** @var string $privacyItemId */
/** @var string $privacylinkRoute */
/** @var int $privacyReadText */
/** @var bool $privacyReadTextDisplay */
/** @var string $iframe_url */
/** @var string $iframe_attributes */
/** @var string $iframebuttonDisabled disabled | ''*/
/** @var string $iframe_position */
/** @var bool $iframe_cache */
/** @var string $image */
/** @var string $imageSrcAttribute */
/** @var string $infotext */
/** @var bool $infotextDisplay */
/** @var string $iframebuttonlabel */
/** @var string $qliframe_map id of igrame element */
/** @var string $qliframe_button */
/** @var string $qliframe_iframe */
/** @var string $scripts_afterclickloaded */
/** @var string $pitatexts */
/** @var string $unique */
/** @var string $unique_key */

// onclick event
$clicksolution = $iframe_cache && ModQliframeCachier::isAlreadyMemorized($iframe_url)
    ? 0
    : $clicksolution;
$onclick = 'qliframeLoadIframe%sClickSolution(\'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\')';
$onclick = sprintf($onclick, $clicksolution, $unique, $iframe_url, $iframe_attributes, $scripts_afterclickloaded, $confirmtext, $pitatexts);
?>
<div class="qliframe wrapper">
    <?php if ('top' === $iframe_position) : ?>
        <div class="qliframe iframe_wrapper  <?= empty($image) && $clicksolution ? 'qliframe_empty' : ''; ?>" id="qliframe_iframe_<?= $unique; ?>">
            <?php if (1 <= $clicksolution && !empty($image)) : ?>
                <input <?= $iframebuttonDisabled; ?> type="image" <?= $imageSrcAttribute; ?> id="qliframe_button_image_<?= $unique; ?>" onclick="<?= $onclick; ?>" class="qliframe_button" />
            <?php endif; ?>
            <?php if (0 === $clicksolution) : ?>
                <iframe id="qliframe_frame_<?= $unique; ?>" src="<?= $iframe_url; ?>" class="qliframe" style="border:0;" allowfullscreen></iframe>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($infotextDisplay) : ?>
        <div class="info"><?= $infotext; ?></div>
    <?php endif; ?>

    <?php if (3 <= $clicksolution) : ?>
        <div class="privacyReadText">
            <input type="checkbox" value="1" onchange="qliframeEnableButton('<?= $unique; ?>')" name="qliframe_readprivacy_<?= $unique; ?>" id="qliframe_readprivacy_<?= $unique; ?>"/>
            <label for="qliframe_readprivacy_<?= $unique; ?>"><?= $privacyReadText; ?></label>
        </div>
    <?php endif; ?>
    <div class="buttons">
        <?php if ($privacybutton) : ?>
            <button class="btn btn-secondary privacy-button" onclick="window.open('<?= $privacylinkRoute; ?>', '_blank')">
                 <?= $privacybuttonlabel; ?>
            </button>
        <?php endif; ?>

        <?php if (1 <= $clicksolution) : ?>
            <button class="btn btn-secondary iframe-button qliframe_button" <?= $iframebuttonDisabled; ?> id="qliframe_button_<?= $unique; ?>" onclick="<?= $onclick; ?>">
                 <?= $iframebuttonlabel; ?>
            </button>
        <?php endif; ?>
    </div>

    <?php if ('bottom' === $iframe_position) : ?>
    <div class="qliframe iframe_wrapper <?= empty($image) && $clicksolution ? 'qliframe_empty' : ''; ?>" id="qliframe_iframe_<?= $unique; ?>">
        <?php if (1 <= $clicksolution && !empty($image)) : ?>
            <input <?= $iframebuttonDisabled; ?> alt="<?= $iframebuttonlabel; ?>" class="qliframe_button" type="image" <?= $imageSrcAttribute; ?>  id="qliframe_button_image_<?= $unique; ?>" onclick="<?= $onclick; ?>" />
        <?php endif; ?>
        <?php if (0 === $clicksolution) : ?>
            <iframe id="qliframe_frame_<?= $unique; ?>" title="<?= $iframebuttonlabel; ?>" src="<?= $iframe_url; ?>" class="qliframe" style="border:0;" allowfullscreen></iframe>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($iframe_cache) : ?>
        <form method="post">
            <input type="hidden" name="qliframe_reset_cache" value="1">
            <button class="btn btn-secondary iframe-button-cache-reset" id="qliframe_button_cachereset_<?= $unique; ?>" onclick="submit()">
                <?= Text::_('MOD_QLIFRAME_BTN_CACHERESET'); ?>
            </button>
        </form>
    <?php endif; ?>
</div>
