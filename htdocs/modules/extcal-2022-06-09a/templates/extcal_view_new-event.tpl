<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<form action="<{$navigSelectBox.action}>" method="<{$navigSelectBox.method}>">
    <{foreach item=element from=$navigSelectBox.elements}>
    <{$element.body}>
    <{/foreach}>
</form>

<{include file="db:extcal_navbar.tpl"}>
<br>
<fieldset class="event_edit_form"> <{*  <legend><{$legend_submit_event}></legend>   *}>
<{$formEdit}>
</fieldset>


<div style="text-align:right;"><a href="<{$xoops_url}>/modules/extcal/rss.php?cat=<{$selectedCat}>">
        <img src="assets/images/icons/rss.gif" alt="RSS Feed">
    </a></div>

<{include file='db:system_notification_select.tpl'}>
