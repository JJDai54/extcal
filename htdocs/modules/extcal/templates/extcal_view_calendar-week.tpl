<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<{include file="db:extcal_navbar.tpl"}>
<{include file="db:extcal_view_calendar_style-01.tpl"}>
<{include file="db:extcal_event_nav_btn.tpl"}>

<table class="outer extcal-calendar" style="border-top: none;">
    <tr style="text-align:center;" class="head">
        <{foreach item=weekdayName from=$weekdayNames}>
            <td><{$weekdayName}></td>
        <{/foreach}>
    </tr>
    <tr>
        <{foreach item=day from=$week}>
            <td class="<{if $day.isEmpty}>even<{else}>odd<{/if}>"
                style="width:14%; height:80px; vertical-align:top;<{if $day.isSelected}> background-color:#B6CDE4;<{/if}>">
                <{if $day.isEmpty}>&nbsp;<{else}>
                    <a href="<{$xoops_url}>/modules/extcal/view_day.php?year=<{$day.year}>&amp;month=<{$day.month}>&amp;day=<{$day.dayNumber}>"><{$day.dayNumber}></a>
                <{/if}>
                <br>
                <{foreach item=event key=itemnum from=$day.events}>
                    <{if $event}>
                        <{if $itemnum > 0}><br><{/if}>
                        <{include file="db:extcal_info_bulle.html"}>
                        <div style="background-color:#<{$event.cat.cat_color}>; height:2px; font-size:2px;">
                            &nbsp;</div>
                    <{/if}>
                <{/foreach}>
            </td>
        <{/foreach}>
    </tr>
</table>

<{include file="db:extcal_categorie.tpl"}>

<div style="text-align:right;"><a href="<{$xoops_url}>/modules/extcal/rss.php?cat=<{$selectedCat}>"><img src="assets/images/icons/rss.gif" alt="RSS Feed"></a></div>
<{include file='db:system_notification_select.tpl'}>
