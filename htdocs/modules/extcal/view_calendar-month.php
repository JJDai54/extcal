<?php

use XoopsModules\Extcal;
//echo "===>" .  __FILE__ . "<br>";


require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once __DIR__ . '/include/constantes.php';

$params = ['view' => _EXTCAL_NAV_CALMONTH, 'file' => _EXTCAL_FILE_CALMONTH];
$GLOBALS['xoopsOption']['template_main'] = "extcal_view_{$params['view']}.tpl";
//echo $GLOBALS['xoopsOption']['template_main'] . "<hr>";

//require_once __DIR__   . '/preloads/autoloader.php';
//$catHandler   = Extcal\Helper::getInstance()->getHandler(_EXTCAL_CLN_CAT);

require_once __DIR__ . '/header.php';

/* ========================================================================== */
get_params_YMDC($year, $month, $day, $cat);

// $today = \Xmf\Request::getString('form_submit_today', '', 'GET');
// //echo "===> toDay = |" . $today . "|<br>";
// if ($today == ''){
//   $year  = \Xmf\Request::getInt('year', date('Y'), 'GET');
//   $month = \Xmf\Request::getInt('month', date('n'), 'GET');
// }else{
//   $year  = date("Y");
//   $month = date("n");
// }
// $cat   = \Xmf\Request::getInt('cat', 0, 'GET');
/* ========================================================================== */
/*
$form = new \XoopsSimpleForm('', 'navigSelectBox', $params['file'], 'get');
$form->addElement(getListYears($year, $extcalHelper->getConfig('agenda_nb_years_before'), $extcalHelper->getConfig('agenda_nb_years_after')));
$form->addElement(getListMonths($month));
$form->addElement(Extcal\Utility::getXoopsFormSelectCategories($cat));
$form->addElement(new \XoopsFormButton('', 'form_submit', _SUBMIT, 'submit'));

// Assigning the form to the template
$form->assign($xoopsTpl);
*/
// $tr = print_r( $_GET,true);
// echo "<pre>{$tr}</pre><hr>";
//====================================================================
$xoopsTpl->assign('search', getAsearch($year,$month,null,$cat));

/**********************************************************************/
// Retriving events and formatting them
// $events = $eventHandler->objectToArray($eventHandler->getEventCalendarMonth($month, $year, $cat), array('cat_id'));
$criteres = [
    'periode'      => _EXTCAL_EVENTS_CALENDAR_MONTH,
    'month'        => $month,
    'year'         => $year,
    'cat'          => $cat,
    'externalKeys' => array( 'cat_id','location_id')
    ];
//ext_echo($criteres,"view_calendar_month");
$events   = $eventHandler->getEventsOnPeriode($criteres); //, "extcal_rs_event"
//ext_echo($events,"pppppppppppppppppppp");

// ext_echo($criteres,"");
//$events = $eventHandler->getEventsOnPeriode($criteres); //, "extcal_rs_event"
//ext_echo($events,"");

/**********************************************************************/

// Calculating timestamp for the begin and the end of the month
$startMonth = mktime(0, 0, 0, $month, 1, $year);
//$endMonth   = mktime(23, 59, 59, $month + 1, 0, $year);
$endMonth   = mktime(0, 0, 0, $month + 1, 1, $year)-1;
// echo  "startMonth = {$startMonth} ===> ". date("d-m-Y H:i:s", $startMonth) ."<br>";
// echo  "endMonth = {$endMonth} ===> ". date("d-m-Y H:i:s", $endMonth) ."<br>";
// echo  "heure acuelle : " .  ext_echo(gettimeofday ()) .  "<br>";

/*
*  Adding all event occuring during this month to an array indexed by day number
*/
$eventsArray = [];    
foreach ($events as $event) {
// echo "===>" . $event['event_title']. "<br>";
    $eventHandler->formatEventDate($event, $extcalHelper->getConfig('event_date_month'), $extcalHelper->getConfig('event_date_infobulle'));
    $eventHandler->addLocation($event);

    $eventHandler->addEventToCalArray($event, $eventsArray, $startMonth, $endMonth);
}
//ext_echo($eventsArray,"zzzzz");

// $tr=print_r($eventsArray,true);
// echo "<pre>{$tr}</pre>";

/*
*  Making an array to create tabbed output on the template
*/
// Flag current day
$selectedDays = [
    new Calendar_Day(date('Y', xoops_getUserTimestamp(time(), $timeHandler->getUserTimeZone($xoopsUser))), date('n', xoops_getUserTimestamp(time(), $timeHandler->getUserTimeZone($xoopsUser))), date('j', xoops_getUserTimestamp(time(), $timeHandler->getUserTimeZone($xoopsUser)))),
];

// Build calendar object
$monthCalObj  = new Calendar_Month_Weeks($year, $month, $extcalHelper->getConfig('week_start_day'));
$pMonthCalObj = $monthCalObj->prevMonth('object');
$nMonthCalObj = $monthCalObj->nextMonth('object');
$monthCalObj->build();

