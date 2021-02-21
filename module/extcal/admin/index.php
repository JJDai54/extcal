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
use XoopsModules\Extcal\Common;

require_once __DIR__ . '/admin_header.php';
// Display Admin header
xoops_cp_header();
/** @var Extcal\Utility $utility */

//$configurator = require_once dirname(__DIR__) . '/include/config.php';

$configurator = new Common\Configurator();

//foreach (array_keys($configurator['uploadFolders']) as $i) {
//    $utility::createFolder($configurator['uploadFolders'][$i]);
//    $adminObject->addConfigBoxLine($configurator['uploadFolders'][$i], 'folder');
//    //    $adminObject->addConfigBoxLine(array($configurator['uploadFolders'][$i], '777'), 'chmod');
//}


/**********************************************************
 *
 **********************************************************/
function display_traitements(){
global $adminObject;

    $boxName = "Traitements";
    $adminObject->addInfoBox($boxName);

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

    );

    foreach ($traitements as $t){
      if (isset($t['op'])){
        $url = "<a href='traitements.php?op={$t['op']}{$t['params']}'>{$t['caption']}</a>";
        $adminObject->addInfoBoxLine($url, '', '', 'information');
      }else{
        $adminObject->addInfoBoxLine('', '', '', '');
        $adminObject->addInfoBoxLine($t['caption'], '', '', '');
      }
    }


}




$adminObject->displayNavigation(basename(__FILE__));

display_traitements();

//check for latest release
$newRelease = $utility::checkVerModule($helper);
if (!empty($newRelease)) {
    $adminObject->addItemButton($newRelease[0], $newRelease[1], 'download', 'style="color : Red"');
}

//------------- Test Data ----------------------------
/*
if ($helper->getConfig('displaySampleButton')) {
    xoops_loadLanguage('admin/modulesadmin', 'system');
    require_once dirname(__DIR__) . '/testdata/index.php';

    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=load', 'add');

    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=save', 'add');

    //    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA'), '__DIR__ . /../../testdata/index.php?op=exportschema', 'add');

    $adminObject->displayButton('left', '');
}
*/

//------------- End Test Data ----------------------------

$adminObject->displayIndex();

echo $utility::getServerStats();

//codeDump(__FILE__);
require_once __DIR__ . '/admin_footer.php';
