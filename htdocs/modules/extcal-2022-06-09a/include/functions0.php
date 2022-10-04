<?php
/**
 * classGenerator
 * walls_watermarks.
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *
 *
 * L'utilisation de ce formulaire d'adminitration suppose
 * que la classe correspondante de la table a été générées avec classGenerator
 **/

use XoopsModules\Extcal;

require_once XOOPS_ROOT_PATH . '/class/uploader.php';


/*****************************************************************/
    /*******************************************************************
     *
     ******************************************************************
     * @param $date time stamp
     */
    function parseDate($v)
    {

          // Initialize detail date
          $td['year']    = intval(date('Y', $v));
          $td['month']   = intval(date('n', $v));
          $td['day']     = intval(date('j', $v));
          $td['hour']    = intval(date('H', $v));
          $td['minute']  = intval(date('i', $v));

            return $td;

    }
    /*******************************************************************
     *
     ******************************************************************
     * @param $date time stamp
     */
    function ts2Date($v)
    {
        $td = parseDate($v);
        $d = mktime(0, 0, 0, $td['month'], $td['day'], $td['year']);
        return $d;

    }
    
    /*******************************************************************
     *
     ******************************************************************
     * @param $date time stamp
     */
    function strDate($v, $formatDate='d-m-y : H-i')
    {
        return date($formatDate, $v);
    }
    
/**
 * @param        $exp
 * @param string $msg
 */
function ext_cat_echo($cat)
{
    if (is_array($cat)){
        echo "<br>===>ext_cat_echo : cat est un tableau<br>";
        ext_echo($cat);
    }elseif(is_string($cat)){
        echo "<br>===>ext_cat_echo : cat est une chaine ===> cat : {$cat}<br>";        
    }elseif(is_integer($cat)){
        echo "<br>===>ext_cat_echo : cat est une entier  ===> cat : {$cat}<br>";        
    }else{
        echo "<br>===>ext_cat_echo : cat a voir<br>";        
    }
}


/**
 * @param        $exp
 * @param string $msg
 */
function ext_echo($exp, $Title = '', $addHR = false, $bExit = false)
{
if ($addHR) echo "<hr>===> BEGIN<br>";

    if ($Title != '' ) echo "{$Title}<br>";

    if (is_array($exp)){
//      if ('' != $msg) echo "<hr>===>{$msg}<hr>";
      $txt = print_r($exp, true);
      echo '<pre>Number of items: ' . count($exp) . "<br>{$txt}</pre>";
    }
    elseif (is_object($exp)){
      echo "===>liste des methode de la classe";
      $tf =  get_class_methods ($exp );
      ext_echo ($tf);
      echo "===>liste des proprietes de la classe";
      $tf =  get_object_vars ($exp );
      ext_echo ($tf);
    }
    else{
          echo "===>{$exp}<br>";
    }
    //-----------------------------------------------
    if ($addHR) echo "===> END<hr>";
    if ($bExit) exit();
}
/***
 *
 ***/
    function clear_unicodeslashes($text)
    {
        $text = str_replace(["\\'"], "'", $text);
        $text = str_replace(["\\\\\\'"], "'", $text);
        $text = str_replace(['\\"'], '"', $text);

        return $text;
    }


/***
 *
 ***/
/*---------------------------------------------------------------*/
/*
    Titre : Redimensionner une image

    URL   : https://phpsources.net/code_s.php?id=81
    Auteur           : midi20
    Date édition     : 11 Oct 2004
*/
/*---------------------------------------------------------------*/
    function ext_redim_img($chemin, $width=400, $height=0, $fldDest="thumbs")
    {
      $dest = dirname($chemin) . "/" . $fldDest . "/" . basename($chemin);
      unlink ($dest);
//       echo $chemin . "<br>";
//       echo $dest . "<br>";
      $img_new = imagecreatefromjpeg($chemin);

      $size = getimagesize($chemin);
      $x = $width;
      $y = $size[1] / $size[0] * $width;//$height;
      if ($y >=height && $height > 0){
        $y = $height;
        $x = $size[2] / $size[1] * $height;
      }

      $img_mini = imagecreatetruecolor ($x, $y);
      imagecopyresampled ($img_mini,$img_new,0,0,0,0,$x,$y,$size[0],$size[1]);
      imagejpeg($img_mini, $dest);
//exit;
    }

/**
 * @param $eventId
 *
 * @return array
 */
