<?php
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

use Xmf\Request;
use XoopsModules\Extcal;

require_once __DIR__ . '/admin_header.php';
require_once dirname(dirname(dirname(__DIR__))) . '/class/xoopsformloader.php';

// require_once  dirname(__DIR__) . '/class/Utility.php';
require_once dirname(__DIR__) . '/include/constantes.php';

$gepeto = array_merge($_GET, $_POST);
//while (list($key, $value) = each($gepeto)) {
foreach ($gepeto as $key => $value) {
   ${$key} =$value;
}

//if (!isset($op)) {
//    $op = '';
//}
$op = 'list';
if (Request::hasVar('op', 'GET')) {
    $op     = Request::getString('op', '');
    $cat_id = Request::getInt('cat_id', 0);
}
//exit ("op = {$op} - cat = {$cat_id}");
switch ($op) {

    case 'enreg':
        // Modify cat
        $varArr = [
            'cat_name'   => Request::getString('cat_name', '', 'POST'),
            'cat_desc'   => Request::getText('cat_desc', '', 'POST'),
            'cat_weight' => Request::getInt('cat_weight', 0, 'POST'),
            'cat_color'  => mb_substr(Request::getString('cat_color', '', 'POST'), 1),
            'cat_icone'  => Request::getText('cat_icone', '', 'POST')
//            'cat_actif'  => Request::getText('cat_actif', '', 'POST'),
        ];

        if (isset($cat_id)) {
            $catHandler->modifyCat($cat_id, $varArr);
            redirect_header('cat.php', 3, _AM_EXTCAL_CAT_EDITED, false);
            // Create new cat
        } else {
            $catHandler->createCat($varArr);
            redirect_header('cat.php', 3, _AM_EXTCAL_CAT_CREATED, false);
        }

        break;
    case 'new':
        xoops_cp_header();

        // $catHandler = xoops_getModuleHandler(_EXTCAL_CLS_CAT, _EXTCAL_MODULE);
        //$cat        = $catHandler->getCat($cat_id, true);

        $form = new \XoopsThemeForm(_AM_EXTCAL_ADD_CATEGORY, 'add_cat', 'cat.php?op=enreg', 'post', true);
        $form->addElement(new \XoopsFormText(_AM_EXTCAL_NAME, 'cat_name', 30, 255), true);
        $form->addElement(getEditor(_AM_EXTCAL_DESCRIPTION, 'cat_desc', '', 5));
        $form->addElement(new \XoopsFormText(_AM_EXTCAL_WEIGHT, 'cat_weight', 30, 5, 0), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTCAL_COLOR, 'cat_color', '#FF0000'));

//         $actif = new \XoopsFormRadio(_AM_EXTCAL_ACTIF, 'cat_actif', $cat->getVar('cat_actif'));
//         $actif->addOption('1', _YES);
//         $actif->addOption('0', _NO);
//         $form->addElement($actif);

        $file_path = dirname(__DIR__) . '/assets/css/images';
        $tf        = \XoopsLists::getImgListAsArray($file_path);
        array_unshift($tf, _MD_EXTCAL_NONE);
        //$xfIcones = new \XoopsFormSelect(_AM_EXTCAL_ICONE, "cat_icone", $cat->getVar('cat_icone'), '');
        $xfIcones = new \XoopsFormSelect(_AM_EXTCAL_ICONE, 'cat_icone', '', '');
        $xfIcones->addOptionArray($tf);
        $form->addElement($xfIcones, false);

        $form->addElement(new \XoopsFormButton('', 'form_submit', _SUBMIT, 'submit'), false);

        $form->display();

        require_once __DIR__ . '/admin_footer.php';
        break;
        
    case 'edit':
        xoops_cp_header();

        // $catHandler = xoops_getModuleHandler(_EXTCAL_CLS_CAT, _EXTCAL_MODULE);
        if (isset($cat_id) && 0 != $cat_id) {
            $cat = $catHandler->getCat($cat_id, true);
        }
        //            $cat = $catHandler->getCat($cat_id, true);

        echo '<fieldset><legend style="font-weight:bold; color:#990000;">' . _AM_EXTCAL_EDIT_CATEGORY . '</legend>';

        $form = new \XoopsThemeForm(_AM_EXTCAL_ADD_CATEGORY, 'add_cat', 'cat.php?op=enreg', 'post', true);
        $form->addElement(new \XoopsFormText(_AM_EXTCAL_NAME, 'cat_name', 30, 255, $cat->getVar('cat_name')), true);
        $form->addElement(getEditor(_AM_EXTCAL_DESCRIPTION, 'cat_desc', $cat->getVar('cat_desc'), 5));
        $form->addElement(new \XoopsFormText(_AM_EXTCAL_WEIGHT, 'cat_weight', 30, 5, $cat->getVar('cat_weight')), false);
        $form->addElement(new \XoopsFormColorPicker(_AM_EXTCAL_COLOR, 'cat_color', '#' . $cat->getVar('cat_color')));


