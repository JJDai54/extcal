<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<div id='div_to_mask_title' name='div_to_mask_title' style='display:none;'></div>
<script>
jQuery(document).ready(function(){
      $("#div_to_mask_title").parent().children('h4:first').html('');
});
</script>

<style>
table {
  border-collapse: collapse;
  background-color: rgba(219, 219, 219, .5);
}

table, th, td {
  border: 1px solid black;
}
</style>

<table  id='extcal_minical' name='extcal_minical' class="outer" <{if $block.bgColor !=''}>bgcolor='<{$block.bgColor}>'<{/if}>
       style="width:100%; text-align:center; vertical-align:middle;">
    <{if $block.horloge.display}>
        <tr>
            <td colspan="7" style="font-weight:bold;">
                <{include file="db:extcal_horloge.tpl"}>
            </td>
        </tr>
    <{/if}>

    <tr>
        <td colspan="7" style="font-weight:bold;">

            <{* En prevision
            <a href="<{$xoops_url}>/modules/extcal/<{$block.navig.page}>?<{$block.navig.uri}>">
              &nbsp;<img border="0" src="<{$smarty.const.XOOPS_URL}>/modules/extcal/assets/images/arrows/previous.png">
            </a>
             *}>
            <a href="<{$xoops_url}>/modules/extcal/<{$block.navig.page}>?<{$block.navig.uri}>">
                <{$block.navig.name}>
            </a>
            <{* En prevision
              <a href="<{$xoops_url}>/modules/extcal/<{$block.navig.page}>?<{$block.navig.uri}>">
              &nbsp;<img border="0" src="<{$smarty.const.XOOPS_URL}>/modules/extcal/assets/images/arrows/next.png">
            </a>
             *}>
        </td>


    </tr>
    <{if $block.imageParam.displayImage}>
        <tr>
            <td colspan="7" height="150px">
                <{include file="db:extcal_imgXoops.tpl"}>
            </td>
        </tr>
    <{/if}>
    
    <h4 class="block-title"><a href="<{$xoops_url}>/modules/extcal/<{$block.navig.page}>?<{$block.navig.uri}>"><{$smarty.const._MB_EXTCAL_VIEW_PLANNING}>
        &nbsp;<img border="0" src="<{$smarty.const.XOOPS_URL}>/modules/extcal/assets/images/fleches/vert/fleche-droite.png" height="15px"></a>
    </h4>
                                                                                                                                                                                 
    <{if $block.displayLink == 1}>
        <tr>
            <td colspan="7">
                <img src="<{$xoops_url}>/modules/extcal/assets/images/icons/addevent.gif"
                     alt="Add event"> <a href="<{$xoops_url}>/modules/extcal/view_new-event.php"><{$block.submitText}></a>
            </td>
        </tr>
    <{/if}>
    <tr style="font-weight:bold;font-size: 0.9em;">
        <{foreach item=day from=$block.weekdayNames}>
            <td><{$day}></td>
        <{/foreach}>
    </tr>
    <{foreach item=weeks from=$block.tableRows}>
        <tr>
            <{foreach item=day from=$weeks.week}>
                <td <{if $day.isSelected}> style="border:1px solid #0099FF;"<{/if}> >
                    <{if !$day.isEmpty}>
                        <{if $day.haveEvents}>
                            <a href="<{$xoops_url}>/modules/extcal/view_day.php?year=<{$weeks.weekInfo.year}>&amp;month=<{$weeks.weekInfo.month}>&amp;day=<{$day.number}>"
                               style="color:#<{$day.color}>; font-weight:bold;">
                                <{$day.number}>
                            </a>
                        <{else}>
                            <{$day.number}>
                        <{/if}>
                    <{else}>
                        &nbsp;
                    <{/if}>
                </td>
            <{/foreach}>
        </tr>
    <{/foreach}>
</table>

<{if $block.saint.show == 1}>
  <div width="100%"><{$block.saint.name}></div>
<{/if}>






  
