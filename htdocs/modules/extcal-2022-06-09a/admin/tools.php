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

//include_once("../../../mainfile.php");
include_once("admin_header.php");

use Xmf\Request;
use XoopsModules\Extcal;

global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
// $tr = print_r($xoopsModule->modinfo['xtbl'],true);
// echo ">>>xtables<pre>{$tr}</pre>";
//////////////////////////////////////////////////////////////


$dirname = dirname(__FILE__);
//echo XOOPS_ROOT_PATH . "<br>";
include_once(XOOPS_ROOT_PATH . "/Frameworks/moduleclasses/moduleadmin/moduleadmin.php");
                               
//include_once XOOPS_ROOT_PATH."/modules/" . $dirname . "/class/menu.php";
//-------------------------------------------------------------------
//$p = array_merge($_POST, $_GET);

$op = Request::getString('op', '');

/**********************************************************
 *
 **********************************************************/
function display_menu_traitements(){

    $index_admin = new ModuleAdmin();
    $boxName = "Traitements";
    $index_admin->addInfoBox($boxName);

    $traitements = array(
      array('caption'=>'Global:'),
      array('op'=>'rebuild_requetes',           'params'=>'', 'caption'=>'Reconstruction des requêtes de la base')

//         array('caption'=>'Reset Caches:'),
//         array('op'=>'Reset_Caches',              'params'=>'&domaine=media', 'caption'=>'Supression des de tous les caches des médias'),
//         array('op'=>'Reset_Caches',              'params'=>'&domaine=entite', 'caption'=>'Supression des de tous les caches des entités'),
//
//         array('caption'=>'Build Caches:'),
//         array('op'=>'Build_Caches',              'params'=>'&limit=1&start=0&sleep=5&domaine=media&sousDomaine=255', 'caption'=>'construction des tous les caches pour chaque média'),
//         array('op'=>'Build_Caches',              'params'=>'&limit=1&start=0&sleep=5&domaine=entite&sousDomaine=255', 'caption'=>'construction des tous les caches pour chaque entité'),

    );J:\Origami\_Associations\Pli'Art\Site-WEB\modules\extcal\admin\tools.php

    foreach ($traitements as $t){
      if (isset($t['op'])){
        $url = "<a href='traitements.php?op={$t['op']}{$t['params']}'>{$t['caption']}</a>";
        $index_admin->addInfoBoxLine($boxName, $url, '', '', 'information');
      }else{
        $index_admin->addInfoBoxLine($boxName, '', '', '', '');
        $index_admin->addInfoBoxLine($boxName, $t['caption'], '', '', '');
      }
    }

    echo $index_admin->renderButton('right', '');
    //echo $index_admin->renderInfoBox();
    echo $index_admin->renderIndex();
    xoops_cp_footer();
}


/**********************************************************
 *
 **********************************************************/



  switch ($op){
  case 'build_request':
    echo "reconstruction des requestes";
    break;

  default: //affichage des optiions de maintenance
    display_menu_tools();
  }


?>
