<?php
/**
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package
 * @since           2.5.9
 * @author          Michael Beck (aka Mamba)
 */

use XoopsModules\Extcal;
use XoopsModules\Extcal\Common;

require dirname(dirname(dirname(__DIR__))) . '/mainfile.php';
include dirname(__DIR__) . '/preloads/autoloader.php';
$op = \Xmf\Request::getCmd('op', '');

switch ($op) {
    case 'load':
        loadSampleData();
        break;
    case 'save':
        saveSampleData();
        break;
}

// XMF TableLoad for SAMPLE data

function loadSampleData()
{global $extcalHelper;
    $moduleDirName = basename(dirname(__DIR__));
    $utility       = new Extcal\Utility();
    $configurator  = new Common\Configurator();
    // Load language files
    $extcalHelper->loadLanguage('admin');
    $extcalHelper->loadLanguage('modinfo');
    $extcalHelper->loadLanguage('common');

    //    $items = \Xmf\Yaml::readWrapped('quotes_data.yml');
    //    \Xmf\Database\TableLoad::truncateTable($moduleDirName . '_quotes');
    //    \Xmf\Database\TableLoad::loadTableFromArray($moduleDirName . '_quotes', $items);

    $tables = \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getInfo('tables');

    foreach ($tables as $table) {
        $tabledata = \Xmf\Yaml::readWrapped($table . '.yml');
        \Xmf\Database\TableLoad::truncateTable($table);
        \Xmf\Database\TableLoad::loadTableFromArray($table, $tabledata);
    }

    //  ---  COPY test folder files ---------------
    if ($configurator->copyTestFolders && is_array($configurator->copyTestFolders)) {
        //        $file = __DIR__ . '/../testdata/images/';
        foreach (array_keys($configurator->copyTestFolders) as $i) {
            $src  = $configurator->copyTestFolders[$i][0];
            $dest = $configurator->copyTestFolders[$i][1];
            $utility::rcopy($src, $dest);
        }
    }

    redirect_header('../admin/index.php', 1, constant('_CO_' . $moduleDirNameUpper . '_' . 'SAMPLEDATA_SUCCESS'));
}

function saveSampleData()
{
    $moduleDirName      = basename(dirname(__DIR__));
    $moduleDirNameUpper = mb_strtoupper($moduleDirName);

    $tables = \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getInfo('tables');

    foreach ($tables as $table) {
        \Xmf\Database\TableLoad::saveTableToYamlFile($table, $table . '_' . date('Y-m-d H-i-s') . '.yml');
    }

    redirect_header('../admin/index.php', 1, constant('_CO_' . $moduleDirNameUpper . '_' . 'SAMPLEDATA_SUCCESS'));
}

function exportSchema()
{
    try {
        $moduleDirName      = basename(dirname(__DIR__));
        $moduleDirNameUpper = mb_strtoupper($moduleDirName);

        $migrate = new  \Xmf\Database\Migrate($moduleDirName);
        $migrate->saveCurrentSchema();

        redirect_header('../admin/index.php', 1, constant('_CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_SUCCESS'));
    }
    catch (\Exception $e) {
        exit(constant('_CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_ERROR'));
    }
}
