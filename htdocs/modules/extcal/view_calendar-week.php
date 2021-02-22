<?php

use XoopsModules\Extcal;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once __DIR__ . '/include/constantes.php';
$params                                  = ['view' => _EXTCAL_NAV_CALWEEK, 'file' => _EXTCAL_FILE_CALWEEK];
$GLOBALS['xoopsOption']['template_main'] ="extcal_view_{$params['view']}.tpl";
require_once __DIR__ . '/header.php';

/** @var Extcal\Helper $helper */
$helper = Extcal\Helper::getInstance();

/* ========================================================================== */
get_params_YMDC($year, $month, $day, $cat);
/* ========================================================================== */

// Validate the date (day, month and year)
$dayTS = mktime(0, 0, 0, $month, $day, $year);
//$offset = date('w', $dayTS) - $helper->getConfig('week_start_day');
$offset = date('w', $dayTS) + 7 - $helper->getConfig('week_start_day') < 7 ? date('w', $dayTS) + 7 - $helper->getConfig('week_start_day') : 0;
$dayTS  -= ($offset * _EXTCAL_TS_DAY);
$year   = date('Y', $dayTS);
$month  = date('n', $dayTS);
$day    = date('j', $dayTS);

//echo $dayTS . '   dayTS-2 <br>';
//echo gmdate("Y-m-d\TH:i:s\Z", $dayTS). '   dayTS-2 <br>';

/*
$form = new \XoopsSimpleForm('', 'navigSelectBox', $params['file'], 'get');
$form->addElement(getListYears($year, $helper->getConfig('agenda_nb_years_before'), $helper->getConfig('agenda_nb_years_after')));
$form->addElement(getListMonths($month));
$form->addElement(getListDays($day));
$form->addElement(Extcal\Utility::getListCategories($cat));
$form->addElement(new \XoopsFormButton('', 'form_submit', _SUBMIT, 'submit'));

// Assigning the form to the template
$form->assign($xoopsTpl);
*/
//====================================================================
$xoopsTpl->assign('search', getAsearch($year,$month,$day,$cat));

/**********************************************************************/
// Retriving events and formatting them
//$events = $eventHandler->objectToArray($eventHandler->getEventCalendarWeek($day, $month, $year, $cat), array('cat_id'));

$criteres = [
    'periode'      => _EXTCAL_EVENTS_CALENDAR_WEEK,
    'day'          => $day,
    'month'        => $month,
    'year'         => $year,
    'cat'          => $cat,
    'externalKeys' => array( 'cat_id','location_id'),
];
$events   = $eventHandler->getEventsOnPeriode($criteres);
/**********************************************************************/
//$eventsArray = $events;

// Calculating timestamp for the begin and the end of the month
$startWeek = mktime(0, 0, 0, $month, $day, $year);
$endWeek   = $startWeek + _EXTCAL_TS_WEEK - 1;

//echo $startWeek . '   startWeek <br>';
//echo gmdate("Y-m-d\TH:i:s\Z", $startWeek). '   startWeek <br>';
//echo $endWeek . '   endWeek <br>';
//echo gmdate("Y-m-d\TH:i:s\Z", $endWeek). '   endWeek <br>';

/*
*  Adding all event occuring during this week to an array indexed by day number
*/
$eventsArray = [];
foreach ($events as $event) {
    $eventHandler->addLocation($event);
    $eventHandler->addEventToCalArray($event, $eventsArray, $startWeek, $endWeek);
}

/*
*  Making an array to create tabbed output on the template
*/
// Flag current day
$selectedDays = [
    new Calendar_Day(date('Y', xoops_getUserTimestamp(time(), $timeHandler->getUserTimeZone($xoopsUser))), date('n', xoops_getUserTimestamp(time(), $timeHandler->getUserTimeZone($xoopsUser))), date('j', xoops_getUserTimestamp(time(), $timeHandler->getUserTimeZone($xoopsUser)))),
];

// Build calendar object
$weekCalObj  = new Calendar_Week($year, $month, $day, $helper->getConfig('week_start_day'));
$pWeekCalObj = $weekCalObj->prevWeek('object');
$nWeekCalObj = $weekCalObj->nextWeek('object');
$weekCalObj->build($selectedDays);

