<?php
/**
 * extcal module.
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright           XOOPS Project (https://xoops.org)
 * @license             http://www.fsf.org/copyleft/gpl.html GNU public license
 *
 * @since               2.2
 *
 * @author              JJDai <https://xoops.kiolo.fr>
 **/

//----------------------------------------------------
class Extcal_2_60
{
    //----------------------------------------------------

    /***********************************************
     * @param \XoopsModule $module
     * @param             $options
     **********************************************/
    public function __construct(\XoopsModule $module, $options)
    {
        global $xoopsDB;

        $this->alterTable_location();
        $this->alterTable_event();
//         $this->alterTable_categorie();

    }

/**************************************************
 *
 **************************************************/
    public function alterTable_location()
    {
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('extcal_location');

$sql = <<<__sql__
ALTER TABLE {$tbl} CHANGE `id` `location_id` INT(5) NOT NULL AUTO_INCREMENT;
__sql__;

        $xoopsDB->queryF($sql);
    }

/**************************************************
 *
 **************************************************/
    public function alterTable_event()
    {
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('extcal_event');

$sql = <<<__sql__
ALTER TABLE {$tbl} CHANGE `event_location` `location_id` INT(5) NOT NULL DEFAULT '0' AFTER `cat_id`;
__sql__;

        $xoopsDB->queryF($sql);
    }

/**************************************************
 *
 * ALTER TABLE `x251_extcal_cat` ADD `cat_pid` INT(8) NOT NULL DEFAULT '0' AFTER `cat_id`, ADD INDEX `cat_pid` (`cat_pid`);
 **************************************************/
    public function alterTable_categorie()
    {
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('extcal_cat');

$sql = <<<__sql__
ADD `cat_pid` INT(8) NOT NULL DEFAULT '0' AFTER `cat_id`,
ADD INDEX `cat_pid` (`cat_pid`);
__sql__;

        $xoopsDB->queryF($sql);
    }
/**************************************************
 *
 **************************************************/
//     public function alterTable_categorie()
//     {
//         global $xoopsDB;
//         $tbl = $xoopsDB->prefix('extcal_cat');
//
// $sql = <<<__sql__
// ALTER TABLE {$tbl} ADD cat_actif TINYINT NOT NULL DEFAULT '1' AFTER cat_icone;
// __sql__;
//
//         $xoopsDB->queryF($sql);
//     }
    //-----------------------------------------------------------------
}   // fin de la classe
