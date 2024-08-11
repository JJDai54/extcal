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

define('_EXTCAL_FORMAT_AGENDA_KEYD', 'Y-m-d');
define('_EXTCAL_FORMAT_AGENDA_KEYT', 'H:i');

require_once __DIR__ . '/constantes.php';
// require_once  dirname(__DIR__) . '/class/Utility.php';

$moduleDirName = basename(dirname(__DIR__));
//include_once(XOOPS_ROOT_PATH . "/modules/" . $moduleDirName . "/functions0.php");
include_once("functions0.php");

Extcal\Helper::getInstance()->loadLanguage('main');

/*******************************************************************
 *
 ******************************************************************
 * @param        $ts
 * @param        $hStart
 * @param        $hEnd
 * @param int    $mPlage
 * @param int    $nbJours
 * @param        $formatDate
 * @param string $formatJour
 *
 * @return array
 */

function agenda_getCanevas($ts, $hStart, $hEnd, $mPlage = 15, $nbJours = 1, $formatDate ='', $formatJour = 'H:i')
{
    /** @var Extcal\Helper $extcalHelper */
    $extcalHelper = Extcal\Helper::getInstance();
    $jour   = date('d', $ts);
    $mois   = date('m', $ts);
    $an     = date('Y', $ts);
    if (!isset($formatDate)) {
        $formatDate = $extcalHelper->getConfig('event_date_week');
    }


    //echo "agenda_getCanevas : {$jour}-{$mois}-{$an}-{$ts}<br>";
    //$tsStart = mktime($heure, $minute, $seconde, $mois, $jour, $an);
    $jName = [
        _MD_EXTCAL_DAY_SUNDAY,
        _MD_EXTCAL_DAY_MONDAY,
        _MD_EXTCAL_DAY_TUESDAY,
        _MD_EXTCAL_DAY_WEDNESDAY,
        _MD_EXTCAL_DAY_THURSDAY,
        _MD_EXTCAL_DAY_FRIDAY,
        _MD_EXTCAL_DAY_SATURDAY,
    ];

    // construction du tableu des jours qui sera affecter à chaque tranche horraire
    $tj = [];
    for ($j = 0; $j < $nbJours; ++$j) {
        $tsj                = mktime(0, 0, 0, $mois, $jour + $j, $an);
        $kj                 = date(_EXTCAL_FORMAT_AGENDA_KEYD, $tsj);
        $tj[$kj]['caption'] = date($formatDate, $tsj);

        $tj[$kj]['events'] = [];

        $tj[$kj]['dayWeek'] = date('w', $tsj);
        $tj[$kj]['jour']    = $jName[$tj[$kj]['dayWeek']]; //date('l', $tsj);
        if (0 == $tj[$kj]['dayWeek']) {
            $tj[$kj]['bg'] = "background='" . XOOPS_URL . "/modules/extcal/assets/images/trame.png'";
        } else {
            $tj[$kj]['bg'] = '';
        }
    }

    //construction du tableau des plages horraires
    //echo "{$hStart}-{$hEnd}-{$mPlage}<br>";
    $sPlage  = $mPlage * _EXTCAL_TS_MINUTE; // en secondes
    $tsStart = mktime($hStart, 0, 0, 1, 1, $an);
    $tsEnd   = mktime($hEnd + 1, 0, 0, 1, 1, $an);

    $ta = [];
    if ($hStart > 0) {
        $tsCurent          = mktime(0, 0, 0, 1, 1, $an);
        $k                 = date(_EXTCAL_FORMAT_AGENDA_KEYT, $tsCurent);
        $ta[$k]['caption'] = date($formatJour, $tsCurent);
        $ta[$k]['jours']   = $tj;
        $ta[$k]['class']   = 'head';
    }

    $tsCurent = $tsStart;
    $h        = 0;
    while ($tsCurent < $tsEnd) {
        $k = date(_EXTCAL_FORMAT_AGENDA_KEYT, $tsCurent);
        //echo "{$k}-$tsCurent-";
        $ta[$k]['caption'] = date($formatJour, $tsCurent);
        $ta[$k]['jours']   = $tj;
        $ta[$k]['class']   = ((0 == ($h % 2)) ? 'odd' : 'even');

        //----------------------------------------------
        ++$h;
        $tsCurent += $sPlage;
    }

    if ($hEnd < 23) {
        $tsCurent          = mktime($hEnd + 1, 0, 0, 1, 1, $an);
        $k                 = date(_EXTCAL_FORMAT_AGENDA_KEYT, $tsCurent);
        $ta[$k]['caption'] = date($formatJour, $tsCurent);
        $ta[$k]['jours']   = $tj;
        $ta[$k]['class']   = 'foot';
    }
// $tr = print_r($ta, true);
// echo "<pre>{$tr}</pre>";

    return $ta;
}


