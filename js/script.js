/*
@package		mod_qliframe
@copyright	Copyright (C) 2023 ql.de All rights reserved.
@author 		Mareike Riegel mareike.riegel@ql.de
@license		GNU General Public License version 2 or later; see LICENSE.txt
*/

/**
 *
 * @param string uniquefier                unique addition to id, to tell one iframe from the other in the same page
 * @param string iframe_url                url of iframe, 'https://...
 * @param string scripts_afterclickloaded  scripts to be loaded after last click
 * @param string iframe_attributes         attributes for iframe
 * @returns {boolean}
 */
function qliframeLoadIframe1ClickSolution(uniquefier, iframe_url, iframe_attributes = '', scripts_afterclickloaded='')
{
  // get id of iframe
  let iframeId = 'qliframe_iframe_' + uniquefier;
  qliframeDisplayElementById(iframeId);

  // some scripte need to be loaded aditionally to iframe
  // e. g. vimeo needs this whyever
  qliframeAddScriptToDoms(scripts_afterclickloaded);
  qliframeHideImagebutton(uniquefier);

  // build iframe html, actually add the html of the iframe
  qliframeAppendIframeToWrapper(iframeId, iframe_url, iframe_attributes);

  // disable button
  let buttonId = 'qliframe_button_' + uniquefier;
  qliframeDisableButton(buttonId);
}

/**
 *
 * @param string uniquefier                unique addition to id, to tell one iframe from the other in the same page
 * @param string iframe_url                url of iframe, 'https://...
 * @param string scripts_afterclickloaded  scripts to be loaded after last click
 * @param string iframe_attributes         attributes for iframe
 * @returns {boolean}
 */
function qliframeLoadIframe2ClickSolution(uniquefier, iframe_url, iframe_attributes = '', scripts_afterclickloaded='', confirmtext = '')
{
  // get id of iframe
  let iframeId = 'qliframe_iframe_' + uniquefier;

  qliframeDisplayElementById(iframeId);

  if (!confirm(confirmtext)) {
    qliframeEmptyWrapper(iframeId);
    return false;
  }

  // some scripte need to be loaded aditionally to iframe
  // e. g. vimeo needs this whyever
  qliframeAddScriptToDoms(scripts_afterclickloaded);
  qliframeHideImagebutton(uniquefier);

  // build iframe html, actually add the html of the iframe
  qliframeAppendIframeToWrapper(iframeId, iframe_url, iframe_attributes);

  // disable button
  let buttonId = 'qliframe_button_' + uniquefier;
  qliframeDisableButton(buttonId);
}

/**
 *
 * @param string uniquefier                unique addition to id, to tell one iframe from the other in the same page
 * @param string iframe_url                url of iframe, 'https://...
 * @param string scripts_afterclickloaded  scripts to be loaded after last click
 * @param int clickNumber                  number of clicks required for display of iframe
 * @param string confirmtext               text displayed in confirm pop-up
 * @param string iframe_attributes         attributes for iframe
 * @returns {boolean}
 */
function qliframeLoadIframe3ClickSolution(uniquefier, iframe_url, iframe_attributes = '', scripts_afterclickloaded='', confirmtext = '')
{
  // get id of iframe
  let iframeId = 'qliframe_iframe_' + uniquefier;

  // disable button
  let inputId = 'qliframe_readprivacy_' + uniquefier;
  document.getElementById(inputId).disabled = true;

  qliframeDisplayElementById(iframeId);

  // remove iframe from iframe_holder
  if (!confirm(confirmtext)) {
    qliframeEmptyWrapper(iframeId);
    return false;
  }

  // some scripte need to be loaded aditionally to iframe
  // e. g. vimeo needs this whyever
  qliframeAddScriptToDoms(scripts_afterclickloaded);
  qliframeHideImagebutton(uniquefier);

  // build iframe html, actually add the html of the iframe
  qliframeAppendIframeToWrapper(iframeId, iframe_url, iframe_attributes);

  // disable button
  let buttonId = 'qliframe_button_' + uniquefier;
  qliframeDisableButton(buttonId);
}

/**
 *
 * @param string uniquefier                unique addition to id, to tell one iframe from the other in the same page
 * @param string iframe_url                url of iframe, 'https://...
 * @param string scripts_afterclickloaded  scripts to be loaded after last click
 * @param int clickNumber                  number of clicks required for display of iframe
 * @param string confirmtext               text displayed in confirm pop-up
 * @param string iframe_attributes         attributes for iframe
 * @returns {boolean}
 */
