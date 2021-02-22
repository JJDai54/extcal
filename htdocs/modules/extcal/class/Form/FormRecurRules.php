<?php

namespace XoopsModules\Extcal\Form;

use  XoopsModules\Extcal;

/**
 * Class FormRecurRules.
 */
class FormRecurRules extends \XoopsFormElement
{
    // Initial value form reccur form
    public $_rrule_freq             = 'none';
    public $_rrule_daily_interval   = '';
    public $_rrule_weekly_interval  = '';
    public $_rrule_weekly_bydays    = '';
    public $_rrule_monthly_interval = '';
    public $_rrule_monthly_byday    = '';
    public $_rrule_bymonthday       = '';
    public $_rrule_yearly_interval  = '';
    public $_rrule_yearly_bymonths  = '';
    public $_rrule_yearly_byday     = '';

    public $startDateValue = '';
    public $endDateValue   = '';

    /**
     * @param $values
     */
    public function __construct($values)
    {
        if (isset($values['rrule_freq'])) {
            $this->_rrule_freq = $values['rrule_freq'];
        }
        if (isset($values['rrule_daily_interval'])) {
            $this->_rrule_daily_interval = $values['rrule_daily_interval'];
        }
        if (isset($values['rrule_weekly_interval'])) {
            $this->_rrule_weekly_interval = $values['rrule_weekly_interval'];
        }
        if (isset($values['rrule_weekly_bydays'])) {
            $this->_rrule_weekly_bydays = $values['rrule_weekly_bydays'];
        }
        if (isset($values['rrule_monthly_interval'])) {
            $this->_rrule_monthly_interval = $values['rrule_monthly_interval'];
        }
        if (isset($values['rrule_monthly_byday'])) {
            $this->_rrule_monthly_byday = $values['rrule_monthly_byday'];
        }
        if (isset($values['rrule_bymonthday'])) {
            $this->_rrule_bymonthday = $values['rrule_bymonthday'];
        }
        if (isset($values['rrule_yearly_interval'])) {
            $this->_rrule_yearly_interval = $values['rrule_yearly_interval'];
        }
        if (isset($values['rrule_yearly_bymonths'])) {
            $this->_rrule_yearly_bymonths = $values['rrule_yearly_bymonths'];
        }
        if (isset($values['rrule_yearly_byday'])) {
            $this->_rrule_yearly_byday = $values['rrule_yearly_byday'];
        }


        if (isset($values['startDateValue'])) {
            $this->startDateValue = $values['startDateValue'];
        }
        if (isset($values['endDateValue'])) {
            $this->endDateValue = $values['endDateValue'];
        }

    }

