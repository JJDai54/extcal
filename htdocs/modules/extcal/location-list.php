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
$GLOBALS['xoopsOption']['template_main'] = 'extcal_location_list.tpl';
require_once __DIR__ . '/header.php';

global $xoopsUser, $xoopsModuleConfig, $xoopsModule, $xoopsDB;
//echo "<hr>formulaire location (" . rand(0,100) . ")<hr>";

$params = ['view' => _EXTCAL_NAV_LOCATION_LIST, 'file' => _EXTCAL_FILE_LOCATION_LIST];
global $xoopsTpl, $xoopsUser;

$tNavBar = getNavBarTabs($params['view']);
$xoopsTpl->assign('tNavBar', $tNavBar);
$xoopsTpl->assign('list_position', -1);


$locationHandler = Extcal\Helper::getInstance()->getHandler(_EXTCAL_CLN_LOCATION);
$locations = $locationHandler->getAll(null,  null, false);

$isAdmin = false;
if (isset($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
    $isAdmin = true;
}

//require_once XOOPS_ROOT_PATH.'/header.php';
if (is_object($xoopsUser) && $isAdmin) {
  $xoopsTpl->assign('buttons', $locationHandler->getButtons($location_id, 1));
}


$xoopsTpl->assign('locations', $locations);





// Assigning the form to the template
//$form->assign($xoopsTpl);

//---------------------------------------------------------------



ext_include_highslide();


require_once XOOPS_ROOT_PATH . '/footer.php';
//echo "<hr><center>FIN (" . rand(0,100) . ")</center><hr>";
//exit;