function qliframeLoadIframe100ClickSolution(uniquefier, iframe_url, iframe_attributes = '', scripts_afterclickloaded='', confirmtext = '', pitatexts = '')
{
  // get id of iframe
  let iframeId = 'qliframe_iframe_' + uniquefier;

  // disable button
  let inputId = 'qliframe_readprivacy_' + uniquefier;
  document.getElementById(inputId).disabled = true;

  qliframeDisplayElementById(iframeId);

  // remove iframe from iframe_holder
  if (!confirm(confirmtext)) {
    qliframeEmptyWrapper(iframeId);
    return false;
  }

  if ('undefined' !== typeof pitatexts) {
    let pitatextsSplitted = pitatexts.split('~~');
    for (let i = 0; i < pitatextsSplitted.length; i++) {
      confirmtext= pitatextsSplitted[i];
      // remove iframe from iframe_holder
      if (!confirm(confirmtext)) {
        qliframeEmptyWrapper(iframeId);
        return false;
      }
    }
  }

  // some scripte need to be loaded aditionally to iframe
  // e. g. vimeo needs this whyever
  qliframeAddScriptToDoms(scripts_afterclickloaded);
  qliframeHideImagebutton(uniquefier);

  // build iframe html, actually add the html of the iframe
  qliframeAppendIframeToWrapper(iframeId, iframe_url, iframe_attributes);

  // disable button
  let buttonId = 'qliframe_button_' + uniquefier;
  qliframeDisableButton(buttonId);
}

/**
 *
 * @param elementId
 */
function qliframeDisplayElementById(elementId)
{
  document.getElementById(elementId).style.display = 'block';
}

/**
 *
 * @param elementId
 */
function qliframeHideElementById(elementId)
{
  document.getElementById(elementId).style.display = 'none';
}

/**
 * adds scripts to DOM after the last click
 * multiple scripts can be added, they need to be separated by linebreak
 * @param string scripts_afterclickloaded - scripts to be loaded after last click, e. g. required on vimeo
 */
function qliframeAddScriptToDoms(scripts_afterclickloaded) {
  let scripts = scripts_afterclickloaded.split("\n");

  let elScript = document.createElement('script');
  elScript.setAttribute('type', 'text/javascript');
  for (let i = 0; i < scripts.length; i++) {
    elScript.setAttribute('src', scripts[i]);
    document.head.appendChild(elScript);
  }
}

/**
 * checks whether privacy is read
 * removes button property 'disabled' from "Display map"-button
 * @param uniquefier
 * @returns {boolean}
 */
function qliframeEnableButton(uniquefier) {
  let inputId = 'qliframe_readprivacy_' + uniquefier;
  let buttonId = 'qliframe_button_' + uniquefier;
  let imageButtonId = 'qliframe_button_image_' + uniquefier;

  if (!document.getElementById(inputId).checked) {
    // common button
    if (null !== document.getElementById(buttonId)) document.getElementById(buttonId).disabled = true;
    // image button
    if (null !== document.getElementById(imageButtonId)){
      qliframeHideElementById(imageButtonId);
      document.getElementById(imageButtonId).disabled = true;
    }
    return false;
  }
  // common button
  if (null !== document.getElementById(buttonId)) document.getElementById(buttonId).disabled = false;
  // image button
  if (null !== document.getElementById(imageButtonId)) {
    qliframeDisplayElementById(imageButtonId);
    document.getElementById(imageButtonId).disabled = false;
  }
}

/**
 * checks whether privacy is read
 * removes button property 'disabled' from "Display map"-button
 * @returns {boolean}
 * @param iframe_url
 * @param iframe_attributes
 */
function qliframeGetIframeHtml(iframe_url, iframe_attributes) {
  // build iframe html
  let htmlIframe = '<iframe src="IFRAME_URL" IFRAME_ATTRIBUTES></iframe>';
  htmlIframe = htmlIframe.replace("IFRAME_URL", iframe_url);
  htmlIframe = htmlIframe.replace("IFRAME_ATTRIBUTES", iframe_attributes);
  return htmlIframe;
}

/**
 * checks whether privacy is read
 * removes button property 'disabled' from "Display map"-button
 * @param uniquefier
 * @returns {boolean}
 */
function qliframeHideImagebutton(uniquefier)
{
  let imageButtonId = 'qliframe_button_image_' + uniquefier;
  if (null === document.getElementById(imageButtonId)) return;
  qliframeHideElementById(imageButtonId);
}

/**
 * checks whether privacy is read
 * removes button property 'disabled' from "Display map"-button
 * @returns {boolean}
 * @param iframeId
 * @param iframe_url
 * @param iframe_attributes
 */
function qliframeAppendIframeToWrapper(iframeId, iframe_url, iframe_attributes)
{
  // build iframe html, actually add the html of the iframe
  let htmlIframe = qliframeGetIframeHtml(iframe_url, iframe_attributes);
  document.getElementById(iframeId).insertAdjacentHTML('beforeend', htmlIframe);
}

/**
 * checks whether privacy is read
 * removes button property 'disabled' from "Display map"-button
 * @returns {boolean}
 */
function qliframeEmptyWrapper(iframeId)
{
  document.getElementById(iframeId).insertAdjacentHTML('beforeend', '');
}

/**
 * checks whether privacy is read
 * removes button property 'disabled' from "Display map"-button
 * @returns {boolean}
 */
function qliframeDisableButton(buttonId)
{
  document.getElementById(buttonId).disabled = 'true';
}