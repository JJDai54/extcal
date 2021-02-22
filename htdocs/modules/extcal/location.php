<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    {@link https://xoops.org/ XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package      extcal
 * @since
 * @author       XOOPS Development Team,
 */

use XoopsModules\Extcal;
require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once __DIR__ . '/include/constantes.php';
$GLOBALS['xoopsOption']['template_main'] = 'extcal_location.tpl';
require_once __DIR__ . '/header.php';

$helper = Extcal\Helper::getInstance();

$locationHandler = Extcal\Helper::getInstance()->getHandler(_EXTCAL_CLN_LOCATION);
//require_once XOOPS_ROOT_PATH.'/header.php';


//----------------------------------------------
/* ========================================================================== */
$location_id = \Xmf\Request::getInt('location_id', 0, 'REQUEST');
/* ========================================================================== */

$form = new \XoopsSimpleForm('', 'navigSelectBox', 'location.php', 'get');

$form->addElement(Extcal\Utility::getListLocations($location_id));
$form->addElement(new \XoopsFormButton('', 'form_submit', _SUBMIT, 'submit'));
$btnRTL = new \XoopsFormButton('', 'return_to_list', _MD_EXTCAL_RETURN_TO_LIST, 'button');
$btnRTL->setExtra("onClick=\"location.href='location-list.php'\"");
$form->addElement($btnRTL);

// Assigning the form to the template
$form->assign($xoopsTpl);

//---------------------------------------------------------------

global $xoopsUser, $xoopsModuleConfig, $xoopsModule, $xoopsDB;

//On regarde si le lien existe
$criteria = new \CriteriaCompo();
$criteria->add(new \Criteria('location_id', $location_id, '='));
$location_exist = $locationHandler->getCount($criteria);
//echo "nb location = {$location_exist}<br>";
if ($location_exist == 0) {
    redirect_header(XOOPS_URL . '/modules/extcal/location_list.php', 3, _NOPERM);
}

$view_location = $locationHandler->getLocation($location_id, true);
$location      = $locationHandler->objectToArray($view_location);

$myts = \MyTextSanitizer::getInstance(); // MyTextSanitizer object
//$xoopsTpl->assign('event_address', html_entity_decode($myts->displayTarea(clear_unicodeslashes($event['event_address']), 1, 1, 1, 1, 1)));
$location['description'] = html_entity_decode($myts->displayTarea(clear_unicodeslashes($location['description']), 1, 1, 1, 1, 1));
$location['horaires'] = html_entity_decode($myts->displayTarea(clear_unicodeslashes($location['horaires']), 1, 1, 1, 1, 1));

$isAdmin = false;
if (isset($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
    $isAdmin = true;
}

/* todo a deplacer dans le template JJD */
$uid = $xoopsUser ? $xoopsUser->getVar('uid') : 0;
global $xoopsModule;


if (is_object($xoopsUser) && $isAdmin) {
  $xoopsTpl->assign('buttons', $locationHandler->getButtons($location_id, 2+4));
}

$xoopsTpl->assign('location', $location);
//ext_echo($location);
    $tNavBar = getNavBarTabs('location-list');//$params['view']
    $xoopsTpl->assign('tNavBar', $tNavBar);
    $xoopsTpl->assign('list_position', -1);

$date = mktime(0, 0, 0, date('m'), date('d'), date('y'));

$requete = $xoopsDB->query('SELECT event_id, event_title, event_desc, event_picture1, event_start FROM ' . $xoopsDB->prefix('extcal_event') . " WHERE location_id='" . $location_id . "' AND event_start >='" . $date . "'");
while (false !== ($donnees = $xoopsDB->fetchArray($requete))) {
    if ($donnees['event_desc'] > 210) {
        $event_desc = $donnees['event_desc'];
    } else {
        $event_desc = mb_substr($donnees['event_desc'], 0, 210) . '...';
    }
    $xoopsTpl->append('events', [
        'event_picture1' => $donnees['event_picture1'],
        'event_id'       => $donnees['event_id'],
        'event_title'    => $donnees['event_title'],
        'event_desc'     => $event_desc,
        'event_start'    => date('Y-m-d', $donnees['event_start']),
    ]);
}

/** @var xos_opal_Theme $xoTheme */
// $xoTheme->addScript('browse.php?modules/extcal/assets/js/highslide.js');
// $xoTheme->addStylesheet('browse.php?modules/extcal/assets/js/highslide.css');
ext_include_highslide();

 $rep_Src = XOOPS_ROOT_PATH . "/uploads/extcal/location";
// $rep_Dst = $rep_Src . "/thumbs";
// $Wmax = 300;
// $Hmax = 0;
// $img_Src = $location['logo'];
// $img_Dst = $img_Src;
// fct_redim_image($Wmax, $Hmax, $rep_Dst, $img_Dst, $rep_Src, $img_Src);
if (!is_file($rep_Src . "/" ._EXTCAL_THUMBS. "/" . $location['logo'])){
    ext_redim_img($rep_Src . "/" . $location['logo'], $width=300, $height=0, _EXTCAL_THUMBS);
}





require_once XOOPS_ROOT_PATH . '/footer.php';
//echo "<hr><center>FIN (" . rand(0,100) . ")</center><hr>";
//exit;