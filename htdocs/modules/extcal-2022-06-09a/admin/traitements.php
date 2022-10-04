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

  /*****************************************************
   *
   *****************************************************/
function build_requetes($binSql = 3){
global $xoopsDB, $modMedia, $xoopsModule, $xoopsModuleConfig;

  if (($binSql  && 1) != 0){
    $f = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar("dirname") . '/sql/requetes2uninstall.sql';
    executeSqlFile($f);
  }

  if (($binSql  && 2) != 0){
    $f = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar("dirname") . '/sql/requetes2install.sql';
    executeSqlFile($f);
  }

//jexit("Requetes=>execute");
  return true;
}
/***************************************************************************
*
*****************************************************************************/
function executeSqlFile($f){
global $xoopsDB;

  if (!is_readable($f)){return false;}

  $fp = fopen($f,'rb');
  $taille = filesize($f);
  $sql = fread($fp, $taille);
  fclose($fp);


  $sql = sprintf($sql, $xoopsDB->prefix());

  $t = explode(';', $sql);
  foreach ($t as $sql){
    $sql = trim($sql);
    //jecho($sql);
    if ($sql != ''){
      $xoopsDB->queryF($sql . ';');
    }
  }
//jexit;
  return true;

}


/**********************************************************
 *
 **********************************************************/


  switch ($op){
  case 'rebuild_requetes':
    build_requetes();
    $msg =  "reconstruction des requestes";
    break;

  default: //affichage des optiions de maintenance
    display_menu_tools();
  }
  $url = XOOPS_URL . "/modules/" . basename(dirname(__DIR__)) . "/admin/index.php";
  //echo $msg ."<br>";
  //echo $url  ."<br>";
  //exit ("ici");
  redirect_header($url, 3, "[{$op}]-" . $msg . ">= ok");
?>
