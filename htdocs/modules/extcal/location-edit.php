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
//echo "===>" .  __FILE__ . "<br>";


require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once __DIR__ . '/include/constantes.php';
$GLOBALS['xoopsOption']['template_main'] = 'extcal_location_edit.tpl';
require_once __DIR__ . '/header.php';

global $xoopsUser, $xoopsModuleConfig, $xoopsModule, $xoopsDB;
//echo "<hr>formulaire location (" . rand(0,100) . ")<hr>";

$params = ['view' => _EXTCAL_NAV_LOCATION_LIST, 'file' => _EXTCAL_FILE_LOCATION_LIST];

$tNavBar = getNavBarTabs($params['view']);
$xoopsTpl->assign('tNavBar', $tNavBar);
$xoopsTpl->assign('list_position', -1);

/* ========================================================================== */
$location_id = \Xmf\Request::getInt('location_id', 0, 'REQUEST');
$op = \Xmf\Request::getString('op', 'edit_location', 'REQUEST');



/* ========================================================================== */
$locationHandler = Extcal\Helper::getInstance()->getHandler(_EXTCAL_CLN_LOCATION);

//***************************************************************
switch ($op){
  case "save_location":
//  ext_echo($_REQUEST);exit;
    $locationHandler->saveLocation("user", $_REQUEST);
    break;

  case "edit_location":
  default:
    global $xoopsTpl;

    $tNavBar = getNavBarTabs($params['view']);
    $xoopsTpl->assign('tNavBar', $tNavBar);
    $xoopsTpl->assign('list_position', -1);


    $location = $locationHandler->getLocationForm($location_id, "user");
    $xoopsTpl->assign('formEdit', $location);

ext_include_highslide();


    require_once XOOPS_ROOT_PATH . '/footer.php';

  break;

}


//require_once XOOPS_ROOT_PATH.'/header.php';







// Assigning the form to the template
//$form->assign($xoopsTpl);

//---------------------------------------------------------------


//echo "<hr><center>FIN (" . rand(0,100) . ")</center><hr>";
//exit;
