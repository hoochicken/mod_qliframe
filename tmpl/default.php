<?php
/**
 * @package		mod_qliframe
 * @copyright	Copyright (C) 2022 ql.de All rights reserved.
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
$onclick = 'qliframeLoadIframe%sClickSolution(\'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\')';
$onclick = sprintf($onclick, $clicksolution, $unique, $iframe_url, $iframe_attributes, $scripts_afterclickloaded, $confirmtext, $pitatexts);
?>
<div class="qliframe wrapper">
    <?php if ('top' === $iframe_position) : ?>
        <div class="qliframe iframe_wrapper <?php echo empty($image) ? 'qliframe_empty' : ''; ?>" id="qliframe_iframe_<?php echo $unique; ?>">
            <?php if (1 <= $clicksolution && !empty($image)) : ?>
                <input <?php echo $iframebuttonDisabled; ?> type="image" <?php echo $imageSrcAttribute; ?>  id="qliframe_button_image_<?php echo $unique; ?>" onclick="<?php echo $onclick; ?>" class="qliframe_button" />
            <?php endif; ?>
            <?php if (0 === $clicksolution) : ?>
                <iframe id="qliframe_frame_<?php echo $unique; ?>" src="<?php echo $iframe_url; ?>" class="qliframe" style="border:0;" allowfullscreen></iframe>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($infotextDisplay) : ?>
        <div class="info"><?php echo $infotext; ?></div>
    <?php endif; ?>

    <?php if (3 <= $clicksolution) : ?>
        <div class="privacyReadText">
            <input type="checkbox" value="1" onchange="qliframeEnableButton('<?php echo $unique; ?>')" name="qliframe_readprivacy_<?php echo $unique; ?>" id="qliframe_readprivacy_<?php echo $unique; ?>"/>
            <label for="qliframe_readprivacy_<?php echo $unique; ?>"><?php echo $privacyReadText; ?></label>
        </div>
    <?php endif; ?>
    <div class="buttons">
        <?php if ($privacybutton) : ?>
            <button class="btn btn-secondary" onclick="window.open('<?php echo $privacylinkRoute; ?>', '_blank')">
                <?php echo $privacybuttonlabel; ?>
            </button>
        <?php endif; ?>

        <?php if (1 <= $clicksolution) : ?>
            <button class="btn btn-primary" <?php echo $iframebuttonDisabled; ?> id="qliframe_button_<?php echo $unique; ?>" onclick="<?php echo $onclick; ?>" class="qliframe_button">
                <?php echo $iframebuttonlabel; ?>
            </button>
        <?php endif; ?>
    </div>

    <?php if ('bottom' === $iframe_position) : ?>
    <div class="qliframe iframe_wrapper <?php echo empty($image) ? 'qliframe_empty' : ''; ?>" id="qliframe_iframe_<?php echo $unique; ?>">
        <?php if (1 <= $clicksolution && !empty($image)) : ?>
            <input <?php echo $iframebuttonDisabled; ?> type="image" <?php echo $imageSrcAttribute; ?>  id="qliframe_button_image_<?php echo $unique; ?>" onclick="<?php echo $onclick; ?>" class="qliframe_button" />
        <?php endif; ?>
        <?php if (0 === $clicksolution) : ?>
            <iframe id="qliframe_frame_<?php echo $unique; ?>" src="<?php echo $iframe_url; ?>" class="qliframe" style="border:0;" allowfullscreen></iframe>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