//         $actif = new \XoopsFormRadio(_AM_EXTCAL_ACTIF, 'cat_actif', $cat->getVar('cat_actif'));
//         $actif->addOption('1', _YES);
//         $actif->addOption('0', _NO);
//         $form->addElement($actif);

        $file_path = dirname(__DIR__) . '/assets/css/images';
        $tf        = \XoopsLists::getImgListAsArray($file_path);
        array_unshift($tf, _MD_EXTCAL_NONE);
        $xfIcones = new \XoopsFormSelect(_AM_EXTCAL_ICONE, 'cat_icone', $cat->getVar('cat_icone'), '');
        $xfIcones->addOptionArray($tf);
        $form->addElement($xfIcones, false);


        $form->addElement(new \XoopsFormHidden('cat_id', $cat->getVar('cat_id')), false);
        $form->addElement(new \XoopsFormButton('', 'form_submit', _SUBMIT, 'submit'), false);
        $form->display();

        echo '</fieldset>';

        xoops_cp_footer();
        break;

    case 'delete':
   // exit;
//     $tr=print_r($gepeto,true);
//     echo "<hr><pre>{$tr}</pre><hr>";
// echo "confirm = {$confirm}";
//     exit;
        if (!isset($confirm)) {
            $criteriaCompo = new \CriteriaCompo();
            $criteriaCompo->add(new \Criteria('cat_id', $cat_id));
            $nbEvent = $eventHandler->getCount($criteriaCompo);
            if ($nbEvent > 0) {
                redirect_header('cat.php', 5, _AM_EXTCAL_CAT_DELETED_NOR_ALLOWED, false);

            }

            xoops_cp_header();
            $hiddens = [
                'cat_id'      => $cat_id,
                'form_delete' => '',
                'confirm'     => 1,
            ];
            xoops_confirm($hiddens, 'cat.php?op=delete', _AM_EXTCAL_CONFIRM_DELETE_CAT, _DELETE, 'cat.php');

            xoops_cp_footer();
        } else {
            if (1 == $confirm) {
                $catHandler->deleteCat($cat_id);
                redirect_header('cat.php', 3, _AM_EXTCAL_CAT_DELETED, false);
            }
        }
        break;

    case 'list':
    default:
        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));

        $adminObject->addItemButton(_AM_EXTCAL_ADD_CATEGORY, 'cat.php?op=new', 'add', '');
        $adminObject->displayButton('left', '');

        // $catHandler = xoops_getModuleHandler(_EXTCAL_CLS_CAT, _EXTCAL_MODULE);
        $cats = $catHandler->getAllCatById($xoopsUser);

        $xoopsTpl->assign('cats', $cats);
        //$xoopsTpl->assign("module_dirname",    $xoopsModule->getVar("dirname") );

        $xoopsTpl->display('db:admin/extcal_admin_cat_list.tpl');
        require_once __DIR__ . '/admin_footer.php';
        break;
}
