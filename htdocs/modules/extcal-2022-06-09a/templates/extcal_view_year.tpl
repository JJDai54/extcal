<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<{include file="db:extcal_navbar.tpl"}>

<{include file="db:extcal_view_calendar_style-01.tpl"}>

<{include file="db:extcal_event_nav_btn.tpl"}>

<{include file="db:extcal_event_list1.tpl"}>

<{include file="db:extcal_categorie.tpl"}>

<div style="text-align:right;"><a
            href="<{$xoops_url}>/modules/extcal/rss.php?cat=<{$selectedCat}>"><img
                src="assets/images/icons/rss.gif" alt="RSS Feed"></a></div>
<{include file='db:system_notification_select.tpl'}>
