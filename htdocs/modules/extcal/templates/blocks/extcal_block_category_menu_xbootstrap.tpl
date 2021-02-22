<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

  <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;"><{$block.module.lib}><b class="caret"></b></a>
      <ul class="dropdown-menu">

<{if $block.module.nbMainMenu > 0}>
        <{foreach from=$block.main key=kItem item=mainItem}>
            <{if !empty($mainItem.submenu) }>
              <li class="dropdown-submenu">
                <a href="<{$mainItem.url}>"><{$mainItem.lib}></a>
                <ul class="dropdown-menu">
                  <{foreach from=$mainItem.submenu key=kSubmenu item=subMenu}>
                    <li><a href="<{$subMenu.url}>"><{$subMenu.lib}></a></li>
                  <{/foreach}>
                </ul>
              </li>

            <{else}>
              <li><a href="<{$mainItem.url}>"><{$mainItem.lib}></a></li>
            <{/if}>
        <{/foreach}>

        <li><hr></li>
<{/if}>

        <{foreach from=$block.MenuCatItems key=k item=mainItem}>
            <li><a href="<{$mainItem.url}>/"><{$mainItem.lib}></a></li>
        <{/foreach}>

      </ul>
  </li>