function extcal_getEvent($eventId)
{
    $eventHandler = Extcal\Helper::getInstance()->getHandler(_EXTCAL_CLN_EVENT);
    $event        = $eventHandler->getEvent($eventId);
    $t            = $event->getVars();
    $data         = [];
    //    while (list($key, $val) = each($t)) {
    foreach ($t as $key => $val) {
        $data[$key] = $val['value'];
    }

    return $data;
}

/**
 * @param $REQUEST
 * @param $event_picture1
 * @param $event_picture2
 */
function extcal_loadImg(&$REQUEST, &$event_picture1, &$event_picture2)
{
    ///////////////////////////////////////////////////////////////////////////////
    $uploaddir_event = XOOPS_ROOT_PATH . '/uploads/extcal/';
    $uploadurl_event = XOOPS_URL . '/uploads/extcal/';
    //$picture = '';
    for ($j = 1; $j < 3; ++$j) {
        $delimg = @$REQUEST['delimg_' . $j . ''];
        $delimg = isset($delimg) ? (int)$delimg : 0;
        if (0 == $delimg && !empty($REQUEST['xoops_upload_file'][$j])) {
            $upload = new \XoopsMediaUploader($uploaddir_event, [
                'image/gif',
                'image/jpeg',
                'image/pjpeg',
                'image/x-png',
                'image/png',
                'image/jpg',
            ], 3145728, null, null);
            if ($upload->fetchMedia($REQUEST['xoops_upload_file'][$j])) {
                $upload->setPrefix('event_');
                $upload->fetchMedia($REQUEST['xoops_upload_file'][$j]);
                if (!$upload->upload()) {
                    $errors = $upload->getErrors();
                    redirect_header('javascript:history.go(-1)', 3, $errors);
                } else {
                    if (1 == $j) {
                        $event_picture1 = $upload->getSavedFileName();
                    } elseif (2 == $j) {
                        $event_picture2 = $upload->getSavedFileName();
                    }
                }
            } elseif (!empty($REQUEST['file' . $j])) {
                if (1 == $j) {
                    $event_picture1 = $REQUEST['file' . $j];
                } elseif (2 == $j) {
                    $event_picture2 = $REQUEST['file' . $j];
                }
            }
        } else {
            $url_event = XOOPS_ROOT_PATH . '/uploads/extcal/' . $REQUEST['file' . $j];
            if (1 == $j) {
                $event_picture1 = '';
            } elseif (2 == $j) {
                $event_picture2 = '';
            }
            if (is_file($url_event)) {
                chmod($url_event, 0777);
                unlink($url_event);
            }
        }
    }
    //exit;
    ///////////////////////////////////////////////////////////////////////////////
}

/*******************************************************************
 *
 ******************************************************************
 * @param        $cat
 * @param bool   $addNone
 * @param string $name
 * @return XoopsFormSelect
 */
//function getXoopsFormSelectCategories($cat, $addNone = true, $name = 'cat')
function getXoopsFormSelectCategories($cat, $addNone = 'Toutes les catégories', $name = 'cat')
{
    global $xoopsUser;
    // Category selectbox
    $catHandler = Extcal\Helper::getInstance()->getHandler(_EXTCAL_CLN_CAT);

    $catsList  = $catHandler->getAllCat($xoopsUser);
    $catSelect = new \XoopsFormSelect('', $name, $cat);
    if ($addNone != '') {
        $catSelect->addOption(0, $addNone);
    }

    foreach ($catsList as $catList) {
        $catSelect->addOption($catList->getVar('cat_id'), $catList->getVar('cat_name'));
    }

    return $catSelect;
}
/*******************************************************************
 *
 ******************************************************************
 * @param        $location_id
 * @param bool   $addNone
 * @param string $name
 * @return XoopsFormSelect
 */

function getListLocations($location_id, $addNone = ' ', $name = 'location_id')
{
    global $xoopsUser;
    // Category selectbox
    $locationHandler = Extcal\Helper::getInstance()->getHandler(_EXTCAL_CLN_LOCATION);

    $locationsList  = $locationHandler->getAll($xoopsUser);
    $locationSelect = new \XoopsFormSelect('', $name, $location_id);
    if ($addNone != '') {
        $catSelect->addOption(0, $addNone);
    }

    foreach ($locationsList as $location) {
        $locationSelect->addOption($location->getVar('location_id'), $location->getVar('nom'));
    }

    return $locationSelect;
}

/***********************
 *
 **********************/