/*******************************************************************
 *
 ******************************************************************/
function nextWeek($currentTs, $nbWeek=1){
  $newTs = mktime(0,0,0,date('m', $currentTs), date('d', $currentTs), date('Y', $currentTs))
  +(_EXTCAL_TS_DAY * (7*$nbWeek));
  return $newTs;
}

/*******************************************************************
 *
 ******************************************************************/
function isDateBetweenDates($currentTs, $beginTs, $endTs, $roundHMS = true){
  if ($roundHMS){
    $currentTs=mktime(0,0,0,date('m', $currentTs), date('d', $currentTs), date('Y', $currentTs));
    $beginTs=mktime(0,0,0,date('m', $beginTs), date('d', $beginTs), date('Y', $beginTs));
    $endTs=mktime(0,0,-1,date('m', $endTs), date('d', $endTs)+1, date('Y', $endTs));
  }
  return ($currentTs >= $beginTs && $currentTs <= $endTs);
}

/*******************************************************************
 *
 ******************************************************************
 * @param        $eventsArray
 * @param        $ts
 * @param        $hStart
 * @param        $hEnd
 * @param int    $mPlage
 * @param int    $nbJours
 * @param string $formatDate
 * @param string $formatJour
 * @return array
 */
function agenda_getEvents(
    $eventsArray,
    $ts,
    $hStart,
    $hEnd,
    $mPlage = 15,
    $nbJours = 1,
    $formatDate = 'd-m-Y',
    $formatJour = 'H:i')
{

$JourDebut = date(_EXTCAL_FORMAT_AGENDA_KEYD, $ts);
//echo "<hr>JourDebut : {$JourDebut}<br>hStart : {$hStart}<br>hEnd : {$hEnd}<br>mPlage : {$mPlage}<br>nbJours : {$nbJours}<br>formatDate : {$formatDate}<br>formatJour : {$formatJour}<hr>";
    //    $tAgenda = agenda_getCanevas($ts, 8, 20, $mPlage, $nbJours);
    $tAgenda = agenda_getCanevas($ts, $hStart, $hEnd - 1, $mPlage, $nbJours, $formatDate, $formatJour);
    $tk      = array_keys($tAgenda);
    $tk0     = $tk[0];
    $tk1     = $tk[count($tk) - 1];


    foreach ($eventsArray as $e) {
        $ets     = $e['event_start'];
        $kd     = date(_EXTCAL_FORMAT_AGENDA_KEYD, $ets);
        $hour   = date('H', $ets);
        $minute = date('i', $ets);
        $m      = (int)($minute / $mPlage) * $mPlage;
        //      echo "--->{$minute} / {$mPlage} = {$m}<br>";
        $sMinute = (($m < 10) ? '0' . $m : $m);
        //$kt = date(_EXTCAL_FORMAT_AGENDA_KEYT, $ts);
//         echo "===> kd : {$kd} - tk0 : {$tk0} - tk1 : {$tk1}<br>";
//         echo "===> mPlage : {$mPlage} - nbJours : {$nbJours}<br>";

        if ($hour < $hStart) {
            $kt = $tk0;
        } elseif ($hour >= ($hEnd + 1)) {
            $kt = $tk1;
        } else {
            $kt = $hour . ':' . $sMinute;
        }

//       foreach ($tAgenda as &$ta) {
//           $ta['events'][] = $e;
//
//       }

        for($j=0; $j<$nbJours; $j++){
          $tcurrentTs = ext_DateAdd($ts, $j);
          $currentdate = date(_EXTCAL_FORMAT_AGENDA_KEYD, $tcurrentTs);
//           echo "===> j: {$j}<br>";
//           echo "===> currentdate : {$currentdate}<br>";
//           echo "===> event_start : " . date(_EXTCAL_FORMAT_AGENDA_KEYD, $e['event_start']) . "<br>";
//           echo "===> event_end : " . date(_EXTCAL_FORMAT_AGENDA_KEYD, $e['event_end']) . "<br>";
//
// echo "===> {$e['event_start']} - {$tcurrentTs} - {$e['event_end']}<br>";
// echo "===> {$tcurrentTs} >= {$e['event_start']} && {$tcurrentTs} <= {$e['event_end']} <br>";
          //if ($tcurrentTs>= $e['event_start'] && $tcurrentTs<=$e['event_end']){
          if (isDateBetweenDates($tcurrentTs, $e['event_start'], $e['event_end'])){
            $tAgenda[$kt]['jours'][$currentdate]['events'][] = $e;
          }
        }
    }

    return $tAgenda;
}

