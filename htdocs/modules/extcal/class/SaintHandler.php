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

//Kraven 30
// defined('XOOPS_ROOT_PATH') || die('Restricted access');

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Class SaintHandler.
 */
class SaintHandler extends ExtcalPersistableObjectHandler
{
    /**
     * @param \XoopsDatabase|null $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        parent::__construct($db, 'extcal_saint', Saint::class, 'saint_id', 'saint_name');
//        echo "<hr>===>" . "construct SaintHandler" .  "<hr>";
    }


    public function getSaints($month, $day)
    {
    global $xoopsDB;

	   $sql = "SELECT GROUP_CONCAT(saint_name) as comaList"
          . " FROM " . $xoopsDB->prefix("extcal_saint")
          . " WHERE saint_month = {$month} AND saint_day = {$day}";
	   $rst = $xoopsDB->query($sql);

	   list($comaList) = $xoopsDB->fetchRow($rst);
	   $firstnames = str_replace(',', ', ', $comaList);

	   return $firstnames;
  }

    /**
     * @param      $saint_id
     * @param bool $skipPerm
     *
     * @return bool
     */
//     public function getSaint($month, $day, $asArray=false)
//     {
// global $xoopsDB;
//         //$user = $GLOBALS['xoopsUser'];
//         $id = ($month * 100) + $day;
//         $criteriaCompo = new \CriteriaCompo();
//         $criteriaCompo->add(new \Criteria('saint_id', $id));
// //         $criteriaCompo->add(new \Criteria('saint_month', $month));
// //         $criteriaCompo->add(new \Criteria('saint_day', $day));
//
//         $ret = $this->getObjects($criteriaCompo);
//
//         if (isset($ret[0])) {
//             if ($asArray){
//               $t = $ret[0]->toArray();
//               return $t;
//             }else{
//               return $ret[0];
//             }
//         }
//         return false;
//     }

    /**
     * @param \CriteriaElement $criteria
     * @param null             $fields
     * @param bool             $asObject
     * @param bool             $id_as_key
     *
     * @return array
     */


    public function getAllSaints($criteria = null, $asObject = false)
    {
        $rst = $this->getObjects($criteria, $asObject);
        if ($asObject) {
            return $rst;
        }

        return $this->objectToArray($rst);
    }


    /**
     * @param int             $month
     * @param int             $day
     * @param string          $DIRECTION
     * @param string          $BGCOLOR
     * @param int             $LOOP
     *
     * @return srting
     */

    public function getHTML($month, $day, $prefixe='', $attributsArray = null){
/*  exemple pour$options qui représente les attibuts de la balise marquee
$attributsArray = array(
'DIRECTION'=> 'left',
'BGCOLOR'=> '',
'LOOP'=> '-1',
'scrollamount'=> '3',
'truespeed'=> '60',
'vspace'=> '3px'
)

*/

    $t = array();
    foreach($attributsArray as $k=>$v){
      $t[] = "{$k}='{$v}'";
    }
    $attributs = implode(' ', $t);

    $saints = $this->getSaints($month, $day);
//    ext_echo($saint);
    //$name = $saint['saint_name'];
    $exp = (($prefixe != '') ? $prefixe . '&nbsp;' : '') . $saints ;
    $html = "<MARQUEE {$attributs}>{$exp}</MARQUEE>";

// echo  "<hr>{$name}<br>{$html}<hr>";
// exit;

    return $html;
    }

}