$tableRows = [];
$rowId     = 0;
$cellId    = 0;
while ($weekCalObj = $monthCalObj->fetch()) {
    $weekCalObj->build($selectedDays);
    $tableRows[$rowId]['weekInfo'] = [
        'week'  => $weekCalObj->thisWeek('n_in_year'),
        'day'   => $weekCalObj->thisDay(),
        'month' => $weekCalObj->thisMonth(),
        'year'  => $weekCalObj->thisYear(),
    ];
    while ($dayCalObj = $weekCalObj->fetch()) {
        $tableRows[$rowId]['week'][$cellId] = [
            'isEmpty'    => $dayCalObj->isEmpty(),
            'number'     => $dayCalObj->thisDay(),
            'isSelected' => $dayCalObj->isSelected(),
        ];
        //echo "<hr>dayCalObj->thisDay()] = " . $dayCalObj->thisDay() . " - count = " . count($eventsArray[$dayCalObj->thisDay()]) ."<hr>";
        $eventOfDay = $eventsArray[$dayCalObj->thisDay()];
        if (!isset($eventOfDay))  $eventOfDay= array();
        if (@count($eventOfDay) > 0 && !$dayCalObj->isEmpty()) {
            $tableRows[$rowId]['week'][$cellId]['events'] = $eventsArray[$dayCalObj->thisDay()];
        } else {
            $tableRows[$rowId]['week'][$cellId]['events'] = '';
        }
        ++$cellId;
    }
    $cellId = 0;
    ++$rowId;
}

// Assigning events to the template
$xoopsTpl->assign('tableRows', $tableRows);

// Retriving categories

// Assigning categories to the template
$xoopsTpl->assign('cats', $allCatsAllowed);

// Retriving weekdayNames
//$weekdayNames = Calendar_Util_Textual::weekdayNames();
//$weekdayNames = array('Dimanche','Mardi','Mercresi','Jeudi','Vendredi','Samedi');
$weekdayNames = [_CAL_SUNDAY, _CAL_MONDAY, _CAL_TUESDAY, _CAL_WEDNESDAY, _CAL_THURSDAY, _CAL_FRIDAY, _CAL_SATURDAY];

for ($i = 0; $i < $extcalHelper->getConfig('week_start_day'); ++$i) {
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
        'uri'  =>  sprintf(_EXTCAL_URL_NAV, $pMonthCalObj->thisYear(), $pMonthCalObj->thisMonth(), 1, $cat),
        'name' => $timeHandler->getFormatedDate($extcalHelper->getConfig('nav_date_month'), $pMonthCalObj->getTimestamp()),
    ],
    'this' => [
        'uri'  =>  sprintf(_EXTCAL_URL_NAV, $monthCalObj->thisYear(), $monthCalObj->thisMonth(), 1, $cat),
        'name' => $timeHandler->getFormatedDate($extcalHelper->getConfig('nav_date_month'), $monthCalObj->getTimestamp()),
    ],
    'next' => [
        'uri'  =>  sprintf(_EXTCAL_URL_NAV,  $nMonthCalObj->thisYear(), $nMonthCalObj->thisMonth(), 1, $cat),
        'name' => $timeHandler->getFormatedDate($extcalHelper->getConfig('nav_date_month'), $nMonthCalObj->getTimestamp()),
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
$xoopsTpl->assign('params', $params);

$tNavBar = getNavBarTabs($params['view']);
$xoopsTpl->assign('tNavBar', $tNavBar);
$xoopsTpl->assign('list_position', $extcalHelper->getConfig('list_position'));

$xoopsTpl->assign('css_extcal', $extcalHelper->getConfig('css_extcal'));   
$xoopsTpl->assign('tdb_rgb', toRGB( $extcalHelper->getConfig('tdb_rgb')));   
$xoopsTpl->assign('trb_rgb', toRGB( $extcalHelper->getConfig('trb_rgb')));
$xoopsTpl->assign('tdo_rgb', toRGB( $extcalHelper->getConfig('tdo_rgb')));



/*
$xoopsTpl->assign('tdb_rgb', toRGB("#DDDDDD"));   
$xoopsTpl->assign('trb_rgb', toRGB('#505000'));
    $tplCalendar = new \XoopsTpl();
$tplCalendar->assign('tbl_td_backcolor', "#929292");
$tplCalendar->assign('tbl_tr_hover_backcolor', '#FF0000');
$tplCalendar->assign('tbl_td_hover_backcolor', '#00FF000');
//$xoopsTpl->assign('calendar_style',  $tplCalendar->fetch(XOOPS'extcal_view_calendar_style-01.tpl'));
$xoopsTpl->assign('calendar_style',  $tplCalendar->fetch(_EXTCAL_PATH . '/templates/extcal_view_calendar_style-01.tpl'));

global $xoTheme;
$xoTheme->addStylesheet(_EXTCAL_URL. "/include/calendar.css");
*/
    
//  $tbl_td_backcolor
// $tbl_tr_hover_backcolor
// $tbl_td_hover_backcolor


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
$xoopsTpl->assign('view', 'calmonth');


require_once XOOPS_ROOT_PATH . '/footer.php';
