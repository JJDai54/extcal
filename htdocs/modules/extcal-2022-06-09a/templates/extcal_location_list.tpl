<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<{include file="db:extcal_navbar.tpl"}>



<script type="text/javascript">
    function bascule(elem) {
        etat = document.getElementById(elem).style.visibility;
        if (etat == "hidden") {
            document.getElementById(elem).style.visibility = "visible";
        }
        else {
            document.getElementById(elem).style.visibility = "hidden";
        }
    }

    hs.graphicsDir = './assets/js/graphics/';
    hs.outlineType = 'rounded-white';
</script>

<table class="outer" width="100%">
  <tr>
    <th width="40%" align="center"><{$smarty.const._MD_EXTCAL_LOCATION}></th>
    <th width="40%"><{$smarty.const._MD_EXTCAL_LOCATION_ADRESSE}></th>
    <th width="20%"><{$smarty.const._MD_EXTCAL_LOCATION_CONTACT}></th>
    <th width="36px">  </th>
  </tr>

  <{foreach item=location from=$locations}>

      <tr>
        <td >
            <a href="<{$smarty.const.XOOPS_URL}>/modules/extcal/location.php?location_id=<{$location.location_id}>"><{$location.nom}></a>
        </td>

        <td>
            <{$location.adresse}><br>
            <{$location.cp}> <{$location.ville}>
        </td>

        <td>
            <{if $location.tel_fixe}><{$location.tel_fixe}><br><{/if}>
            <{if $location.tel_portable}><{$location.tel_portable}><br><{/if}>
            <{if $location.mail}><A href="mailto:<{$mail}>"><{$location.mail}></A><br><{/if}>

        </td>

        <td>
          <{if $location.map <> ''}>
             <a href="<{$location.map}>">
                <img src="<{$smarty.const.XOOPS_URL}>/Frameworks/moduleclasses/icons/32/globe.png" title="<{$smarty.const._MD_EXTCAL_LOCATION_MAP2}>">
             </a>
          <{/if}>
       </td>
      </tr>
  <{/foreach}>

        <{* **********  afichage de boutns de gestion ******************* *}>
      <tr>
       <th colspan="4">
            <div style="float:left;">
              <{foreach item=button from=$buttons}>
                  <a href="<{$button.url}>"> <img src="<{$button.img}>" title="<{$button.title}>" /> </a>
              <{/foreach}>
            </div>
       </th>
      </tr>


</table>




