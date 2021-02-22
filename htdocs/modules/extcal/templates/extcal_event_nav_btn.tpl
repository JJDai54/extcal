<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<style type="text/css">
.extcalTdTitle{
  /* background-color: #c8e4ad; */
  border: 1px solid black;
  border:none;
}

.extcalTdTitle td{
  /* background-color: #c8e4ad; */
  border: 0px;
  border:none;
  valign:middle;
  height:40px;
}



.extcalTdTitle  td:hover{

  background-color: #FFB9B9;
   opacity:1;

}
</style>

<table class="outer extcalTdTitle" style="border-top: none;" width="100%">
  <tr style="text-align:center;">
      <td>
          <a href="<{$xoops_url}>/modules/extcal/<{$params.file}>?<{$navig.prev.uri}>">
              <img src="<{$smarty.const._EXTCAL_IMG}>fleches/vert/fleche-gauche.png" height='24px'>
              <{* <br><{$navig.prev.name}> *}>
          </a>
      </td>
      <td width="40%">
          <span style="font-weight:bold;font-size:1.8em"><{$navig.this.name}></span>
      </td>
      <td>
          <a href="<{$xoops_url}>/modules/extcal/<{$params.file}>?<{$navig.next.uri}>">
              <img src="<{$smarty.const._EXTCAL_IMG}>fleches/vert/fleche-droite.png" height='24px'>
              <{* <br><{$navig.next.name}> *}>
          </a>
      </td>
  </tr>
</table>





