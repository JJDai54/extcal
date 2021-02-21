<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<{*
<script src='<{$smarty.const.XOOPS_URL}>/modules/extcal/assets/js/extcal_highslide.js' type="text/javascript"></script>
*}>
<script src='<{$smarty.const.XOOPS_URL}>/Frameworks/highslide-500/xoops_highslide.js' type="text/javascript"></script>


<{include file="db:extcal_navbar.tpl"}>

<fieldset class="event_edit_form"> <{*  <legend><{$legend_submit_event}></legend>   *}>
<{$formEdit}>
</fieldset>




<{*
<{include file='db:system_notification_select.tpl'}>
*}>






















