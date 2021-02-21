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
 * @author              JJDai <http://xoops.kiolo.com>
 **/

//----------------------------------------------------
class Extcal_2_35
{
    //----------------------------------------------------

    /**
     * @param \XoopsModule $module
     * @param             $options
     */
    public function __construct(\XoopsModule $module, $options)
    {
        global $xoopsDB;

        $this->alterTable_event();
    }

    //----------------------------------------------------
    public function alterTable_event()
    {
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('extcal_event');

        $sql = <<<__sql__
ALTER TABLE `{$tbl}`
 CHANGE `event_location` `event_location` INT( 5 ) NOT NULL DEFAULT '0';
__sql__;

        $xoopsDB->queryF($sql);
    }

    //-----------------------------------------------------------------
}   // fin de la classe
