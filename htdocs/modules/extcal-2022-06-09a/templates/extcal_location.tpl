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

    <form action="<{$navigSelectBox.action}>" method="<{$navigSelectBox.method}>" class="head">
    <div class="extcalBgTabs">
        <{foreach item=element from=$navigSelectBox.elements}>
            <{$element.body}>
        <{/foreach}>
    </div>
    </form>

<hr>
<table class="outer" width="100%">


        <{* **********  afichage de boutns de gestion *******************
    <tr>
        <th colspan="3" style="font-size:1.2em;">
            <div style="float:right;">
              <{foreach item=button from=$buttons}>
                  <a href="<{$button.url}>"> <img src="<{$button.img}>" title="<{$button.title}>" /> </a>
              <{/foreach}>
            </div>
        </th>
    </tr>
        *}>

        <{* **********  afichage de location ******************* *}>

    <tr>
        <td colspan="3" class="odd" style="padding-right:30px; padding-top:10px;">
            <div style="padding-right:0;">
                <{if $location.logo}>
                    <a id="<{$id}>" class="highslide" onclick="return hs.expand(this, {maxWidth:600})"
                       href="<{$smarty.const.XOOPS_URL}>/uploads/extcal/location/<{$location.logo}>">
                        <img align=right style="border:1px solid #FFFFFF;margin-right:6px;"
                             src="<{$smarty.const.XOOPS_URL}>/uploads/extcal/location/thumbs/<{$location.logo}>"
                             height="150px">
                    </a>
                <{elseif $smarty.const._EXTCAL_SHOW_NO_PICTURE}>
                    <img align=right style="border:1px solid #FFFFFF;margin-right:6px;"
                         src="<{$smarty.const.XOOPS_URL}>/modules/extcal/assets/images/no_picture.png" width="180"
                         height="180">
                <{/if}>
            </div>
            <div style="font-size:16px; font-weight:bold; width:280px; overflow:hidden; margin-left:30px;">
                <span style="text-decoration: underline;"><{$location.nom}></span><br>

                <div style="font-size:14px; ">
                    <{if $location.categorie}><{$location.categorie}><br><{/if}>
                    <{if $location.adresse}><{$location.adresse}><br><{/if}>
                    <{if $location.adresse2}><{$location.adresse2}><br><{/if}>
                    <{if $location.cp}><{$location.cp}><{/if}>
                    - <{if $location.ville}><{$location.ville}><br><{/if}>
                    <{if $location.map!=''}>
                        <a href="<{$location.map}>"
                           target="_blank"><{$smarty.const._MD_EXTCAL_LOCATION_MAP2}></a>
                        <br>
                    <{/if}>

                    <{if $location.tel_fixe}><{$location.tel_fixe}><br><{/if}>
                    <{if $location.tel_portable}><{$location.tel_portable}><br><{/if}>
                    <{if $location.mail}><A href="mailto:<{$mail}>"><{$location.mail}></A><br><{/if}>
                    <{if $location.site}><a href="<{$location.site}>"
                                                 target="_blank"><{$smarty.const._MD_EXTCAL_VISIT_SITE}></a>
                        <br>
                    <{/if}>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td>
<div style=" overflow:hidden;  font-weight:bold; margin-left:30px; text-align:left;">
    <strong style="text-decoration: underline;"><{$smarty.const._MD_EXTCAL_LOCATION_INFO_COMPL}></strong></u>
    <br><br>
    <{if $location.description}><{$location.description}><br><br><{/if}>
    <{if $location.horaires}><{$location.horaires}><br><{/if}>
    <{if $location.tarifs}><{$location.tarifs}>&nbsp; <{$smarty.const._MD_EXTCAL_DEVISE2}><br><{/if}>
    <{if $location.divers}><{$location.divers}><br><{/if}>
</div>
        </td>
    </tr>

    <tr>
        <{* **********  afichage de boutns de gestion ******************* *}>
        <th style="font-size:1.2em;">
            <div style="float:left;">&nbsp;
              <{foreach item=button from=$buttons}>
                  <a href="<{$button.url}>">&nbsp;<img src="<{$button.img}>" title="<{$button.title}>" />&nbsp;</a>
              <{/foreach}>
            </div>
        </th>
    </tr>
</table>

<hr>

<{if count($events) > 0}>
  <{include file="db:extcal_location_events.tpl"}>
<{/if}>


<div id="map" align="center" style="visibility: hidden;"><br>
    <{$map}>
</div>
<p style="text-align:right;">
    <{foreach item=eventFile from=$event_attachement}>
        <a href="download_attachement.php?file=<{$eventFile.file_id}>"><{$eventFile.file_nicename}>
            (<i><{$eventFile.file_mimetype}></i>) <{$eventFile.formated_file_size}></a>
        <br>
    <{/foreach}>
</p><br>
<div class="highslide-caption"></div>