function getListApproved($approved, $addAll = _ALL, $name = 'approved')
{
    global $xoopsUser;
    // Category selectbox


    $approvedSelect = new \XoopsFormSelect('', $name, $approved);
    if ($addAll != '') {
        $approvedSelect->addOption(-1, $addAll);
    }
    $approvedSelect->addOption("0", _AM_EXTCAL_EVENT_SUBMITED);
    $approvedSelect->addOption("1", _AM_EXTCAL_EVENT_APPROVED);

    return $approvedSelect;
}

/*******************************************************************
 *
 ******************************************************************
 * @param string $name
 * @param        $cat
 * @return array
 */
function getCheckeCategories($name = 'cat', $cat)
{
    global $xoopsUser;
    // Category selectbox
    //<option style="background-color:#00FFFF;">VARCHAR</option>

    $catHandler = Extcal\Helper::getInstance()->getHandler(_EXTCAL_CLN_CAT);
    $catsList   = $catHandler->getAllCat($xoopsUser);

    $t = [];
    foreach ($catsList as $catList) {
        $cat_id    = $catList->getVar('cat_id');
        $name      = $catList->getVar('cat_name');
        $cat_color = $catList->getVar('cat_color');
        $checked   = in_array($cat_id, $cat, true) ? 'checked' : '';
        $cat       = ''
                     . "<div style='float:left; margin-left:5px;'>"
                     . "<input type='checkbox' name='{$name}[{$cat_id}]' value='1' {$checked}>"
                     . "<div style='absolute:left;height:12px; width:6px; background-color:#{$cat_color}; border:1px solid black; float:left; margin-right:5px;' ></div>"
                     . " {$name}"
                     . '</div>';

        $t[] = $cat;
    }

    return $t;
}

/*******************************************************************
 *
 ******************************************************************
 * @param string $name
 * @param string $caption
 * @param        $defaut
 * @param bool   $addNone
 * @return XoopsFormSelect
 */
function getListOrderBy($name = 'orderby', $caption = '', $defaut, $addNone = false)
{
    global $xoopsUser;

    $select = new \XoopsFormSelect($caption, $name, $defaut);
    if ($addNone) {
        $select->addOption('', '');
    }

    $select->addOption('year ASC', _MD_EXTCAL_YEAR . ' ' . _MD_EXTCAL_ORDER_BY_ASC);
    $select->addOption('year DESC', _MD_EXTCAL_YEAR . ' ' . _MD_EXTCAL_ORDER_BY_DESC);

    $select->addOption('month ASC', _MD_EXTCAL_MONTH . ' ' . _MD_EXTCAL_ORDER_BY_ASC);
    $select->addOption('month DESC', _MD_EXTCAL_MONTH . ' ' . _MD_EXTCAL_ORDER_BY_DESC);

    $select->addOption('event_title ASC', _MD_EXTCAL_ALPHA . ' ' . _MD_EXTCAL_ORDER_BY_ASC);
    $select->addOption('event_title DESC', _MD_EXTCAL_ALPHA . ' ' . _MD_EXTCAL_ORDER_BY_DESC);

    $select->addOption('cat_name ASC', _MD_EXTCAL_CATEGORY . ' ' . _MD_EXTCAL_ORDER_BY_ASC);
    $select->addOption('cat_name DESC', _MD_EXTCAL_CATEGORY . ' ' . _MD_EXTCAL_ORDER_BY_DESC);

    return $select;
}

/*******************************************************************
 *
 ******************************************************************
 * @param string $name
 * @param string $caption
 * @param        $defaut
 * @return XoopsFormSelect
 */
function getListAndOr($name = 'andor', $caption = '', $defaut)
{
    global $xoopsUser;

    $select = new \XoopsFormSelect($caption, $name, $defaut);

    $select->addOption('AND', _MD_EXTCAL_AND);
    $select->addOption('OR', _MD_EXTCAL_OR);

    return $select;
}

/*******************************************************************
 *
 ******************************************************************
 * @param        $name
 * @param        $caption
 * @param        $defaut
 * @param        $options
 * @param string $sep
 * @return XoopsFormSelect
 */
function getList($name, $caption, $defaut, $options, $sep = ';')
{
    global $xoopsUser;

    $select = new \XoopsFormSelect($caption, $name, $defaut);
    if (!is_array($options)) {
        $options = explode($sep, $options);
    }

    for ($h = 0, $count = count($options); $h < $count; ++$h) {
        $select->addOption($h, $options[$h]);
    }

    return $select;
}

/*******************************************************************
 *
 ******************************************************************
 * @param        $ts
 * @param        $startMonth
 * @param        $endMonth
 * @param string $mode
 * @return DateTime
 */
