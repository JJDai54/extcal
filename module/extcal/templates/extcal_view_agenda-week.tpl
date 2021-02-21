<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<{include file="db:extcal_navbar.tpl"}>
<{include file="db:extcal_event_nav_btn.tpl"}>

<table class="outer" style="border: 1px;">

    <tr style="text-align:left;">
        <td class='<{$trancheHeure.class}>' style="border: 1px solid #808080;" width='50px'>

        </td>
    </tr>


    <{foreach item=trancheHeure key=itemnum from=$agenda}>
        <{if $itemnum==0}>
            <tr style="text-align:left;">
                <th class='<{$trancheHeure.class}>' style="border: 1px solid #808080;" width='50px'>

                </th>
                <{foreach item=jour from=$trancheHeure.jours}>
                    <th class='<{$trancheHeure.class}>' style="border: 1px solid #808080;"
                        width='<{$params.colJourWidth}>%'>
                        <{$jour.jour}><br>
                        <{$jour.caption}>
                    </th>
                <{/foreach}>
            </tr>
        <{/if}>
        <tr style="text-align:left;">
            <td class='<{$trancheHeure.class}>' style="border: 1px solid #808080;" width='50px'>
                <{$trancheHeure.caption}>
            </td>
            <{foreach item=jour from=$trancheHeure.jours}>
                <td class='<{$trancheHeure.class}>' style="border: 1px solid #808080;" width='<{$params.colJourWidth}>%' <{$jour.bg}>>
                    <{foreach item=event key=numEvent from=$jour.events}>
                        <{if $numEvent > 0}><br><{/if}>
                        <{include file="db:extcal_info_bulle.tpl"}>

                    <{/foreach}>
                </td>
            <{/foreach}>
        </tr>
    <{/foreach}>
</table>

<{include file="db:extcal_categorie.tpl"}>

<div style="text-align:right;"><a href="<{$xoops_url}>/modules/extcal/rss.php?cat=<{$selectedCat}>"><img
                src="assets/images/icons/rss.gif" alt="RSS Feed"></a></div>
<{include file='db:system_notification_select.tpl'}>
