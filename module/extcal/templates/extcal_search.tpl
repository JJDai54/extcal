<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<style>
.search{
border : 0px;
}
</style>

<{assign var='searchForm' value=1}>

<{if $searchForm == 0}>
  <form id="ext_search_form"  name="ext_search_form" action="<{$smarty.const.XOOPS_URL}>/<{$smarty.server.SCRIPT_NAME}>" method='get'>
    <table width="100%" class="search">
      <tr>
        <td class="search">
            <{$search.year}>
            <{$search.month}>
            <{if $search.day}><{$search.day}><{/if}>
            <{$search.categorie}>
        </td>
        <td class="search"  width="20%" style="vertical-align:center;text-align:center;">
            <{$search.today}>
            <{$search.submit}>
        </td>
      <tr>
    </table>
  </form>

<{else}>

  <form id="ext_search_form"  name="ext_search_form" action="<{$smarty.const.XOOPS_URL}>/<{$smarty.server.SCRIPT_NAME}>" method='get'>
    <table width="100%" class="search">
      <tr>
        <{if $search.day}>
          <td class="search"><{$search.day}></td>
        <{/if}>

        <{if $search.month}>
          <td class="search"><{$search.month}></td>
        <{/if}>

        <{if $search.year}>
          <td class="search"><{$search.year}></td>
        <{/if}>


        <{if $search.categorie}>
          <td class="search"><{$search.categorie}></td>
        <{/if}>


        <td class="search"  width="15%" style="vertical-align:center;text-align:center;">
            <{$search.today}>
        </td>
        <td class="search"  width="15%" style="vertical-align:center;text-align:center;">
            <{$search.submit}>
        </td>
      <tr>
    </table>
  </form>
<{/if}>
