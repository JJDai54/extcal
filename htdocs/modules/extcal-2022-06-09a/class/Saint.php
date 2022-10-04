<?php

namespace XoopsModules\Extcal;

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

//JJDai
// defined('XOOPS_ROOT_PATH') || die('Restricted access');

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Class Saint.
 */
class Saint extends \XoopsObject
{
    public function __construct()
    {
        //Toutes les attributs de la table
        $this->initVar('saint_id', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('saint_month', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('saint_day', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('saint_name', XOBJ_DTYPE_TXTBOX, null, false);

//        echo "<hr>===>" . "construct Saint <===" .  "<hr>";
    }

}
