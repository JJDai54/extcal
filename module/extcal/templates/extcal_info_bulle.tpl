<{assign var='showInfoBulle' value=$showInfoBulle|default:1}>

<{if $showInfoBulle}>
    <a class="tooltip54 tooltip54Font" href="<{$xoops_url}>/modules/extcal/event.php?event=<{$event.event_id}>">

    <div style="height:12px; width:12px; background-color:#<{$event.cat.cat_color}>; border:1px solid #000000; float:left; margin-right:5px;opacity:1">
    </div>
        <{if $showId}>(#<{$event.event_id}>)<{/if}> <{if $showDateDeb}><{$event.formated_event_start}><{/if}> <{$event.event_title}><br>
        <span class="custom info" width350 style="background: #<{$event.cat.cat_light_color}>;opacity:1">
          <{if $event.event_icone}><img src="<{$smarty.const.XOOPS_URL}>/modules/extcal/assets/css/images/<{$event.event_icone}>"  alt="" iconinfo>
          <{elseif $event.cat.cat_icone}><img src="assets/css/images/<{$event.cat.cat_icone}>"  alt="" iconinfo>
          <{/if}>

            <em><{if $showId}>(#<{$event.event_id}>)<{/if}> <{$event.event_title}></em>
            <{if $event.event_picture1!=""}>
                <img src="<{$smarty.const.XOOPS_URL}>/uploads/extcal/<{$event.event_picture1}>" alinea>
            <{/if}>
            <em>
              <b><{$smarty.const._MD_EXTCAL_START}></b> : <{$event.formated_event_start_infobulle}><br>
              <b><{$smarty.const._MD_EXTCAL_END}></b> : <{$event.formated_event_end_infobulle}>
              <{if $event.location <> ''}><br><{$smarty.const._MD_EXTCAL_LOCATION}></b> : <{$event.location.nom}><{/if}>
            </em>

      </span>
    </a>
<{else}>
    <a href="<{$xoops_url}>/modules/extcal/event.php?event=<{$event.event_id}>">
        <{if $showId}>(#<{$event.event_id}>)<{/if}> <{$event.event_title}>
    </a>
    <div style="height:12px; width:12px; background-color:#<{$event.cat.cat_color}>; border:1px solid #000000; float:left; margin-right:5px;"

         title='<{if $showId}>(#<{$event.event_id}>)<{/if}>  <{$event.formated_event_start}> - <{$event.formated_event_end}> : <{$event.event_title}>'>
    </div>
<{/if}>
