<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<table class="outer">
    <{foreach item=event from=$block}>
    <tr class="<{cycle values=" even,odd"}>">
        <td>
            <a href="<{$xoops_url}>/modules/extcal/event.php?event=<{$event.event_id}>"
               title="<{$event.event_title}>"><{$event.event_title}></a>
        </td>
        <td><{$event.start}></td>
    </tr>
    <{/foreach}>
</table>
