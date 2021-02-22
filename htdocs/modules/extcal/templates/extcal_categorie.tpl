<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<table class="outer" width="100%">

    <tr>
        <th>

            <div style="float:left; margin-left:5px;">
                <div style="float:left; background-color:#FFFFFF; border:1px solid #ffffff; margin-right:5px;">&nbsp;</div>
                <a href="<{$smarty.const.XOOPS_URL}>/<{$smarty.server.SCRIPT_NAME}>"><{$smarty.const._MD_EXTCAL_ALL_CAT}></a>
            </div>


            <{foreach item=cat from=$cats}>
                <div style="float:left; margin-left:5px;">
                    <div style="float:left; background-color:#<{$cat.cat_color}>; border:1px solid #ffffff; margin-right:5px;">&nbsp;</div>
                    <a href="<{$smarty.const.XOOPS_URL}>/<{$smarty.server.SCRIPT_NAME}>?cat=<{$cat.cat_id}>"><{$cat.cat_name}></a>
                </div>
            <{/foreach}>
        </th>
    </tr>
</table>
