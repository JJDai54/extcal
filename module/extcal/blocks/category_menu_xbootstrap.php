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

require_once dirname(__DIR__) . '/include/constantes.php';

/******************************************************/
/* Ajour JJD - Evenements par categries               */
/******************************************************/
/**
 * @param $options
 *
 * @return array
 */
function bExtcalCategoryMenuShow($options)
{
    global $xoopsUser, $extcalConfig;

    $block = array();
    $moduleDirName = basename(dirname(__DIR__));

    $catHandler = \XoopsModules\Extcal\Helper::getInstance()->getHandler(_EXTCAL_CLN_CAT);
    $tCats      = $catHandler->objectToArray($catHandler->getAllCat($xoopsUser, 'all'));

// $tr = print_r($tCats, true);
// echo "<hr><pre>{$tr}</pre><hr>";
    $MenuItems = [];
    $url = XOOPS_URL . "/modules/" . $moduleDirName . "/view_calendar-month.php?cat=";
    foreach ($tCats as $h => $item) {
        $MenuItems [$item['cat_id']] = array('id'=>$item['cat_id'], 'lib'=>$item['cat_name'], 'url'=> $url . $item['cat_id']) ;
    }


    $block['MenuCatItems'] = $MenuItems;

    $block['module']['url'] = XOOPS_URL . "/modules/" . $moduleDirName ;
    $block['module']['lib'] = _MB_EXTCAL_PLANNING;

    $block['search']['url'] = XOOPS_URL . "/modules/" . $moduleDirName . "/view_calendar-month.php?cat=";
    $block['search']['lib'] = _MB_EXTCAL_VIEW_MONTH;







    $block['main']['month']['url'] = XOOPS_URL . "/modules/" . $moduleDirName . "/view_calendar-month.php";
    $block['main']['month']['lib'] = _MB_EXTCAL_PLANNING;


    $block['main']['month']['submenu']['planning1']['url'] = XOOPS_URL . "/modules/" . $moduleDirName . "/view_calendar-month.php";;
    $block['main']['month']['submenu']['planning1']['lib'] = _MB_EXTCAL_VIEW_MONTH;

    $block['main']['month']['submenu']['planning2']['url'] = XOOPS_URL . "/modules/" . $moduleDirName . "/view_month.php";
    $block['main']['month']['submenu']['planning2']['lib'] = _MB_EXTCAL_VIEW_MONTH_LIST;

    $block['main']['month']['submenu']['planning3']['url'] = XOOPS_URL . "/modules/" . $moduleDirName . "/view_week.php";
    $block['main']['month']['submenu']['planning3']['lib'] = _MB_EXTCAL_VIEW_WEEK_LIST;


    $block['main']['search']['url'] = XOOPS_URL . "/modules/" . $moduleDirName . "/view_search.php";
    $block['main']['search']['lib'] = _MB_EXTCAL_SEARCH_EVENT;

    $block['main']['location']['url'] = XOOPS_URL . "/modules/" . $moduleDirName . "/location-list.php";
    $block['main']['location']['lib'] = _MB_EXTCAL_LOCATIONS;



    $permHandler = Extcal\Perm::getHandler();
      if (count($permHandler->getAuthorizedCat($xoopsUser, 'extcal_cat_submit')) > 0) {
      $displayLink=0;
      $block['main']['submit']['url'] = XOOPS_URL . "/modules/" . $moduleDirName . "/view_new-event.php";
      $block['main']['submit']['lib'] = _MB_EXTCAL_SUBMIT_LINK;

      $block['main']['approve']['url'] = XOOPS_URL . "/modules/" . $moduleDirName . "/admin/event.php";
      $block['main']['approve']['lib'] = _MB_EXTCAL_APPROVE_EVENT;

    }

    $block['module']['nbMainMenu'] = count($block['main']);




    return $block;
}

/**
 * @param $options
 *
 * @return string
 */
function bExtcalCategoryMenuEdit($options)
{

}
