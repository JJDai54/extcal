<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Wfdownloads module
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package         wfdownload
 * @since           3.23
 * @author          Xoops Development Team
 */
// $moduleDirName      = basename(dirname(dirname(__DIR__)));
// $moduleDirNameUpper = mb_strtoupper($moduleDirName);

define('CO_EXTCAL_GDLIBSTATUS', 'GD library support: ');
define('CO_EXTCAL_GDLIBVERSION', 'GD Library version: ');
define('CO_EXTCAL_GDOFF', "<span style='font-weight: bold;'>Disabled</span> (No thumbnails available)");
define('CO_EXTCAL_GDON', "<span style='font-weight: bold;'>Enabled</span> (Thumbsnails available)");
define('CO_EXTCAL_IMAGEINFO', 'Server status');
define('CO_EXTCAL_MAXPOSTSIZE', 'Max post size permitted (post_max_size directive in php.ini): ');
define('CO_EXTCAL_MAXUPLOADSIZE', 'Max upload size permitted (upload_max_filesize directive in php.ini): ');
define('CO_EXTCAL_MEMORYLIMIT', 'Memory limit (memory_limit directive in php.ini): ');
define('CO_EXTCAL_METAVERSION', "<span style='font-weight: bold;'>Downloads meta version:</span> ");
define('CO_EXTCAL_OFF', "<span style='font-weight: bold;'>OFF</span>");
define('CO_EXTCAL_ON', "<span style='font-weight: bold;'>ON</span>");
define('CO_EXTCAL_SERVERPATH', 'Server path to XOOPS root: ');
define('CO_EXTCAL_SERVERUPLOADSTATUS', 'Server uploads status: ');
define('CO_EXTCAL_SPHPINI', "<span style='font-weight: bold;'>Information taken from PHP ini file:</span>");
define('CO_EXTCAL_UPLOADPATHDSC', 'Note. Upload path *MUST* contain the full server path of your upload folder.');

define('CO_EXTCAL_PRINT', "<span style='font-weight: bold;'>Print</span>");
define('CO_EXTCAL_PDF', "<span style='font-weight: bold;'>Create PDF</span>");