/*******************************************************************
 *
 *******************************************************************/
function test_getAgenda()
{
    $tsD1 = mktime(0, 0, 0, 01, 25, 1954);
    $t    = getAgenda($tsD1, 8, 21, 30, 7);

    $t['10:30']['jours']['1954-01-25']['events'][1]['lib'] = 'Jean';
    $t['10:30']['jours']['1954-01-25']['events'][1]['dsc'] = 'bobo';

    $t['10:30']['jours']['1954-01-25']['events'][7]['lib'] = 'polo';
    $t['10:30']['jours']['1954-01-25']['events'][7]['dsc'] = 'haribo';

    $t['11:30']['jours']['1954-01-28']['events'][5]['lib'] = 'Jean';
    $t['11:30']['jours']['1954-01-28']['events'][5]['dsc'] = 'bibi';

    $exp = print_r($t, true);
    echo "<pre>{$exp}</pre>";
}

/*******************************************************************
 *
 ******************************************************************
 * @param $event1
 * @param $event2
 * @return int
 */
function orderEvents($event1, $event2)
{
    if ($event1['event_start'] == $event2['event_start']) {
        return 0;
    }
    if ('ASC' === $GLOBALS['xoopsModuleConfig']['sort_order']) {
        $opt1 = -1;
        $opt2 = 1;
    } else {
        $opt1 = 1;
        $opt2 = -1;
    }

    return ($event1['event_start'] < $event2['event_start']) ? $opt1 : $opt2;
}
/*******************************************************************
 *
 ******************************************************************/