$week   = [];
$cellId = 0;
while ($dayCalObj = $weekCalObj->fetch()) {
    $week[$cellId] = [
        'isEmpty'    => $dayCalObj->isEmpty(),
        'dayNumber'  => $dayCalObj->thisDay(),
        'month'      => $dayCalObj->thisMonth(),
        'year'       => $dayCalObj->thisYear(),
        'isSelected' => $dayCalObj->isSelected(),
    ];
    if (!$dayCalObj->isEmpty() && @count($eventsArray[$dayCalObj->thisDay()]) > 0) {
        $week[$cellId]['events'] = $eventsArray[$dayCalObj->thisDay()];
    } else {
        $week[$cellId]['events'] = '';
    }
    ++$cellId;
}

// Assigning events to the template
$xoopsTpl->assign('week', $week);

// Retriving categories
$cats = $catHandler->objectToArray($catHandler->getAllCat($xoopsUser));
// Assigning categories to the template
$xoopsTpl->assign('cats', $cats);

// Retriving weekdayNames
//$weekdayNames = Calendar_Util_Textual::weekdayNames();
$weekdayNames = [_CAL_SUNDAY, _CAL_MONDAY, _CAL_TUESDAY, _CAL_WEDNESDAY, _CAL_THURSDAY, _CAL_FRIDAY, _CAL_SATURDAY];
for ($i = 0; $i < $helper->getConfig('week_start_day'); ++$i) {
    $weekdayName    = array_shift($weekdayNames);
    $weekdayNames[] = $weekdayName;
}
// Assigning weekdayNames to the template
$xoopsTpl->assign('weekdayNames', $weekdayNames);

// Retriving monthNames
$monthNames = Calendar_Util_Textual::monthNames();

// Making navig data
$navig = [
    'prev' => [
        'uri'  =>  sprintf(_EXTCAL_URL_NAV, $pWeekCalObj->thisYear(), $pWeekCalObj->thisMonth(), $pWeekCalObj->thisDay(), $cat),
        'name' => $timeHandler->getFormatedDate($helper->getConfig('nav_date_week'), $pWeekCalObj->getTimestamp()),
    ],
    'this' => [
        'uri'  =>  sprintf(_EXTCAL_URL_NAV, $weekCalObj->thisYear(), $weekCalObj->thisMonth(), $weekCalObj->thisDay(), $cat),
        'name' => $timeHandler->getFormatedDate($helper->getConfig('nav_date_week'), $weekCalObj->getTimestamp()),
    ],
    'next' => [
        'uri'  =>  sprintf(_EXTCAL_URL_NAV, $nWeekCalObj->thisYear(), $nWeekCalObj->thisMonth(), $nWeekCalObj->thisDay(), $cat),
        'name' => $timeHandler->getFormatedDate($helper->getConfig('nav_date_week'), $nWeekCalObj->getTimestamp()),
    ],
];

// Title of the page
$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name') . ' ' . $navig['this']['name']);

// Assigning navig data to the template
$xoopsTpl->assign('navig', $navig);

//Display tooltip
$xoopsTpl->assign('showInfoBulle', $helper->getConfig('showInfoBulle'));
$xoopsTpl->assign('showId', $helper->getConfig('showId'));

// Assigning current form navig data to the template
$xoopsTpl->assign('selectedCat', $cat);
$xoopsTpl->assign('year', $year);
$xoopsTpl->assign('month', $month);
$xoopsTpl->assign('day', $day);
$xoopsTpl->assign('params', $params);

$tNavBar = getNavBarTabs($params['view']);
$xoopsTpl->assign('tNavBar', $tNavBar);
$xoopsTpl->assign('list_position', $helper->getConfig('list_position'));

$xoopsTpl->assign('css_extcal', $helper->getConfig('css_extcal'));   
$xoopsTpl->assign('tdb_rgb', toRGB( $helper->getConfig('tdb_rgb')));   
$xoopsTpl->assign('tdo_rgb', toRGB( $helper->getConfig('tdo_rgb')));

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
$xoopsTpl->assign('view', 'calweek');

// global $xoTheme;
// $xoTheme->addStylesheet(_EXTCAL_URL. "/include/calendar.css");

require_once XOOPS_ROOT_PATH . '/footer.php';
