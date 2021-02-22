<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<table class="outer extcal-calendar" style="border-top: none;" width="100%">
    <{foreach item=event from=$events}>
        <tr class="<{cycle values=" even,odd"}>">
            <td class="odd" style="vertical-align:middle;" width='100px'>
                <{$event.formated_event_start}>&nbsp;&nbsp;
            </td>
            <td class="odd" style="vertical-align:middle;" width='100px'>
                <{$event.formated_event_end}>&nbsp;&nbsp;
            </td>
            <td class="odd" style="vertical-align:middle;">

                <{include file="db:extcal_info_bulle.tpl"}>


            </td>
            <td class="odd" style="vertical-align:middle;">
                <{$event.location.nom}>&nbsp;&nbsp;
            </td>
            <td class="odd" style="vertical-align:middle;">
                <{include file="db:extcal_buttons_event.tpl"}>
            </td>
        </tr>
    <{/foreach}>
</table>
