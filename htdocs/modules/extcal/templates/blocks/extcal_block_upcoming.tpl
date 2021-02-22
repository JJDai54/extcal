<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>
<{assign var='showDateDeb' value=$showDateDeb|default:1}>

<table class="outer" width="100%">
    <{foreach item=event from=$block}>
    <tr class="<{cycle values="even, odd"}>">
        <td>
<{*
            <{$event.formated_event_start}>
            <{if $event.formated_event_start != $event.formated_event_end}> - <{$event.formated_event_end}>
                <br>
            <{/if}>

            <div style="height:24px; width:12px; background-color:#<{$event.cat.cat_color}>; border:thin solid #000000; float:left; margin-right:5px;opacity:1"></div>

            <a href="<{$xoops_url}>/modules/extcal/event.php?event=<{$event.event_id}>"
               title="<{$event.event_title}>"><{$event.event_title}>
            </a>
*}>
            <{include file="db:extcal_info_bulle.tpl"}>
        </td>
    </tr>
    <{/foreach}>
</table>