function getAsearch($year, $month, $day, $cat, $addJS=true){
global $extcalHelper;
  
  $extcalHelper = Extcal\Helper::getInstance();
  $tSearch = array();

  $jsOnChange = (($addJS) ? "onChange='document.ext_search_form.submit()'" : '');

  if(!is_null($year)){
  $lstYear = getListYears($year, $extcalHelper->getConfig('agenda_nb_years_before'), $extcalHelper->getConfig('agenda_nb_years_after'));
  $lstYear->setExtra($jsOnChange);
  $tSearch['year'] = $lstYear->render();

  /*
  $tSearch['year'] = getListYears($year, $extcalHelper->getConfig('agenda_nb_years_before'), $extcalHelper->getConfig('agenda_nb_years_after'))->render();
  */
  }

  if(!is_null($month)){
    $lstMonth = getListMonths($month);
    $lstMonth->setExtra($jsOnChange);
    $tSearch['month'] = $lstMonth->render();
  }

  if(!is_null($cat)){
    $lstCat = Extcal\Utility::getXoopsFormSelectCategories($cat);
    $lstCat->setExtra($jsOnChange);
    $tSearch['categorie'] = $lstCat->render();
  }

  if(!is_null($day)){
    $lstDay = getListDays($day);
    $lstDay->setExtra($jsOnChange);
    $tSearch['day'] = $lstDay->render();
  }

  $btnSubmit = new \XoopsFormButton('', 'form_submit_today', _MD_EXTCAL_TODAY, 'submit');
  $tSearch['today'] = $btnSubmit->render();

  $btnSubmit = new \XoopsFormButton('', 'form_submit', _SUBMIT, 'submit');
  $tSearch['submit'] = $btnSubmit->render();

  return $tSearch;
}
/*******************************************************************
 *
 ******************************************************************/
 function get_params_YMDC(&$year, &$month, &$day, &$cat){
 global $allCatsAllowed; //JJDai provisoire, a passer en paramettre de preference
    $today = \Xmf\Request::getString('form_submit_today', '', 'REQUEST');
    //echo "===> toDay = |" . $today . "|<br>";
    if ($today == ''){
      $year  = \Xmf\Request::getInt('year', date('Y'), 'REQUEST');
      $month = \Xmf\Request::getInt('month', date('n'), 'REQUEST');
      $day   = \Xmf\Request::getInt('day', date('j'), 'REQUEST');
    }else{
      $year  = date("Y");
      $month = date("n");
      $day = date("j");
    }
    $cat   = \Xmf\Request::getInt('cat', 0, 'REQUEST');
    if (!array_key_exists ($cat,$allCatsAllowed)){
        $cat = 0;
    }

 }
// /*******************************************************************
//  *
//  ******************************************************************/
//  function get_params_YMDC(&$year, &$month, &$day, &$cat){
//     $today = \Xmf\Request::getString('form_submit_today', '', 'GET');
//     //echo "===> toDay = |" . $today . "|<br>";
//     if ($today == ''){
//       $year  = \Xmf\Request::getInt('year', date('Y'), 'GET');
//       $month = \Xmf\Request::getInt('month', date('n'), 'GET');
//       $day   = \Xmf\Request::getInt('day', date('j'), 'GET');
//     }else{
//       $year  = date("Y");
//       $month = date("n");
//       $day = date("j");
//     }
//     $cat   = \Xmf\Request::getInt('cat', 0, 'GET');
// 
//  }
/*******************************************************************
 *
 ******************************************************************
 * @param        $year
 * @param int    $nbYearsBefore
 * @param int    $nbYearsAfter
 * @param bool   $addNone
 * @param string $name
 * @return \XoopsFormSelect
 */
function getListYears($year, $nbYearsBefore = 0, $nbYearsAfter = 5, $addNone = false, $name = 'year')
{
    // Year selectbox
    $select = new \XoopsFormSelect('', $name, $year);
    if ($addNone) {
        $select->addOption(0, ' ');
    }
    if (0 == $year) {
        $year = date('Y');
    }

    $firstYear = date("Y") - $nbYearsBefore;
    $lastYear = date("Y") + $nbYearsAfter;

    for ($i = $firstYear; $i <= $lastYear; ++$i) {
        $select->addOption($i);
    }

    return $select;
}

/*******************************************************************
 *
 ******************************************************************
 * @param        $month
 * @param bool   $addNone
 * @param string $name
 * @return \XoopsFormSelect
 */
function getListMonths($month, $addNone = false, $name = 'month')
{
    // Month selectbox
    $timeHandler = Extcal\Time::getHandler();

    $select = new \XoopsFormSelect('', $name, $month);
    if ($addNone) {
        $select->addOption(0, ' ');
    }

    for ($i = 1; $i < 13; ++$i) {
        $select->addOption($i, $timeHandler->getMonthName($i));
    }

    return $select;
}