function getDateBetweenDates($ts, $startMonth, $endMonth, $mode = 'w')
{
    $d = new \DateTime($periodStart);
    $d->setTimestamp($ts);

    //echo "<br>affichage des periodes : <br>";
    $begin = new \DateTime();
    $begin->setTimestamp($startMonth);
    //echo $begin->format("d/m/Y à H\hi:s").'<br>'; // 03/10/2007 à 19h39:53

    $end = new \DateTime();
    $end->setTimestamp($endMonth);
    //echo $end->format("d/m/Y à H\hi:s").'<br>'; // 03/10/2007 à 19h39:53
    //echo "<hr>";
    $interval = DateInterval::createFromDateString('next sunday');
    $period   = new DatePeriod($begin, $interval, $end);
    //echoDateArray($period);

    //echo "<hr>{$interval}";
    return $d;
    //echo mktime($heure, $minute, $seconde, $mois, $jour, $an);

    //
    //   $jour = date('d', $ts);
    //   $mois = date('m', $ts);
    //   $an = date('Y', $ts);
    //   $heure = date('H', $ts);
    //   $minute = date('i', $ts);
    //   $seconde = date('s', $ts);
    //   $d->setDate($heure,$minute,$seconde,$mois,$jour,$an);

    // <?php
    // $interval = DateInterval::createFromDateString('next sunday');
    // $period = new DatePeriod($begin, $interval, $end);
    // foreach ($period as $dt) {
    //   echo $dt->format( "l Y-m-d H:i:s\n" );
}

/*
Sunday 2009-11-01 00:00:00
Sunday 2009-11-08 00:00:00
Sunday 2009-11-15 00:00:00
Sunday 2009-11-22 00:00:00
Sunday 2009-11-29 00:00:00
Sunday 2009-12-06 00:00:00
...
*/
/**
 * @param $period
 */
function echoDateArray($period)
{
    foreach ($period as $dt) {
        echo $dt->format("l Y-m-d H:i:s\n") . '<br>';
    }
}


/*****************************************************************/
/**
 * @param        $tsName
 * @param string $msg
 */
function ext_echoTSN($tsName, $msg = '')
{
    global $$tsName;
    $ts = $$tsName;
    ext_echoTSU($ts, $tsName, $msg = '');
}

/*****************************************************************/
/**
 * @param        $ts
 * @param        $tsName
 * @param string $msg
 */
function ext_echoTSU($ts, $tsName, $msg = '')
{
    if ('' != $msg) {
        echo "<hr>{$msg}<hr>";
    }

    echo 'date --->' . $tsName . ' = ' . $ts . ' - ' . date('d-m-Y H:m:s', $ts) . '<br>';
}


/*****************************************************************/
/**
 * @param        $date
 * @param string $sep
 *
 * @return int
 */
function ext_convert_date($date, $sep = '-')
{
    $lstSep = '/ .';

    for ($h = 0, $count = mb_strlen($lstSep); $h < $count; ++$h) {
        $sep2replace = mb_substr($lstSep, $h, 1);
        if (mb_strpos($date, $sep2replace)) {
            $date = str_replace($sep2replace, $sep, $date);
        }

        return strtotime($date);
    }
}

/**
 * @param     $givendate
 * @param int $day
 * @param int $mth
 * @param int $yr
 *
 * @return int
 */
function ext_DateAdd($givendate, $day = 0, $mth = 0, $yr = 0)
{
    //$cd = strtotime($givendate);
    $cd      = $givendate;
    $newdate = date('Y-m-d h:i:s', mktime(date('h', $cd), date('i', $cd), date('s', $cd), date('m', $cd) + $mth, date('d', $cd) + $day, date('Y', $cd) + $yr));

    return strtotime($newdate);
}

/**
 * @param $date
 * @param $number
 * @param $interval
 *
 * @return int
 */
function ext_DateAdd2($date, $number, $interval = 'd')
{
    $date_time_array = getdate($date);
    $hours           = $date_time_array['hours'];
    $minutes         = $date_time_array['minutes'];
    $seconds         = $date_time_array['seconds'];
    $month           = $date_time_array['mon'];
    $day             = $date_time_array['mday'];
    $year            = $date_time_array['year'];

    switch ($interval) {
        case 'yyyy':
            $year += $number;
            break;
        case 'q':
            $year += ($number * 3);
            break;
        case 'm':
            $month += $number;
            break;
        case 'y':
        case 'd':
        case 'w':
            $day += $number;
            break;
        case 'ww':
            $day += ($number * 7);
            break;
        case 'h':
            $hours += $number;
            break;
        case 'n':
            $minutes += $number;
            break;
        case 's':
            $seconds += $number;
            break;
    }
    $timestamp = mktime($hours, $minutes, $seconds, $month, $day, $year);

    return $timestamp;
}