    /**
     * prepare HTML for output.
     *
     * @return string
     */
    public function render()
    {
        $ret = '';
//$recur_ = new \XoopsFormElementTray(_MD_EXTCAL_PRICE, '');

// $recur_no_event = new \XoopsFormElementTray("zzzzzzzz", '',"class='recur-hidden'" );
// $recur_no_event->addElement($formObject);

        //$ret .= '<br><br><fieldset><legend>' . _MD_EXTCAL_RECCUR_POLICY . '</legend>';
        $ret .= '<fieldset id="type_reccurence" name="type_reccurence" class="type_recurrence"><legend>' . _MD_EXTCAL_RECCUR_POLICY . '</legend>';

        $formObject = new \XoopsFormRadio('', 'rrule_freq', $this->_rrule_freq);
        $formObject->addOption('none', _MD_EXTCAL_NO_RECCUR);
        $formObject->setExtra("onclick=\"show_fieldset(this,'fs_reccurence', 'recur_no');\"" );
        $ret .= $formObject->render();
        //$ret .= "<br>";

        $formObject = new \XoopsFormRadio('', 'rrule_freq', $this->_rrule_freq);
        $formObject->addOption('daily', _MD_EXTCAL_DAILY);
        //$formObject->setExtra("zzz='yes' onclick=\"show_fieldset(this,'recur_no', 'recur_day');\"");
        $formObject->setExtra("onclick=\"show_fieldset(this,'fs_reccurence', 'recur_dayly');\"" );
        $ret .= $formObject->render();

        $formObject = new \XoopsFormRadio('weekly', 'rrule_freq', $this->_rrule_freq);
        $formObject->addOption('weekly', _MD_EXTCAL_WEEKLY);
        $formObject->setExtra("onclick=\"show_fieldset(this,'fs_reccurence', 'recur_weekly');\"");
        $ret .= $formObject->render();

        $formObject = new \XoopsFormRadio('', 'rrule_freq', $this->_rrule_freq);
        $formObject->addOption('monthly', _MD_EXTCAL_MONTHLY);
        $formObject->setExtra("onclick=\"show_fieldset(this,'fs_reccurence', 'recur_monthly');\"");
        $ret .= $formObject->render();

        $formObject = new \XoopsFormRadio('', 'rrule_freq', $this->_rrule_freq);
        $formObject->addOption('yearly', _MD_EXTCAL_YEARLY);
        $formObject->setExtra("onclick=\"show_fieldset(this,'fs_reccurence', 'recur_yearly');\"");
        $ret .= $formObject->render();

        $ret .= "<br><br>";

//============================================================================
        $fsVisible = ($this->_rrule_freq == 'none') ? 'recur-visible' : 'recur-hidden';
//echo "<hr>{}<hr>";
// Pas de recurrence
        $ret .= '<fieldset id="recur_no" name="recur_no" class="type_recurrence ' . $fsVisible . '"><legend>' . _MD_EXTCAL_NO_RECCUR_EVENT . '</legend>';
/*
        $formObject = new   Extcal\Form\FormDateTimeInput($this->startDateValue, $this->endDateValue);
        //$formObject = new Extcal\Form\FormDateTime($dateDebEnd, $this->startDateValue, $this->endDateValue); //mb
        $ret .= $formObject->render();
        $ret .= '<br><br>';
*/

        $formObject = new \XoopsFormLabel('', _MD_EXTCAL_EVENT_PONCTUEL );
        $formObject->setExtra("width='60%'");
        $ret .= $formObject->render();
        $ret .= '</fieldset>';

// recurence journaliere
        $fsVisible = ($this->_rrule_freq == 'dayly') ? 'recur-visible' : 'recur-hidden';
        $ret .= '<fieldset id="recur_dayly" name="recur_dayly" class="type_recurrence ' . $fsVisible . '"><legend>' . _MD_EXTCAL_DAILY .'</legend>';

//         $formObject = new \XoopsFormLabel('',  _MD_EXTCAL_DURING );
//         $formObject->setExtra("style='display:inline'");
//         $ret .= $formObject->render() . ' ';

        $formObject = new \XoopsFormText('', 'rrule_daily_interval', 3, 2, $this->_rrule_daily_interval);
        $formObject->setExtra("style='width:50px;display:inline'");
        $ret        .=_MD_EXTCAL_DURING . " " . $formObject->render() . ' ' . _MD_EXTCAL_DAYS;
        $ret        .= '</fieldset>';

// recurence hebdomadaire
        $fsVisible = ($this->_rrule_freq == 'weekly') ? 'recur-visible' : 'recur-hidden';
        $ret        .= '<fieldset id="recur_weekly" name="recur_weekly" class="type_recurrence ' . $fsVisible . '"><legend>' . _MD_EXTCAL_WEEKLY . '</legend>';
//         $ret .=  _MD_EXTCAL_DURING . ' ';
//         $ret .= "&nbsp;";

        $formObject = new \XoopsFormText('', 'rrule_weekly_interval', 3, 2, $this->_rrule_weekly_interval);
        $formObject->setExtra("style='width:50px;display:inline'");
        $ret        .= _MD_EXTCAL_DURING . ' ' . $formObject->render(). ' ' . _MD_EXTCAL_WEEKS . '<br>';

        $formObject = new \XoopsFormCheckBox('', 'rrule_weekly_bydays', $this->_rrule_weekly_bydays);
        $formObject->addOption('MO', _MD_EXTCAL_MO2 . '&nbsp;');
        $formObject->addOption('TU', _MD_EXTCAL_TU2 . '&nbsp;');
        $formObject->addOption('WE', _MD_EXTCAL_WE2 . '&nbsp;');
        $formObject->addOption('TH', _MD_EXTCAL_TH2 . '&nbsp;');
        $formObject->addOption('FR', _MD_EXTCAL_FR2 . '&nbsp;');
        $formObject->addOption('SA', _MD_EXTCAL_SA2 . '&nbsp;');
        $formObject->addOption('SU', _MD_EXTCAL_SU2 . '&nbsp;');
        $ret .= $formObject->render();
        $ret .= '</fieldset>';

// recurence mensuel
        $fsVisible = ($this->_rrule_freq == 'monthly') ? 'recur-visible' : 'recur-hidden';
        $ret        .= '<fieldset id="recur_monthly" name="recur_monthly" class="type_recurrence ' . $fsVisible . '"><legend>' . _MD_EXTCAL_MONTHLY . '</legend>';
//         $formObject = new \XoopsFormLabel('',_MD_EXTCAL_DURING );
//         $ret .= $formObject->render() . ' ';

        $formObject = new \XoopsFormText('', 'rrule_monthly_interval', 3, 2, $this->_rrule_monthly_interval);
        $formObject->setExtra("style='width:50px;display:inline'");
        $ret        .= _MD_EXTCAL_DURING . ' ' . $formObject->render() . ' ' . _MD_EXTCAL_MONTH;
        $ret        .= ', ' . _MD_EXTCAL_ON . ' ';






        $formObject = new \XoopsFormSelect('', 'rrule_monthly_byday', $this->_rrule_monthly_byday);
        $formObject->setExtra("style='width:200px;display:inline'");
        $formObject->addOption('', '&nbsp;');
        $formObject->addOption('+1MO', _MD_EXTCAL_1_MO);
        $formObject->addOption('+1TU', _MD_EXTCAL_1_TU);
        $formObject->addOption('+1WE', _MD_EXTCAL_1_WE);
        $formObject->addOption('+1TH', _MD_EXTCAL_1_TH);
        $formObject->addOption('+1FR', _MD_EXTCAL_1_FR);
        $formObject->addOption('+1SA', _MD_EXTCAL_1_SA);
        $formObject->addOption('+1SU', _MD_EXTCAL_1_SU);
        $formObject->addOption('+2MO', _MD_EXTCAL_2_MO);
        $formObject->addOption('+2TU', _MD_EXTCAL_2_TU);
        $formObject->addOption('+2WE', _MD_EXTCAL_2_WE);
        $formObject->addOption('+2TH', _MD_EXTCAL_2_TH);
        $formObject->addOption('+2FR', _MD_EXTCAL_2_FR);
        $formObject->addOption('+2SA', _MD_EXTCAL_2_SA);
        $formObject->addOption('+2SU', _MD_EXTCAL_2_SU);
        $formObject->addOption('+3MO', _MD_EXTCAL_3_MO);
        $formObject->addOption('+3TU', _MD_EXTCAL_3_TU);
        $formObject->addOption('+3WE', _MD_EXTCAL_3_WE);
        $formObject->addOption('+3TH', _MD_EXTCAL_3_TH);
        $formObject->addOption('+3FR', _MD_EXTCAL_3_FR);
        $formObject->addOption('+3SA', _MD_EXTCAL_3_SA);
        $formObject->addOption('+3SU', _MD_EXTCAL_3_SU);
        $formObject->addOption('+4MO', _MD_EXTCAL_4_MO);
        $formObject->addOption('+4TU', _MD_EXTCAL_4_TU);
        $formObject->addOption('+4WE', _MD_EXTCAL_4_WE);
        $formObject->addOption('+4TH', _MD_EXTCAL_4_TH);
        $formObject->addOption('+4FR', _MD_EXTCAL_4_FR);
        $formObject->addOption('+4SA', _MD_EXTCAL_4_SA);
        $formObject->addOption('+4SU', _MD_EXTCAL_4_SU);
        $formObject->addOption('-1MO', _MD_EXTCAL_LAST_MO);
        $formObject->addOption('-1TU', _MD_EXTCAL_LAST_TU);
        $formObject->addOption('-1WE', _MD_EXTCAL_LAST_WE);
        $formObject->addOption('-1TH', _MD_EXTCAL_LAST_TH);
        $formObject->addOption('-1FR', _MD_EXTCAL_LAST_FR);
        $formObject->addOption('-1SA', _MD_EXTCAL_LAST_SA);
        $formObject->addOption('-1SU', _MD_EXTCAL_LAST_SU);
        $ret .= $formObject->render();
        $ret .= ' ' . _MD_EXTCAL_OR_THE . ' ';
        $formObject = new \XoopsFormText('', 'rrule_bymonthday', 3, 2, $this->_rrule_bymonthday);
        $formObject->setExtra("style='width:50px;display:inline'");
        $ret        .= $formObject->render();
        $ret        .= ' ' . _MD_EXTCAL_DAY_NUM_MONTH;
        $ret .= '</fieldset>';

//========================================================================
// recurence annuel
        $fsVisible = ($this->_rrule_freq == 'yearly') ? 'recur-visible' : 'recur-hidden';
        $ret        .= '<fieldset id="recur_yearly" name="recur_yearly" class="type_recurrence ' . $fsVisible . '"><legend>' . _MD_EXTCAL_YEARLY . '</legend>';
//         $formObject = new \XoopsFormLabel('',_MD_EXTCAL_DURING );
//         $ret .= $formObject->render() . ' ';

        $formObject = new \XoopsFormText('', 'rrule_yearly_interval', 3, 2, $this->_rrule_yearly_interval);
        $formObject->setExtra("style='width:50px;display:inline'");
        $ret        .= _MD_EXTCAL_DURING . ' ' . $formObject->render();
        $ret        .= ' ' . _MD_EXTCAL_YEARS . '<br><br>';

        //$formObject = new \XoopsFormCheckBox('', 'rrule_weekly_bydays', $this->_rrule_weekly_bydays);
        //$formObject = new \XoopsFormCheckBox('', 'rrule_yearly_bymonths', $this->_rrule_yearly_bymonths,4);
        $formObject = new Extcal\Form\FormRRuleCheckBox('', 'rrule_yearly_bymonths', $this->_rrule_yearly_bymonths);
        $formObject->setExtra ('style="padding:5px"');
//        $formObject->setExtra ('width="100%"');
//        $formObject->setExtra("style='width:300px");
        $formObject->addOption('1', _MD_EXTCAL_JAN);
        $formObject->addOption('2', _MD_EXTCAL_FEB);
        $formObject->addOption('3', _MD_EXTCAL_MAR);
        $formObject->addOption('4', _MD_EXTCAL_APR);
        $formObject->addOption('5', _MD_EXTCAL_MAY);
        $formObject->addOption('6', _MD_EXTCAL_JUN);
        $formObject->addOption('7', _MD_EXTCAL_JUL);
        $formObject->addOption('8', _MD_EXTCAL_AUG);
        $formObject->addOption('9', _MD_EXTCAL_SEP);
        $formObject->addOption('10', _MD_EXTCAL_OCT);
        $formObject->addOption('11', _MD_EXTCAL_NOV);
        $formObject->addOption('12', _MD_EXTCAL_DEC);
        $ret .= $formObject->render();
        $ret .= '<br>';

        $ret .=_MD_EXTCAL_ON . ' ';
        $formObject = new \XoopsFormSelect('', 'rrule_yearly_byday', $this->_rrule_yearly_byday);
        $formObject->setExtra("style='width:200px;display:inline'");
        $formObject->addOption('', _MD_EXTCAL_SAME_ST_DATE);
        $formObject->addOption('+1MO', _MD_EXTCAL_1_MO);
        $formObject->addOption('+1TU', _MD_EXTCAL_1_TU);
        $formObject->addOption('+1WE', _MD_EXTCAL_1_WE);
        $formObject->addOption('+1TH', _MD_EXTCAL_1_TH);
        $formObject->addOption('+1FR', _MD_EXTCAL_1_FR);
        $formObject->addOption('+1SA', _MD_EXTCAL_1_SA);
        $formObject->addOption('+1SU', _MD_EXTCAL_1_SU);
        $formObject->addOption('+2MO', _MD_EXTCAL_2_MO);
        $formObject->addOption('+2TU', _MD_EXTCAL_2_TU);
        $formObject->addOption('+2WE', _MD_EXTCAL_2_WE);
        $formObject->addOption('+2TH', _MD_EXTCAL_2_TH);
        $formObject->addOption('+2FR', _MD_EXTCAL_2_FR);
        $formObject->addOption('+2SA', _MD_EXTCAL_2_SA);
        $formObject->addOption('+2SU', _MD_EXTCAL_2_SU);
        $formObject->addOption('+3MO', _MD_EXTCAL_3_MO);
        $formObject->addOption('+3TU', _MD_EXTCAL_3_TU);
        $formObject->addOption('+3WE', _MD_EXTCAL_3_WE);
        $formObject->addOption('+3TH', _MD_EXTCAL_3_TH);
        $formObject->addOption('+3FR', _MD_EXTCAL_3_FR);
        $formObject->addOption('+3SA', _MD_EXTCAL_3_SA);
        $formObject->addOption('+3SU', _MD_EXTCAL_3_SU);
        $formObject->addOption('+4MO', _MD_EXTCAL_4_MO);
        $formObject->addOption('+4TU', _MD_EXTCAL_4_TU);
        $formObject->addOption('+4WE', _MD_EXTCAL_4_WE);
        $formObject->addOption('+4TH', _MD_EXTCAL_4_TH);
        $formObject->addOption('+4FR', _MD_EXTCAL_4_FR);
        $formObject->addOption('+4SA', _MD_EXTCAL_4_SA);
        $formObject->addOption('+4SU', _MD_EXTCAL_4_SU);
        $formObject->addOption('-1MO', _MD_EXTCAL_LAST_MO);
        $formObject->addOption('-1TU', _MD_EXTCAL_LAST_TU);
        $formObject->addOption('-1WE', _MD_EXTCAL_LAST_WE);
        $formObject->addOption('-1TH', _MD_EXTCAL_LAST_TH);
        $formObject->addOption('-1FR', _MD_EXTCAL_LAST_FR);
        $formObject->addOption('-1SA', _MD_EXTCAL_LAST_SA);
        $formObject->addOption('-1SU', _MD_EXTCAL_LAST_SU);
        $ret .= $formObject->render();
        $ret        .= ' ' . _MD_EXTCAL_DAY_NUM_MONTH;
        $ret .= '</fieldset>';

//fermeture du fieldset principal
        $ret .= '</fieldset>';
        return $ret;
    }
}
