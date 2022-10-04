<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<style type="text/css">
.empty-cell {
  background-image: repeating-linear-gradient(-45deg,
      transparent,
      transparent 10px,
      #999999 15px,
      black 1px);
}


<{if $css_extcal == 1}>


.extcal-calendar td {
  border-collapse: collapse;
  border: 1px solid #808080;

  background-color: rgba(<{$tdb_rgb.R}>, <{$tdb_rgb.G}>, <{$tdb_rgb.B}>, 0.4);
}


.extcal-calendar tr:hover {
  background-color: rgba(<{$trb_rgb.R}>, <{$trb_rgb.G}>, <{$trb_rgb.B}>, 1);

  }
  
.extcal-calendar td:hover {

  background-color: rgba(<{$tdo_rgb.R}>, <{$tdo_rgb.G}>, <{$tdo_rgb.B}>, 1);
  }
  
  
 .extcal-calendar tr.even {
    background: #FAFAFA;
}

.extcal-calendar tr.odd {
    background: #F6F6F6;
}
<{/if}>  

/*
.agenda_title{
  background-color: #bbff00;
}
*/

</style>