// function date_diff($date1, $date2) {
//     $current = $date1;
//     $datetime2 = date_create($date2);
//     $count = 0;
//     while (date_create($current) < $datetime2) {
//         $current = gmdate("Y-m-d", strtotime("+1 day", strtotime($current)));
//         ++$count;
//     }
//     return $count;
// }

/**************************************************************************/
/**
 * @param $color
 * @param $plancher
 * @param $plafond
 *
 * @return string
 */
function eclaircirCouleur($color, $plancher, $plafond)
{
    //    // require_once  dirname(__DIR__) . '/class/ColorTools.php';

    //$ct = new ColorTools();
    //return $ct->eclaircir($color,$plancher,$plafond);
    return Extcal\ColorTools::eclaircir($color, $plancher, $plafond);
}
/**************************************************************************/
/**
 * @param $name
 * @param $text
 * @param $row
 *
 * @return editorbject
 */
function getEditor($caption, $name, $text, $row = 5)
{
global $helper, $xoopsUser, $xoopsModule;

        $isAdmin = false;
        if (is_object($xoopsUser)) {
            $isAdmin = $xoopsUser->isAdmin($xoopsModule->getVar('mid'));
        }
        // Description
        if (class_exists('XoopsFormEditor')) {
            $options['name']   = $name;
            $options['value']  = $text;
            $options['rows']   = $row;
            $options['cols']   = '100%';
            $options['width']  = '100%';
            $options['height'] = '200px';
            if ($isAdmin) {
                $descEditor = new \XoopsFormEditor($caption, $helper->getConfig('editorAdmin'), $options, $nohtml = false, $onfailure = 'textarea');
            } else {
                $descEditor = new \XoopsFormEditor($caption, $helper->getConfig('editorUser'), $options, $nohtml = false, $onfailure = 'textarea');
            }
        } else {
            $descEditor = new \XoopsFormDhtmlTextArea($caption, $name, $text, '100%', '100%');
        }

        return $descEditor;

}

/***
 *
 ***/

function ext_include_highslide(){
global $xoTheme, $xoopsModuleConfig;
    $xoTheme->addScript(XOOPS_URL . '/modules/extcal/assets/js/xoops_highslide.js');
    
    $highslide = XOOPS_URL . "/Frameworks/" . $xoopsModuleConfig['highslide'];
    $xoTheme->addStylesheet($highslide . '/highslide.css');
    $xoTheme->addScript($highslide     . '/highslide.js');
    
    //echo "===>xoops_highslide<hr>" . XOOPS_URL . '/modules/extcal/assets/js/xoops_highslide.js' . "<hr>";
  if (!is_array($options))$options = array();
  $options['graphicsDir'] = "{$highslide}/graphics/";
  ext_array2js('hs', $options, false, true);

}
/*
    function ext_include_highslide()
    {global $xoTheme;
      $xoTheme->addScript(_EXTCAL_HIGHSLIDE . '/highslide.js');
      $xoTheme->addScript(_EXTCAL_HIGHSLIDE . '/xoops_highslide.js');
      $xoTheme->addStylesheet(_EXTCAL_HIGHSLIDE .'/highslide.css');
    }
    /modules/extcal/assets/js/xoops_highslide.js
            \extcal\assets\js/xoops_highslide.js
    
    
*/
/****************************************************************************
Genere la declaration d'un tableau en javascript
$name : nom du ta&bleau javascript
$options : tableau associatif. les clefs seront les m^me en javascript
$bolEcho : si true envoie directement la chaine générée dans le flus html
retour : string a envoyer dans le flus html
note : la balise script est ajoutée automatiquement
 ****************************************************************************/
function ext_array2js($name, $options, $isNew = false, $bolEcho = false){

  $t = array();
  $t[] = "\n<script type='text/javascript'>"; 
  
  if ($isNew){
    $t[] = "{$name} = new Array()"; 
  }
  
  foreach($options as $key=>$value){
    if (is_numeric($value)){
      $t[] = "{$name}.{$key} = {$value};"; 
    }else{
      $t[] = "{$name}.{$key} = '{$value}';"; 
    }
  }
  
  $t[] = "</script>\n"; 
  
  $js = implode("\n", $t);
  if ($bolEcho) echo $js;
  
  return $js;
}
