<?php

namespace XoopsModules\Extcal;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    {@link https://xoops.org/ XOOPS Project}
 * @license      {@link http://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package      extcal
 * @since
 * @author       XOOPS Development Team,
 */

//Kraven 30
// defined('XOOPS_ROOT_PATH') || die('Restricted access');

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Class LocationHandler.
 */
class LocationHandler extends ExtcalPersistableObjectHandler
{
    /**
     * @param \XoopsDatabase|null $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        parent::__construct($db, 'extcal_location', Location::class, 'location_id', 'nom');
//        echo "<hr>===>" . "construct LocationHandler" .  "<hr>";
    }

    /**
     * @param      $location_id
     * @param bool $skipPerm
     *
     * @return bool
     */
    public function getLocation($location_id, $skipPerm = false, $asArray=false)
    {
global $xoopsDB;
        $user = $GLOBALS['xoopsUser'];

        $criteriaCompo = new \CriteriaCompo();
        $criteriaCompo->add(new \Criteria('location_id', $location_id));

        if (!$skipPerm) {
            $this->addCatPermCriteria($criteriaCompo, $user);
        }
        $ret = $this->getObjects($criteriaCompo);




        if (isset($ret[0])) {
//echo "===>location_id = " . $location_id ; "<hr>";exit;
            if ($asArray){
              $t = $ret[0]->toArray();
//            ext_echo($t);
              return $t;
            }else{
              return $ret[0];
            }
        }
        return false;
    }

    /**
     * @param \CriteriaElement $criteria
     * @param null             $fields
     * @param bool             $asObject
     * @param bool             $id_as_key
     *
     * @return array
     */

//     public function &getAll(CriteriaElement $criteria = null, $fields = null, $asObject = true, $id_as_key = true)
//
//
//                             //getAll($criteria = null, $asObject = false)
//     {
//         $rst = $this->getObjects($criteria, $asObject);
//         if ($asObject) {
//             return $rst;
//         }
//
//         return $this->objectToArray($rst);
//     }

    /**
     * @param null $criteria
     * @param bool $asObject
     *
     * @return array
     */

    public function getAllLocations($criteria = null, $asObject = false)
    {
        $rst = $this->getObjects($criteria, $asObject);
        if ($asObject) {
            return $rst;
        }

        return $this->objectToArray($rst);
    }


    /**
     * @param bool $action
     *
     * @return \XoopsThemeForm
     */
    public function getLocationForm($location_id, $siteSide = 'user')
    {
        global $xoopsDB, $extcalConfig;

//         if (false === $action) {
//             $action = $_SERVER['REQUEST_URI'];
//         }


        require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

        if ($location_id > 0){
          $location = $this->getLocation($location_id);
        }else{
          $location = $this->create();
        }

        if ($siteSide == "user"){
          $action="location-edit.php?op=save_location";
        }else{
          $action="location.php?op=save_location";
        }
// echo "===location_id = {$location_id}";
// ext_echo($location);exit;
$title = "location";

        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $form->addElement(new \XoopsFormHidden('location_id', $location->getVar('location_id')), true);
        $form->addElement(new \XoopsFormText(_MD_EXTCAL_LOCATION_NOM, 'nom', 50, 255, $location->getVar('nom')), true);
        $form->addElement(getEditor(_MD_EXTCAL_DESCRIPTION, 'description', $location->getVar('description'), 5));
        $form->addElement(new \XoopsFormText(_MD_EXTCAL_LOCATION_CATEGORIE, 'categorie', 40, 255, $location->getVar('categorie')), false);
        $form->addElement(new \XoopsFormText(_MD_EXTCAL_LOCATION_ADRESSE, 'adresse', 50, 255, $location->getVar('adresse')), false);
        $form->addElement(new \XoopsFormText(_MD_EXTCAL_LOCATION_ADRESSE2, 'adresse2', 50, 255, $location->getVar('adresse2')), false);
        $form->addElement(new \XoopsFormText(_MD_EXTCAL_CP, 'cp', 10, 10, $location->getVar('cp')), false);
        $form->addElement(new \XoopsFormText(_MD_EXTCAL_LOCATION_VILLE, 'ville', 20, 255, $location->getVar('ville')), false);
        $form->addElement(new \XoopsFormText(_MD_EXTCAL_LOCATION_TEL_FIXE, 'tel_fixe', 20, 20, $location->getVar('tel_fixe')), false);
        $form->addElement(new \XoopsFormText(_MD_EXTCAL_LOCATION_TEL_PORTABLE, 'tel_portable', 20, 20, $location->getVar('tel_portable')), false);
        $form->addElement(new \XoopsFormText(_MD_EXTCAL_LOCATION_MAIL, 'mail', 50, 255, $location->getVar('mail')), false);
        $form->addElement(new \XoopsFormText(_MD_EXTCAL_LOCATION_SITE, 'site', 50, 255, $location->getVar('site')), false);

$setting = array(

    'theme' => 'simple',
    // language code of the default language pack to use with TinyMCE. These codes are in ISO-639-1 format
    'language' => 'fr',
    /* possible values exemple, get from: http://wiki.moxiecode.com/examples/tinymce/installation_example_13.php */
    'mode' => 'exact',
    'convert_urls' => false,
    'force_p_newlines' => true,
    'force_hex_style_colors' => true,
    // to prevent new line after tags (really useful with Xoops)
//     'apply_source_formatting' => false,
//     // get more W3C compatible code, since font elements are deprecated
//     'convert_fonts_to_spans' => true,
//     // XHTML: list elements UL/OL will be converted to valid XHTML
//     'fix_list_elements' => true,
//     // XHTML: table elements will be moved outside paragraphs or other block elements
//     'fix_table_elements' => true,
//     // XHTML strict: attributes gets converted into CSS style attribute
//     'inline_styles' => true,
//     // if true, some accessibility focus will be available to all buttons: you will be able to tab through them all
//     'accessibility_focus' => true,
//     // if true, some accessibility warnings will be presented to the user
//     'accessibility_warnings' => true,
//     // resize options
//     'theme_advanced_resize_horizontal' => false,
//     'theme_advanced_resizing' => true,
//     // load plugins
//     'plugins' => 'xoopsimagemanager,xoopsquote,xoopscode,xoopsemotions,xoopsmlcontent,' . // Xoops plugins
                 //"safari,autoresize,xhtmlxtras,directionality," . // plugins added from TinyMCE 3.2.5
                 'safari,xhtmlxtras,directionality,' . // fixed from TinyMCE 3.3.6
                 'advlist,style,xhtmlxtras,searchreplace,' . // plugins added from TinyMCE 3.3.6
                 'table,advimage,advlink,emotions,insertdatetime,preview,media,contextmenu,' . 'paste,fullscreen,visualchars,nonbreaking,inlinepopups',
    //"pagebreak,spellchecker,layer,save,advhr,iespell,inlinepopups," .
    //"print,directionality,noneditable,template,"

    'exclude_plugins' => 'autosave,bbcode,contextmenu,emotions,example,fullpage',
//     'theme_advanced_toolbar_location' => 'top',
//     'theme_advanced_toolbar_align' => 'left',
//     'theme_advanced_statusbar_location' => 'bottom',
    //"content_css" => "editor_xoops.css",

//     'theme_advanced_buttons1' => 'bold,italic,underline,strikethrough,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect',
//     'theme_advanced_buttons2' => 'bullist,numlist,|,outdent,indent,|,undo,redo,|,removeformat,styleprops,|,link,unlink,anchor,image,media,|,charmap,nonbreaking,hr,emotions,|,pastetext,pasteword,|,forecolor,backcolor',
//     'theme_advanced_buttons3' => 'search,replace,|,tablecontrols,|,cleanup,visualaid,visualchars,|,insertdate,inserttime,|,preview,fullscreen,help,code',
//     'theme_advanced_buttons4' => 'xoopsimagemanager,xoopsemotions,xoopsquote,xoopscode,xoopsmlcontent',
    // Full XHTML rule set
    'valid_elements' => '' . 'a[accesskey|charset|class|coords|dir<ltr?rtl|href|hreflang|id|lang|name' . '|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup' . '|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rel|rev' . '|shape<circle?default?poly?rect|style|tabindex|title|target|type],' . 'abbr[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'acronym[class|dir<ltr?rtl|id|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'address[class|align|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown' . '|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover' . '|onmouseup|style|title],' . 'applet[align<bottom?left?middle?right?top|alt|archive|class|code|codebase' . '|height|hspace|id|name|object|style|title|vspace|width],' . 'area[accesskey|alt|class|coords|dir<ltr?rtl|href|id|lang|nohref<nohref' . '|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup' . '|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup' . '|shape<circle?default?poly?rect|style|tabindex|title|target],' . 'base[href|target],' . 'basefont[color|face|id|size],' . 'bdo[class|dir<ltr?rtl|id|lang|style|title],' . 'big[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'blockquote[cite|class|dir<ltr?rtl|id|lang|onclick|ondblclick' . '|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout' . '|onmouseover|onmouseup|style|title],' . 'body[alink|background|bgcolor|class|dir<ltr?rtl|id|lang|link|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onload|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|onunload|style|title|text|vlink],' . 'br[class|clear<all?left?none?right|id|style|title],' . 'button[accesskey|class|dir<ltr?rtl|disabled<disabled|id|lang|name|onblur' . '|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup|onmousedown' . '|onmousemove|onmouseout|onmouseover|onmouseup|style|tabindex|title|type' . '|value],' . 'caption[align<bottom?left?right?top|class|dir<ltr?rtl|id|lang|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|style|title],' . 'center[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'cite[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'code[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'col[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id' . '|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown' . '|onmousemove|onmouseout|onmouseover|onmouseup|span|style|title' . '|valign<baseline?bottom?middle?top|width],' . 'colgroup[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl' . '|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown' . '|onmousemove|onmouseout|onmouseover|onmouseup|span|style|title' . '|valign<baseline?bottom?middle?top|width],' . 'dd[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup' . '|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],' . 'del[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown' . '|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover' . '|onmouseup|style|title],' . 'dfn[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'dir[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown' . '|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover' . '|onmouseup|style|title],' . 'div[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|style|title],' . 'dl[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown' . '|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover' . '|onmouseup|style|title],' . 'dt[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup' . '|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],' . 'em/i[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'fieldset[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'font[class|color|dir<ltr?rtl|face|id|lang|size|style|title],' . 'form[accept|accept-charset|action|class|dir<ltr?rtl|enctype|id|lang' . '|method<get?post|name|onclick|ondblclick|onkeydown|onkeypress|onkeyup' . '|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onreset|onsubmit' . '|style|title|target],' . 'frame[class|frameborder|id|longdesc|marginheight|marginwidth|name' . '|noresize<noresize|scrolling<auto?no?yes|src|style|title],' . 'frameset[class|cols|id|onload|onunload|rows|style|title],' . 'h1[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|style|title],' . 'h2[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|style|title],' . 'h3[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|style|title],' . 'h4[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|style|title],' . 'h5[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|style|title],' . 'h6[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|style|title],' . 'head[dir<ltr?rtl|lang|profile],' . 'hr[align<center?left?right|class|dir<ltr?rtl|id|lang|noshade<noshade|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|size|style|title|width],' . 'html[dir<ltr?rtl|lang|version],' . 'iframe[align<bottom?left?middle?right?top|class|frameborder|height|id' . '|longdesc|marginheight|marginwidth|name|scrolling<auto?no?yes|src|style' . '|title|width],' . 'img[align<bottom?left?middle?right?top|alt|border|class|dir<ltr?rtl|height' . '|hspace|id|ismap<ismap|lang|longdesc|name|onclick|ondblclick|onkeydown' . '|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover' . '|onmouseup|src|style|title|usemap|vspace|width],' . 'input[accept|accesskey|align<bottom?left?middle?right?top|alt' . '|checked<checked|class|dir<ltr?rtl|disabled<disabled|id|ismap<ismap|lang' . '|maxlength|name|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect' . '|readonly<readonly|size|src|style|tabindex|title' . '|type<button?checkbox?file?hidden?image?password?radio?reset?submit?text' . '|usemap|value],' . 'ins[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown' . '|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover' . '|onmouseup|style|title],' . 'isindex[class|dir<ltr?rtl|id|lang|prompt|style|title],' . 'kbd[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'label[accesskey|class|dir<ltr?rtl|for|id|lang|onblur|onclick|ondblclick' . '|onfocus|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout' . '|onmouseover|onmouseup|style|title],' . 'legend[align<bottom?left?right?top|accesskey|class|dir<ltr?rtl|id|lang' . '|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|style|title],' . 'li[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup' . '|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title|type' . '|value],' . 'link[charset|class|dir<ltr?rtl|href|hreflang|id|lang|media|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|rel|rev|style|title|target|type],' . 'map[class|dir<ltr?rtl|id|lang|name|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'menu[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown' . '|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover' . '|onmouseup|style|title],' . 'meta[content|dir<ltr?rtl|http-equiv|lang|name|scheme],' . 'noframes[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'noscript[class|dir<ltr?rtl|id|lang|style|title],' . 'object[align<bottom?left?middle?right?top|archive|border|class|classid' . '|codebase|codetype|data|declare|dir<ltr?rtl|height|hspace|id|lang|name' . '|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|standby|style|tabindex|title|type|usemap' . '|vspace|width],' . 'ol[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown' . '|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover' . '|onmouseup|start|style|title|type],' . 'optgroup[class|dir<ltr?rtl|disabled<disabled|id|label|lang|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|style|title],' . 'option[class|dir<ltr?rtl|disabled<disabled|id|label|lang|onclick|ondblclick' . '|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout' . '|onmouseover|onmouseup|selected<selected|style|title|value],' . 'p[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|style|title],' . 'param[id|name|type|value|valuetype<DATA?OBJECT?REF],' . 'pre/listing/plaintext/xmp[align|class|dir<ltr?rtl|id|lang|onclick|ondblclick' . '|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout' . '|onmouseover|onmouseup|style|title|width],' . 'q[cite|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 's[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup' . '|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],' . 'samp[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'script[charset|defer|language|src|type],' . 'select[class|dir<ltr?rtl|disabled<disabled|id|lang|multiple<multiple|name' . '|onblur|onchange|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup' . '|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|size|style' . '|tabindex|title],' . 'small[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'span[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown' . '|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover' . '|onmouseup|style|title],' . 'strike[class|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown' . '|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover' . '|onmouseup|style|title],' . 'strong/b[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'style[dir<ltr?rtl|lang|media|title|type],' . 'sub[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'sup[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title],' . 'table[align<center?left?right|bgcolor|border|cellpadding|cellspacing|class' . '|dir<ltr?rtl|frame|height|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rules' . '|style|summary|title|width],' . 'tbody[align<center?char?justify?left?right|char|class|charoff|dir<ltr?rtl|id' . '|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown' . '|onmousemove|onmouseout|onmouseover|onmouseup|style|title' . '|valign<baseline?bottom?middle?top],' . 'td[abbr|align<center?char?justify?left?right|axis|bgcolor|char|charoff|class' . '|colspan|dir<ltr?rtl|headers|height|id|lang|nowrap<nowrap|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|rowspan|scope<col?colgroup?row?rowgroup' . '|style|title|valign<baseline?bottom?middle?top|width],' . 'textarea[accesskey|class|cols|dir<ltr?rtl|disabled<disabled|id|lang|name' . '|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup' . '|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect' . '|readonly<readonly|rows|style|tabindex|title],' . 'tfoot[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id' . '|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown' . '|onmousemove|onmouseout|onmouseover|onmouseup|style|title' . '|valign<baseline?bottom?middle?top],' . 'th[abbr|align<center?char?justify?left?right|axis|bgcolor|char|charoff|class' . '|colspan|dir<ltr?rtl|headers|height|id|lang|nowrap<nowrap|onclick' . '|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove' . '|onmouseout|onmouseover|onmouseup|rowspan|scope<col?colgroup?row?rowgroup' . '|style|title|valign<baseline?bottom?middle?top|width],' . 'thead[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id' . '|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown' . '|onmousemove|onmouseout|onmouseover|onmouseup|style|title' . '|valign<baseline?bottom?middle?top],' . 'title[dir<ltr?rtl|lang],' . 'tr[abbr|align<center?char?justify?left?right|bgcolor|char|charoff|class' . '|rowspan|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title|valign<baseline?bottom?middle?top],' . 'tt[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup' . '|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],' . 'u[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup' . '|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],' . 'ul[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown' . '|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover' . '|onmouseup|style|title|type],' . 'var[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress' . '|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style' . '|title]'

);

        //$form->addElement(new \XoopsFormTextArea(_MD_EXTCAL_LOCATION_HORAIRES, 'horaires', $location->getVar('horaires'), 3, 40));
        //$form->addElement(getEditor(_MD_EXTCAL_DESCRIPTION, 'horaires', $location->getVar('horaires'), 5));
        $editorDesc =getEditor(_MD_EXTCAL_LOCATION_HORAIRES, 'horaires', $location->getVar('horaires'), 5);
//ext_echo($editorDesc);
//$editorDesc['editor']->editor->setConfig($zzz);
//$editorDesc->editor->editor->config = array();
//$editorDesc->editor->editor->setting = $setting;
//ext_echo($editorDesc);
//ext_echo($editorDesc->editor->editor->setting);
//$editorDesc->editor->editor->setConfig($zzz);
//$editorDesc->editor->editor->init();
        $form->addElement($editorDesc);

        $form->addElement(new \XoopsFormTextArea(_MD_EXTCAL_LOCATION_DIVERS, 'divers', $location->getVar('divers'), 5, 40));
        //$form->addElement( new \XoopsFormTextArea(_MD_EXTCAL_LOCATION_TARIFS, 'tarifs', $this->getVar("tarifs"), 5, 40));
        $form->addElement(new \XoopsFormText(_MD_EXTCAL_LOCATION_TARIFS . ' ( ' . _MD_EXTCAL_DEVISE2 . ' )', 'tarifs', 20, 20, $location->getVar('tarifs')), false);

        //$form->addElement( new \XoopsFormTextArea(_MD_EXTCAL_LOCATION_MAP, 'map', $this->getVar("map"), 5, 40));
        $form->addElement(new \XoopsFormText(_MD_EXTCAL_LOCATION_MAP, 'map', 150, 255, $location->getVar('map')), false);

        //Logo
        $file_tray = new \XoopsFormElementTray(sprintf(_MD_EXTCAL_FORM_IMG, 2), '');
        if ('' != $location->getVar('logo')) {
            $file_tray->addElement(new \XoopsFormLabel('', "<img src='" . XOOPS_URL . '/uploads/extcal/location/' . $location->getVar('logo') . "' name='image' id='image' alt='' width='300px'><br><br>"));
            $check_del_img = new \XoopsFormCheckBox('', 'delimg');
            $check_del_img->addOption(1, _MD_EXTCAL_DEL_IMG);
            $file_tray->addElement($check_del_img);
            $file_img = new \XoopsFormFile(_MD_EXTCAL_IMG, 'attachedimage', 3145728);
            unset($check_del_img);
        } else {
            $file_img = new \XoopsFormFile('', 'attachedimage', 3145728);
        }
        $file_img->setExtra("size ='40'");
        $file_tray->addElement($file_img);
        $msg        = sprintf(_MD_EXTCAL_IMG_CONFIG, (int)(3145728 / 1000), 500, 500);
        $file_label = new \XoopsFormLabel('', '<br>' . $msg);
        $file_tray->addElement($file_label);
        $form->addElement($file_tray);
        $form->addElement(new \XoopsFormHidden('file', $location->getVar('logo')));
        unset($file_img, $file_tray);

        $form->addElement(new \XoopsFormHidden('op', 'save_location'));
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $form->display();

        return $form;
    }

/*******************************************************
 *
 ******************************************************/
public function saveLocation($siteSide, $data){
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('location.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (\Xmf\Request::hasVar('location_id', 'REQUEST')) {
            $obj = $this->get($data['location_id']);
        } else {
            $obj = $this->create();
        }
/*
    $tr=print_r($data,true);
    echo "<hr><pre>{$tr}</pre><hr>";
    exit;
*/
// ext_echo($data);
// exit;
// ***************** verif JJDai ****************************************
include_once(XOOPS_ROOT_PATH . '/Frameworks/JJD/include/WhatDoYouWantToDo.php');
sanityse_whatDoYouWantToDoA($data,
                           $nomTable = 'location',
                           $nomChamp = array('description','horaires'),
                           $idFiche = $data['location_id'],
                           $commentaire = '');
// ***************************************************************

        $obj->setVar('nom', $data['nom']);
        $obj->setVar('description', $data['description']);
        $obj->setVar('categorie', $data['categorie']);
        $obj->setVar('adresse', $data['adresse']);
        $obj->setVar('adresse2', $data['adresse2']);
        $obj->setVar('cp', $data['cp']);
        $obj->setVar('ville', $data['ville']);
        $obj->setVar('tel_fixe', $data['tel_fixe']);
        $obj->setVar('tel_portable', $data['tel_portable']);
        $obj->setVar('mail', $data['mail']);
        $obj->setVar('site', $data['site']);
        $obj->setVar('horaires', $data['horaires']);
        $obj->setVar('divers', $data['divers']);
        $obj->setVar('tarifs', $data['tarifs']);
        $obj->setVar('map', $data['map']);

        //Logo
        $uploaddir_location = XOOPS_ROOT_PATH . '/uploads/extcal/location/';
        $uploadurl_location = XOOPS_URL . '/uploads/extcal/location/';

        $delimg = @$data['delimg'];
        $delimg = isset($delimg) ? (int)$delimg : 0;
        if (0 == $delimg && !empty($data['xoops_upload_file'][0])) {
            $upload = new \XoopsMediaUploader($uploaddir_location, [
                'image/gif',
                'image/jpeg',
                'image/pjpeg',
                'image/x-png',
                'image/png',
            ], 3145728, null, null);
            if ($upload->fetchMedia($data['xoops_upload_file'][0])) {
                $upload->setPrefix('location_');
                $upload->fetchMedia($data['xoops_upload_file'][0]);
                if (!$upload->upload()) {
                    $errors = $upload->getErrors();
                    redirect_header('javascript:history.go(-1)', 3, $errors);
                } else {
                    $logo = $upload->getSavedFileName();
                }
            } elseif (!empty($data['file'])) {
                $logo = $data['file'];
            }
        } else {
            $logo         = '';
            $url_location = XOOPS_ROOT_PATH . '/uploads/extcal/location/' . $data['file'];
            if (is_file($url_location)) {
                chmod($url_location, 0777);
                unlink($url_location);
            }
        }
        $obj->setVar('logo', $logo);

        if ($this->insert($obj)) {
        }
        $location_id = $obj->getVar('location_id');
 //                   echo "===>logo : " . $logo . "<br>";exit;

        //require_once "../include/forms.php";
        echo $obj->getHtmlErrors();
        $form = $this->getLocationForm(false, 0);
        //echo "<hr>exit <<<<<<<<<<<<<<<<<<<<";exit;

        if ($siteSide == "user"){
            //redirect_header('location-list.php', 2, _AM_EXTCAL_FORMOK);
            $url = "location.php?location_id={$location_id}";
            //echo "redirect to : " . $url . "<br>";exit;
            redirect_header($url, 2, _MD_EXTCAL_FORMOK);
        }else{
            redirect_header('location.php', 2, _MD_EXTCAL_FORMOK);
        }


 }

/******************************************************************
 *
 *
 *****************************************************************/
 public function getButtons($location_edit, $binBtn = 7){
// $binBtn : 1 = new, 2=edit, 4=delete
  $urlBase = XOOPS_URL . '/modules/extcal/';
  $pathIcon16 = \Xmf\Module\Admin::iconUrl('', 16);
  $btn = [];

  if (($binBtn & 1) !=0){
    $btn['add'] = ['title' => _MD_EXTCAL_LOCATION_ADD,
                   'url' => $urlBase . 'location-edit.php?op=delete_edit&location_id=0',
                   'img' => $pathIcon16 . '/add.png'];
  }

  if (($binBtn & 2) !=0){
    $btn['edit'] = ['title' => _MD_EXTCAL_LOCATION_EDIT,
                   'url' => $urlBase . 'location-edit.php?op=edit_location&location_id=' . $location_edit,
                   'img' => $pathIcon16 . '/edit.png'];
  }

  if (($binBtn & 4) !=0){
    $btn['delete'] = ['title' => _MD_EXTCAL_LOCATION_DELETE,
                   'url' => $urlBase . 'location-edit.php?op=delete_location&location_id=' . $location_edit,
                   'img' => $pathIcon16 . '/delete.png'];
  }

  return $btn;


 }
}
