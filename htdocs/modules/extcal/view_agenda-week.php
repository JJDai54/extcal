<?php

use XoopsModules\Extcal;
//echo "===>" .  __FILE__ . "<br>";


require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once __DIR__ . '/include/constantes.php';
$params = ['view' => _EXTCAL_NAV_AGENDA_WEEK, 'file' => _EXTCAL_FILE_AGENDA_WEEK];
$GLOBALS['xoopsOption']['template_main'] = "extcal_view_{$params['view']}.tpl";
require_once __DIR__ . '/header.php';

/* ========================================================================== */
get_params_YMDC($year, $month, $day, $cat);
//$dayWeek = date('w', mktime(0,0,0,$month,$day,$year));
//test
// $year  = 2019;
// $month = 12;
// $day   = 12;

// Validate the date (day, month and year)
$dayTS = mktime(0, 0, 0, $month, $day, $year);
//$offset = date('w', $dayTS) - $extcalHelper->getConfig('week_start_day');
//$offset = date('w', $dayTS) + 7 - $extcalHelper->getConfig('week_start_day') < 7 ? date('w', $dayTS) + 7 - $extcalHelper->getConfig('week_start_day') : 0;
$offset = date('w', $dayTS) - $extcalHelper->getConfig('week_start_day');

// echo "offset = {$offset}<br>";
// echo "premier jour semaine = " . $extcalHelper->getConfig('week_start_day') . "<br>";
// echo "jour semaine = " . date('w', $dayTS) . "<br>";



$dayTS  -= ($offset * _EXTCAL_TS_DAY);
$year   = date('Y', $dayTS);
$month  = date('n', $dayTS);
$day    = date('j', $dayTS);

/*
$form = new \XoopsSimpleForm('', 'navigSelectBox', $params['file'], 'get');
$form->addElement(getListYears($year, $extcalHelper->getConfig('agenda_nb_years_before'), $extcalHelper->getConfig('agenda_nb_years_after')));
$form->addElement(getListMonths($month));
$form->addElement(getListDays($day));
$form->addElement(Extcal\Utility::getXoopsFormSelectCategories($cat));
$form->addElement(new \XoopsFormButton('', '', _SUBMIT, 'submit'));

// Assigning the form to the template
$form->assign($xoopsTpl);
*/
//====================================================================
$xoopsTpl->assign('search', getAsearch($year,$month,$day,$cat));

$mTranche = $extcalHelper->getConfig('agenda_tranche_minutes'); //minutes
$hStart   = $extcalHelper->getConfig('agenda_start_hour'); //heure debut de journee
$hEnd     = $extcalHelper->getConfig('agenda_end_hour'); //heure fin de journee
//$extcalHelper->getConfig('agenda_nb_days_week') = 5;
$nbJours = $extcalHelper->getConfig('agenda_nb_days_week'); //nombre de jour

/**********************************************************************/
// Retriving events and formatting them
//$events = $eventHandler->objectToArray($eventHandler->getEventWeek($day, $month, $year, $cat, $nbJours), array('cat_id'));
$criteres = [
    'periode'      => _EXTCAL_EVENTS_AGENDA_WEEK,
    'day'          => $day,
    'month'        => $month,
    'year'         => $year,
    'cat'          => $cat,
    'nbJours'      => $nbJours,
    'externalKeys' => array( 'cat_id','location_id'),
];
$events   = $eventHandler->getEventsOnPeriode($criteres);
/**********************************************************************/
$eventsArray = $events;

//-------------------------------------------------------------------
// Assigning events to the template
//-------------------------------------------------------------------

//$params['colJourWidth'] = (int)((((500-50)/$nbJours)/500*100)+.5);
$params['colJourWidth'] = (int)((((500 - 50) / $nbJours) / 500 * 100) + .6);
$tAgenda = agenda_getEvents($eventsArray, $dayTS, $hStart, $hEnd, $mTranche, $nbJours);
//$exp = print_r($eventsArray, true);
// echo "agenda_week : {$dayTS}<br>";
// $exp = print_r($tAgenda, true);
// echo "<pre>{$exp}</pre>";

$xoopsTpl->assign('agenda', $tAgenda);
//-------------------------------------------------------------------

// Retriving categories
$cats = $catHandler->objectToArray($catHandler->getAllCat($xoopsUser));
// Assigning categories to the template
$xoopsTpl->assign('cats', $cats);