define('CO_EXTCAL_UPGRADEFAILED0', "Update failed - couldn't rename field '%s'");
define('CO_EXTCAL_UPGRADEFAILED1', "Update failed - couldn't add new fields");
define('CO_EXTCAL_UPGRADEFAILED2', "Update failed - couldn't rename table '%s'");
define('CO_EXTCAL_ERROR_COLUMN', 'Could not create column in database : %s');
define('CO_EXTCAL_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
define('CO_EXTCAL_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');
define('CO_EXTCAL_ERROR_TAG_REMOVAL', 'Could not remove tags from Tag Module');

define('CO_EXTCAL_FOLDERS_DELETED_OK', 'Upload Folders have been deleted');

// Error Msgs
define('CO_EXTCAL_ERROR_BAD_DEL_PATH', 'Could not delete %s directory');
define('CO_EXTCAL_ERROR_BAD_REMOVE', 'Could not delete %s');
define('CO_EXTCAL_ERROR_NO_PLUGIN', 'Could not load plugin');

//Help
define('CO_EXTCAL_DIRNAME', basename(dirname(dirname(__DIR__))));
define('CO_EXTCAL_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('CO_EXTCAL_BACK_2_ADMIN', 'Back to Administration of ');
define('CO_EXTCAL_OVERVIEW', 'Overview');

//define('CO_EXTCAL_HELP_DIR', __DIR__);

//help multi-page
define('CO_EXTCAL_DISCLAIMER', 'Disclaimer');
define('CO_EXTCAL_LICENSE', 'License');
define('CO_EXTCAL_SUPPORT', 'Support');

//Sample Data
define('CO_EXTCAL_ADD_SAMPLEDATA', 'Import Sample Data (will delete ALL current data)');
define('CO_EXTCAL_SAMPLEDATA_SUCCESS', 'Sample Date uploaded successfully');
define('CO_EXTCAL_SAVE_SAMPLEDATA', 'Export Tables to YAML');
define('CO_EXTCAL_SHOW_SAMPLE_BUTTON', 'Show Sample Button?');
define('CO_EXTCAL_SHOW_SAMPLE_BUTTON_DESC', 'If yes, the "Add Sample Data" button will be visible to the Admin. It is Yes as a default for first installation.');
define('CO_EXTCAL_EXPORT_SCHEMA', 'Export DB Schema to YAML');
define('CO_EXTCAL_EXPORT_SCHEMA_SUCCESS', 'Export DB Schema to YAML was a success');
define('CO_EXTCAL_EXPORT_SCHEMA_ERROR', 'ERROR: Export of DB Schema to YAML failed');

//letter choice
define('CO_EXTCAL_BROWSETOTOPIC', "<span style='font-weight: bold;'>Browse items alphabetically</span>");
define('CO_EXTCAL_OTHER', 'Other');
define('CO_EXTCAL_ALL', 'All');

// block defines
define('CO_EXTCAL_ACCESSRIGHTS', 'Access Rights');
define('CO_EXTCAL_ACTION', 'Action');
define('CO_EXTCAL_ACTIVERIGHTS', 'Active Rights');
define('CO_EXTCAL_BADMIN', 'Block Administration');
define('CO_EXTCAL_BLKDESC', 'Description');
define('CO_EXTCAL_CBCENTER', 'Center Middle');
define('CO_EXTCAL_CBLEFT', 'Center Left');
define('CO_EXTCAL_CBRIGHT', 'Center Right');
define('CO_EXTCAL_SBLEFT', 'Left');
define('CO_EXTCAL_SBRIGHT', 'Right');
define('CO_EXTCAL_SIDE', 'Alignment');
define('CO_EXTCAL_TITLE', 'Title');
define('CO_EXTCAL_VISIBLE', 'Visible');
define('CO_EXTCAL_VISIBLEIN', 'Visible In');
define('CO_EXTCAL_WEIGHT', 'Weight');

define('CO_EXTCAL_PERMISSIONS', 'Permissions');
define('CO_EXTCAL_BLOCKS', 'Blocks Admin');
define('CO_EXTCAL_BLOCKS_DESC', 'Blocks/Group Admin');

define('CO_EXTCAL_BLOCKS_MANAGMENT', 'Manage');
define('CO_EXTCAL_BLOCKS_ADDBLOCK', 'Add a new block');
define('CO_EXTCAL_BLOCKS_EDITBLOCK', 'Edit a block');
define('CO_EXTCAL_BLOCKS_CLONEBLOCK', 'Clone a block');

//myblocksadmin
define('CO_EXTCAL_AGDS', 'Admin Groups');
define('CO_EXTCAL_BCACHETIME', 'Cache Time');
define('CO_EXTCAL_BLOCKS_ADMIN', 'Blocks Admin');

//Template Admin
define('CO_EXTCAL_TPLSETS', 'Template Management');
define('CO_EXTCAL_GENERATE', 'Generate');
define('CO_EXTCAL_FILENAME', 'File Name');

//Menu
define('CO_EXTCAL_ADMENU_MIGRATE', 'Migrate');
define('CO_EXTCAL_FOLDER_YES', 'Folder "%s" exist');
define('CO_EXTCAL_FOLDER_NO', 'Folder "%s" does not exist. Create the specified folder with CHMOD 777.');
define('CO_EXTCAL_SHOW_DEV_TOOLS', 'Show Development Tools Button?');
define('CO_EXTCAL_SHOW_DEV_TOOLS_DESC', 'If yes, the "Migrate" Tab and other Development tools will be visible to the Admin.');


//Latest Version Check
define('CO_EXTCAL_NEW_VERSION', 'New Version: ');

