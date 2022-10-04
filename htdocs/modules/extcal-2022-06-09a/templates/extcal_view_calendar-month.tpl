<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>     

<{include file="db:extcal_navbar.tpl"}>
<{include file="db:extcal_view_calendar_style-01.tpl"}>
<{include file="db:extcal_event_nav_btn.tpl"}>

<table class="outer extcal-calendar" width="100%">
    <tr style="text-align:center;" class="head">
        <td></td>
        <{foreach item=weekdayName from=$weekdayNames}>
            <td><{$weekdayName}></td>
        <{/foreach}>
    </tr>
    <{foreach item=row from=$tableRows}>
        <tr>
            <th style="text-align:center; vertical-align:middle;"><a
                        href="<{$params.file}>?year=<{$row.weekInfo.year}>&amp;month=<{$row.weekInfo.month}>&amp;day=<{$row.weekInfo.day}>"><{$row.weekInfo.week}></a>
            </th>
            <{foreach item=cell from=$row.week}>
                <td class="<{if $cell.isEmpty}>empty-cell<{else}>odd<{/if}>"
                    style="width:14%; height:80px; vertical-align:top;<{if $cell.isSelected}> background-color:#B6CDE4;<{/if}>">
<{*
*}>
                    <{if $cell.isEmpty}>&nbsp;
                    <{else}>
                        <a href="<{$xoops_url}>/modules/extcal/view_day.php?year=<{$year}>&amp;month=<{$month}>&amp;day=<{$cell.number}>"><{$cell.number}></a>
                        <br>
                    <{/if}>

                    <{foreach item=event key=itemnum from=$cell.events}>
                        <{if $event}>
                            <{if $itemnum > 0}><br><{/if}>
                            <{include file="db:extcal_info_bulle.tpl"}>
                            <div style="background-color:#<{$event.cat.cat_color}>; height:2px; font-size:2px;">
                                &nbsp;
                            </div>
                        <{/if}>
                    <{/foreach}>
                </td>
            <{/foreach}>
        </tr>
    <{/foreach}>
</table>

<{include file="db:extcal_categorie.tpl"}>

<div style="text-align:right;"><a href="<{$xoops_url}>/modules/extcal/rss.php?cat=<{$selectedCat}>"><img src="assets/images/icons/rss.gif" alt="RSS Feed"></a></div>
<{include file='db:system_notification_select.tpl'}>