/*******************************************************************
 *
 ******************************************************************
 * @param      $day
 * @param bool $addNone
 * @return \XoopsFormSelect
 */
function getListDays($day, $addNone = false)
{
    // Day selectbox
    $select = new \XoopsFormSelect('', 'day', $day);
    if ($addNone) {
        $select->addOption(0, ' ');
    }

    for ($i = 1; $i < 32; ++$i) {
        $select->addOption($i);
    }

    return $select;
}

/*******************************************************************
 *
 ******************************************************************
 * @param $name
 * @return bool
 */
function ext_loadLanguage($name)
{
    global $xoopsConfig;
    $prefix = mb_substr($name, 4);
    switch ($prefix) {
        case '_MI_':
            $f = '';
            break;
        case '_MD_':
            $f = '';
            break;
        default:
            return false;
    }

    $file   = XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/' . $f;
    $prefix = (defined($name) ? '_MI' : '_MD');
    require_once $file;
}

/*******************************************************************
 *
 ******************************************************************
 * @param string $currentTab
 * @return array
 */

function getNavBarTabs($currentTab = '')
{global $extcalHelper;
    /** @var Extcal\Helper $extcalHelper */
    $extcalHelper = Extcal\Helper::getInstance();

    ext_loadLanguage('_MD_');

    if($extcalHelper){
        $visibleTabs = $extcalHelper->getConfig('visible_tabs');
        $tabs = $extcalHelper->getConfig('weight_tabs');
        //$tabs    = str_replace("\n", $sep, $extcalHelper->getConfig('_EXTCAL_NAV_LIST'));
    }else{
        $visibleTabs = array();
        $tabs = _EXTCAL_NAV_LIST ;
    }
    
    
    $tNavBar     = $ordre = [];
//ext_echo($visibleTabs);

    $sep     = '=';
    $tabs    = str_replace("\n", $sep, $tabs);
    //echo "getNavBarTabs : tabs = ===> {$tabs}<br>";
    $tabs    = str_replace("\r", '', $tabs);
    $tabs    = str_replace(' ', '', $tabs);
    $t       = explode($sep, $tabs);
    $tWeight = array_flip($t);

    //-----------------------------------------------------------------
    $view = _EXTCAL_NAV_CALMONTH;
    //   echo "{$view} - {$currentTab}<br>";
    //   echoArray($visibleTabs,true);
    if (in_array($view, $visibleTabs, true)) {
        $tNavBar[$view] = [
            'href'    => _EXTCAL_FILE_CALMONTH,
            'name'    => _MD_EXTCAL_NAV_CALMONTH,
            'current' => ($view == $currentTab) ? 1 : 0,
            'weight'  => 110,
        ];
    }

    $view = _EXTCAL_NAV_CALWEEK;
    if (in_array($view, $visibleTabs, true)) {
        $tNavBar[$view] = [
            'href'    => _EXTCAL_FILE_CALWEEK,
            'name'    => _MD_EXTCAL_NAV_CALWEEK,
            'current' => ($view == $currentTab) ? 1 : 0,
            'weight'  => 120,
        ];
    }

    $view = _EXTCAL_NAV_YEAR;
    if (in_array($view, $visibleTabs, true)) {
        $tNavBar[$view] = [
            'href'    => _EXTCAL_FILE_YEAR,
            'name'    => _MD_EXTCAL_NAV_YEAR,
            'current' => ($view == $currentTab) ? 1 : 0,
            'weight'  => 130,
        ];
    }

    $view = _EXTCAL_NAV_MONTH;
    if (in_array($view, $visibleTabs, true)) {
        $tNavBar[$view] = [
            'href'    => _EXTCAL_FILE_MONTH,
            'name'    => _MD_EXTCAL_NAV_MONTH,
            'current' => ($view == $currentTab) ? 1 : 0,
            'weight'  => 140,
        ];
    }

    $view = _EXTCAL_NAV_WEEK;
    if (in_array($view, $visibleTabs, true)) {
        $tNavBar[$view] = [
            'href'    => _EXTCAL_FILE_WEEK,
            'name'    => _MD_EXTCAL_NAV_WEEK,
            'current' => ($view == $currentTab) ? 1 : 0,
            'weight'  => 150,
        ];
    }

    $view = _EXTCAL_NAV_DAY;
    if (in_array($view, $visibleTabs, true)) {
        $tNavBar[$view] = [
            'href'    => _EXTCAL_FILE_DAY,
            'name'    => _MD_EXTCAL_NAV_DAY,
            'current' => ($view == $currentTab) ? 1 : 0,
            'weight'  => 160,
        ];
    }

    $view = _EXTCAL_NAV_AGENDA_WEEK;
    if (in_array($view, $visibleTabs, true)) {
        $tNavBar[$view] = [
            'href'    => _EXTCAL_FILE_AGENDA_WEEK,
            'name'    => _MD_EXTCAL_NAV_AGENDA_WEEK,
            'current' => ($view == $currentTab) ? 1 : 0,
            'weight'  => 170,
        ];
    }

    $view = _EXTCAL_NAV_AGENDA_DAY;
    if (in_array($view, $visibleTabs, true)) {
        $tNavBar[$view] = [
            'href'    => _EXTCAL_FILE_AGENDA_DAY,
            'name'    => _MD_EXTCAL_NAV_AGENDA_DAY,
            'current' => ($view == $currentTab) ? 1 : 0,
            'weight'  => 180,
        ];
    }

    $view = _EXTCAL_NAV_SEARCH;
    if (in_array($view, $visibleTabs, true)) {
        $tNavBar[$view] = [
            'href'    => _EXTCAL_FILE_SEARCH,
            'name'    => _MD_EXTCAL_NAV_SEARCH,
            'current' => ($view == $currentTab) ? 1 : 0,
            'weight'  => 200,
        ];
    }

    $view = _EXTCAL_NAV_LOCATION_LIST;
    if (in_array($view, $visibleTabs, true)) {
        $tNavBar[$view] = [
            'href'    => _EXTCAL_FILE_LOCATION_LIST, 
            'name'    => _MD_EXTCAL_NAV_LOCATIONS,
            'current' => ($view == $currentTab) ? 1 : 0,
            'weight'  => 210,
        ];
    }

    $user = isset($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser'] : null;
    /** @var Extcal\CategoryHandler $catHandler */
    $catHandler = Extcal\Helper::getInstance()->getHandler(_EXTCAL_CLN_CAT);
    if ($catHandler->haveSubmitRight($user)) {
        $view = _EXTCAL_NAV_NEW_EVENT;
        if (in_array($view, $visibleTabs, true)) {
            $tNavBar[$view] = [
                'href'    => _EXTCAL_FILE_NEW_EVENT,
                'name'    => _MD_EXTCAL_NAV_NEW_EVENT,
                'current' => ($view == $currentTab) ? 1 : 0,
                'weight'  => 100,
            ];
        }
    }
    //----------------------------------------------------------------
    //    $ordre = array();
    //    while (list($k, $v) = each($tNavBar)) {
    foreach ($tNavBar as $k => $v) {
        if (isset($tWeight[$k])) {
            $ordre[] = (int)$tWeight[$k]; //ordre defini dans les option du module
        } else {
            $ordre[] = $v['weight']; // ordre par defaut ddefini dans le tableau $tNavBar
        }
    }

    array_multisort($tNavBar, SORT_ASC, SORT_NUMERIC, $ordre, SORT_ASC, SORT_NUMERIC);

    //    Extcal\Utility::echoArray($tNavBar);
    //    Extcal\Utility::echoArray($ordre);
    return $tNavBar;
}

/*----------------------------------------------------------------------*/
