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
 
require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
// require_once  dirname(__DIR__) . '/class/form/extcalform.php';
require_once __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/header.php';
// require_once  dirname(__DIR__) . '/class/Utility.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

/** @var Extcal\Helper $extcalHelper */
$extcalHelper = Extcal\Helper::getInstance();

$gepeto = array_merge($_GET, $_POST);
//while (list($k, $v) = each($gepeto)) {
foreach ($gepeto as $k => $v) {
    ${$k} = $v;
}
if (!isset($op)) {
    $op = '';
}

if (!isset($permission)) $permission = 'extcal_perm_mask';
//$grpPerm =  (isset($gepeto['permission'] )) ? $gepeto['permission']  :'extcal_perm_mask';

// $t = print_r($gepeto,true);
// echo "<pre>{$t}</pre>";
// echo "permission = {$permission}<hr>";
//--------------------------------------------------------------------
// global $xoTheme;
// $xoTheme->addScript(_EXTCAL_URL. "/assets/js/permissions.js");



/**********************************************************
 *
 **********************************************************/
function ext_getCats(){    
global $module_id, $xoopsModule, $index_admin, $catHandler, $xoopsUser;

     $cats = $catHandler->getAllCat($xoopsUser, 'all');
     $tCats = array();
      foreach ($cats as $cat) {
          $tCats[$cat->getVar('cat_id')] = $cat->getVar('cat_name');
      }
     return $tCats;
}

/**********************************************************
 *
 **********************************************************/
function extcal_getPerm($perm_name){
global $module_id, $xoopsModule, $index_admin, $catHandler, $extcal_mid;
/** @var \XoopsModuleHandler $moduleHandler */
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname('extcal');
$extcal_mid = $module->getVar('mid');

  switch($perm_name){
      case 'extcal_cat_submit':
         $title_of_form = _AM_EXTCAL_SUBMIT_PERMISSION;
         $perm_desc     = _AM_EXTCAL_SUBMIT_PERMISSION_DESC;
         $tLib = ext_getCats();
         break;
         
      case 'extcal_cat_edit':
         $title_of_form = _AM_EXTCAL_EDIT_PERMISSION;
         $perm_desc     = _AM_EXTCAL_EDIT_PERMISSION_DESC;
         $tLib = ext_getCats();
         break;
        
      case 'extcal_cat_view':
         $title_of_form = _AM_EXTCAL_VIEW_PERMISSION;
         $perm_desc     = _AM_EXTCAL_VIEW_PERMISSION_DESC;
         $tLib = ext_getCats();
         break;
      
      case 'extcal_cat_autoapprove':
         $title_of_form = _AM_EXTCAL_AUTOAPPROVE_PERMISSION;
         $perm_desc     = _AM_EXTCAL_AUTOAPPROVE_PERMISSION_DESC;
         $tLib = ext_getCats();
         break;
     
      case 'extcal_perm_mask':
      default:
          $title_of_form = _AM_EXTCAL_PUBLIC_PERM_MASK_INFO;     // _AM_EXTCAL_GROUP_NAME
          $perm_desc     = _AM_EXTCAL_PUBLIC_PERM_MASK_INFO_DESC;
          $tLib = array(1 => _AM_EXTCAL_CAN_VIEW,
                        2 => _AM_EXTCAL_CAN_SUBMIT,      
                        4 => _AM_EXTCAL_AUTO_APPROVE,      
                        8 => _AM_EXTCAL_CAN_EDIT);      
                        
          break;
  
  }
  
// $t = print_r($tLib,true);
// echo "<pre>{$t}</pre>";
//--------------------------------------------------------------------
  
  $url = "admin/permissions-v2.php?permission={$perm_name}";

  $frmPerm = new XoopsGroupPermForm($title_of_form, $extcal_mid, $perm_name, $perm_desc, $url, true);
  foreach($tLib as $key => $val) {
    $frmPerm->addItem($key, $val, 0);
  }
  return $frmPerm;
}

////////////////////////////////////////////////////////////////////////////////

       xoops_cp_header();
       $adminObject = \Xmf\Module\Admin::getInstance();
       $adminObject->displayNavigation(basename(__FILE__));
      //-------------------------------
      //liste déroulante de lection du groupe de permissions        
      xoops_load('XoopsFormLoader');
      $permTableForm = new XoopsSimpleForm('', 'fselperm', "permissions-v2.php", 'post');
      $formSelect    = new XoopsFormSelect('', 'permission', $permission);
      $formSelect->setExtra('onchange="document.fselperm.submit()"');
          $formSelect->addOption('extcal_perm_mask', _AM_EXTCAL_PUBLIC_PERM_MASK);
          $formSelect->addOption('extcal_cat_submit', _AM_EXTCAL_SUBMIT_PERMISSION);
          $formSelect->addOption('extcal_cat_edit', _AM_EXTCAL_EDIT_PERMISSION_DESC);
          $formSelect->addOption('extcal_cat_view', _AM_EXTCAL_VIEW_PERMISSION_DESC);
          $formSelect->addOption('extcal_cat_autoapprove', _AM_EXTCAL_AUTOAPPROVE_PERMISSION_DESC);
          //$formSelect->setExtra('onmousedown="gotoPErmission("togodo")');
              
      $permTableForm->addElement($formSelect);
      echo    $permTableForm->render();
      //-------------------------------

     //echo $index_admin->addNavigation('rights');
    $perm =  extcal_getPerm($permission) ;
    echo $perm->render();
    xoops_cp_footer();


?>
