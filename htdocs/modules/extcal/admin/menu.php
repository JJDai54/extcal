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

// require_once  dirname(__DIR__) . '/class/Helper.php';
//require_once  dirname(__DIR__) . '/include/common.php';

require_once dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = basename(dirname(__DIR__));
$module_handler  = xoops_gethandler('module');
$module          = $module_handler->getByDirname($moduleDirName);
$moduleId      = $module->mid();

$pathIcon32      = $module->getInfo('sysicons32');
$pathModuleAdmin = $module->getInfo('dirmoduleadmin');
//$pathLanguage    = $path . $pathModuleAdmin;


$moduleDirNameUpper = mb_strtoupper($moduleDirName);

// $extcalHelper = Extcal\Helper::getInstance();
// 
// $pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
// if (is_object($extcalHelper->getModule())) {
//     $pathModIcon32 = $extcalHelper->getModule()->getInfo('modicons32');
// }

$adminmenu[] = [
    'title' => _MI_EXTCAL_INDEX,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => _MI_EXTCAL_CATEGORY,
    'link'  => 'admin/cat.php',
    'icon'  => $pathIcon32 . '/category.png',
];

$adminmenu[] = [
    'title' => _MI_EXTCAL_EVENT,
    'link'  => 'admin/event.php',
    'icon'  => $pathIcon32 . '/event.png',
];
$adminmenu[] = [
    'title' => _MI_EXTCAL_LOCATIONS,
    'link'  => 'admin/location.php',
    'icon'  => $pathIcon32 . '/home.png',  //'icon'  => $pathModIcon32 . '/location.png',
];

//a virer quand les test seront termines
// $adminmenu[] = [
//     'title' => _MI_EXTCAL_PERMISSIONS,
//     'link'  => 'admin/permissions.php',
//     'icon'  => $pathIcon32 . '/permissions.png',
// ];

$adminmenu[] = [
    'title' => _MI_EXTCAL_PERMISSIONS,
    'menu'  => "re-permissions",
    'link'  => 'admin/permissions-v2.php',
    'icon'  => $pathIcon32 . '/permissions.png'
];


// Blocks Admin
// $adminmenu[] = [
//     'title' => _MI_EXTCAL_BLOCKS_ADMIN, //'Block/Group Admin'
//     //    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS'),
//     'link'  => 'admin/blocksadmin.php',
//     'icon'  => $pathIcon32 . '/block.png',
// ];

/*
if ($extcalHelper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => _MI_EXTCAL_ADMENU_MIGRATE,
        'link'  => 'admin/migrate.php',
        'icon'  => $pathIcon32 . '/database_go.png',
    ];
}
*/

$adminmenu[] = [
    'title' => _MI_EXTCAL_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];

//---modif JJDai
$adminmenu[] = [
    'title' => _MI_EXTCAL_PREFERENCE,
    'menu'  => "preferences",
    'link'  => "../system/admin.php?fct=preferences&op=showmod&mod={$moduleId}",
    'icon'  => $pathIcon32 . '/exec.png'
];


/*
$adminmenu[] = [
    'title' => _MI_EXTCAL_UPGRADE,
    'menu'  => "update",
    'link'  => "../system/admin.php?fct=modulesadmin&op=update&module={$moduleDirName}",
    'icon'  => $pathIcon32 . '/update.png'
];

$adminmenu[] = [
    'title' => _MI_EXTCAL_BLOCKS,
    'menu'  => "blocks",
    'link'  => "../system/admin.php?fct=blocksadmin&op=list&filter=1&selgen={$moduleId}&selmod=-2&selgrp=2&selvis=-1",
    'icon'  => $pathIcon32 . '/block.png'
];
*/


 //   'link'  => 'admin/permissions-new.php',

