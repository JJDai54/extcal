<{if $smarty.const._EXTCAL_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>


<style type="text/css">
    #extcal-nav #navlist {
        padding: 5px 10px;
        margin: 10px 0 0 0;
        border-bottom: 0 solid;
        font: bold 12px Verdana, sans-serif;
        color: #ff0000;
        word-wrap: break-word;
        /*
        */
    }

    #extcal-nav #navlist li {
        list-style: none;
        margin: 0;
        display: inline-block;
        /*background-color : #ff0000;*/
    }

    #extcal-nav #navlist li a {
        padding: 3px 0.5em;
        margin-left: 3px;
        border: 1px solid;
        -moz-border-radius-topleft: 7px;
        -moz-border-radius-topright: 7px;
        -moz-border-top-right-radius: 5px;
        border-bottom: none;
        text-decoration: none;
        /*color: #ffffff; */
        line-height: 20px;
        display: inline-block;
        /*background-color : #00ff00;*/
        background-color : #c8e4ad; /*fond des onglets*/
    }

    #extcal-nav #navlist li a#current {
        /**/
        border-bottom: 0 solid #ff0000;
        background-color : #A7CC27; /*fond de l'onglets courrant*/
        color: #0000ff
    }

    .extcalBgTabs{
        background-color : #A7CC27; /*fond de l'ensemble des onglets*/
    }
    .extcalBgTab {
        background-color : #c8e4ad; /*fond des onglets*/
    }
    .extcalBgTabCurrent {
        background-color : #ff0000; /*fond de l'onglets courrant*/
    }
</style>

<{if $list_position==0}>
  <{include file="db:extcal_search.tpl"}>
<{/if}>

<div id="extcal-nav" name="extcal-nav" class="extcalBgTabs">
    <ul id="navlist">
        <{foreach item=navBar from=$tNavBar}>
            <li >
                <a href="<{$navBar.href}>"
                        <{if $navBar.current==1}>
id='current' name='current' class='extcalBgTabCurrent'
                        <{else}>

                        <{/if}> >
                        <{$navBar.name}>
                </a>
            </li>
        <{/foreach}>
    </ul>
</div>

<{if $list_position==1}>
  <{include file="db:extcal_search.tpl"}>
<{/if}>