// Making navig data
$weekCalObj  = new Calendar_Week($year, $month, $day, $extcalHelper->getConfig('week_start_day'));
$pWeekCalObj = $weekCalObj->prevWeek('object');
$nWeekCalObj = $weekCalObj->nextWeek('object');
$prevWeeekTs = nextWeek($weekCalObj->getTimestamp(),-1);
$nexWeekTs = nextWeek($weekCalObj->getTimestamp());


$navig = [
    'prev' => [
//         'uri'  => 'year=' . $pWeekCalObj->thisYear() . '&amp;month=' . $pWeekCalObj->thisMonth() . '&amp;day=' . $pWeekCalObj->thisDay(),
//         'name' => $timeHandler->getFormatedDate($extcalHelper->getConfig('nav_date_week'), $pWeekCalObj->getTimestamp()),
        'uri'  =>  sprintf(_EXTCAL_URL_NAV, date("Y", $prevWeeekTs) ,date("m", $prevWeeekTs) , date("d", $prevWeeekTs), $cat),
        'name' => $timeHandler->getFormatedDate($extcalHelper->getConfig('nav_date_week'), $prevWeeekTs)
    ],
    'this' => [
        //'uri'  => 'year=' . $weekCalObj->thisYear() . '&amp;month=' . $weekCalObj->thisMonth() . '&amp;day=' . $weekCalObj->thisDay(),
        'uri'  =>  sprintf(_EXTCAL_URL_NAV, $weekCalObj->thisYear(), $weekCalObj->thisMonth(), $weekCalObj->thisDay(), $cat),
        'name' => $timeHandler->getFormatedDate($extcalHelper->getConfig('nav_date_week'), $weekCalObj->getTimestamp())
    ],
    'next' => [
        //'uri'  => 'year=' . $nWeekCalObj->thisYear() . '&amp;month=' . $nWeekCalObj->thisMonth() . '&amp;day=' . $nWeekCalObj->thisDay(),
        //'name' => $timeHandler->getFormatedDate($extcalHelper->getConfig('nav_date_week'), $nWeekCalObj->getTimestamp()),
        'uri'  =>  sprintf(_EXTCAL_URL_NAV, date("Y", $nexWeekTs) ,date("m", $nexWeekTs) , date("d", $nexWeekTs), $cat),
        'name' => $timeHandler->getFormatedDate($extcalHelper->getConfig('nav_date_week'), $nexWeekTs)
    ],
];

// Title of the page
$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name') . ' ' . $navig['this']['name']);

// Assigning navig data to the template
$xoopsTpl->assign('navig', $navig);

//Display tooltip
$xoopsTpl->assign('showInfoBulle', $extcalHelper->getConfig('showInfoBulle'));
$xoopsTpl->assign('showId', $extcalHelper->getConfig('showId'));

// Assigning current form navig data to the template
$xoopsTpl->assign('selectedCat', $cat);
$xoopsTpl->assign('year', $year);
$xoopsTpl->assign('month', $month);
$xoopsTpl->assign('day', $day);
$xoopsTpl->assign('params', $params);

$tNavBar = getNavBarTabs($params['view']);
$xoopsTpl->assign('tNavBar', $tNavBar);
$xoopsTpl->assign('list_position', $extcalHelper->getConfig('list_position'));

// echoArray($tNavBar,true);

//mb missing for xBootstrap templates by Angelo
$lang = [
    'start'      => _MD_EXTCAL_START,
    'end'        => _MD_EXTCAL_END,
    'calmonth'   => _MD_EXTCAL_NAV_CALMONTH,
    'calweek'    => _MD_EXTCAL_NAV_CALWEEK,
    'year'       => _MD_EXTCAL_NAV_YEAR,
    'month'      => _MD_EXTCAL_NAV_MONTH,
    'week'       => _MD_EXTCAL_NAV_WEEK,
    'day'        => _MD_EXTCAL_NAV_DAY,
    'agendaweek' => _MD_EXTCAL_NAV_AGENDA_WEEK,
    'agendaday'  => _MD_EXTCAL_NAV_AGENDA_DAY,
    'search'     => _MD_EXTCAL_NAV_SEARCH,
    'newevent'   => _MD_EXTCAL_NAV_NEW_EVENT,
];
// Assigning language data to the template
$xoopsTpl->assign('lang', $lang);
$xoopsTpl->assign('view', 'agendaweek');

require_once XOOPS_ROOT_PATH . '/footer.php';
