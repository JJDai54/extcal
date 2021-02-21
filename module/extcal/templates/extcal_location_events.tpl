<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>


<table class="outer"   width="100%">
    <tr>
        <td>&nbsp;<strong><u><{$smarty.const._MD_EXTCAL_LOCATION_EVENTS_VENIR}></strong></u><br><br>
            <div style="width: 100%; height: 500px; overflow-y: scroll; background-color:#FFFFFF; scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">

                <{foreach item=event from=$events}>
                    <div style="border:1px solid #333333;width:100%">
                        <table width="100%">
                            <tr>
                                <td width="100px" align="center">
                                    <{if $event.event_picture1}>
                                        <a id="<{$event.event_id}>" class="highslide" onclick="return hs.expand(this)"
                                           href="<{$xoops_url}>/uploads/extcal/<{$event.event_picture1}>">
                                           <img align=left
                                                style="border:1px solid #333333;margin-right:6px"
                                                src="<{$xoops_url}>/uploads/extcal/<{$event.event_picture1}>"
                                                width="100px" height="100px">
                                        </a>
                                    <{elseif $smarty.const._EXTCAL_SHOW_NO_PICTURE}>
                                        <img align=left style="border:1px solid #333333;margin-right:6px"
                                             src="<{$xoops_url}>/modules/extcal/assets/images/no_picture.png" width="100px" height="100px">
                                    <{/if}>
                                </td>
                                <td><u><strong><a href="./event.php?event=<{$event.event_id}>"><{$event.event_title}></a></strong></u>&nbsp;&nbsp;( <{$event.event_start}>
                                    )<br><br><{$event.event_desc}></td>
                            </tr>
                        </table>
                    </div>
                <{/foreach}>
            </div>
        </td>
    </tr>
</table>
