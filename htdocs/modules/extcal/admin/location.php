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

use XoopsModules\Extcal;

// Include xoops admin header
require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
// require_once  dirname(__DIR__) . '/class/ExtcalPersistableObjectHandler.php';
require_once dirname(dirname(dirname(__DIR__))) . '/kernel/module.php';
require_once dirname(dirname(dirname(__DIR__))) . '/class/xoopsformloader.php';
require_once dirname(dirname(dirname(__DIR__))) . '/class/tree.php';
require_once dirname(dirname(dirname(__DIR__))) . '/class/xoopslists.php';
require_once dirname(dirname(dirname(__DIR__))) . '/class/pagenav.php';
require_once dirname(dirname(dirname(__DIR__))) . '/class/xoopsform/grouppermform.php';
require_once dirname(dirname(dirname(__DIR__))) . '/class/uploader.php';
require_once dirname(__DIR__) . '/include/constantes.php';

require_once __DIR__ . '/admin_header.php';

//require("functions.php");
//require("../include/functions.php");

if ($xoopsUser) {
    $xoopsModule = \XoopsModule::getByDirname('extcal');
    if (!$xoopsUser->isAdmin($xoopsModule->mid())) {
        redirect_header(XOOPS_URL . '/', 3, _NOPERM);
    }
} else {
    redirect_header(XOOPS_URL . '/', 3, _NOPERM);
}

// Include language file
xoops_loadLanguage('admin', 'system');
Extcal\Helper::getInstance()->loadLanguage('admin');
Extcal\Helper::getInstance()->loadLanguage('modinfo');
$myts = \MyTextSanitizer::getInstance();

//appel des class
$locationHandler = Extcal\Helper::getInstance()->getHandler(_EXTCAL_CLN_LOCATION);

xoops_cp_header();

$op = 'liste';
if (\Xmf\Request::hasVar('op', 'REQUEST')) {
    $op = $_REQUEST['op'];
}

//appel du menu admin
// if ( !is_readable(XOOPS_ROOT_PATH . "/Frameworks/art/functions.admin.php")) {
// adminmenu(4, _MI_EXTCAL_LOCATION);
// } else {
// require_once XOOPS_ROOT_PATH.'/Frameworks/art/functions.admin.php';
// loadModuleAdminMenu (4, _MI_EXTCAL_LOCATION);
// }

//Les valeurs de op qui vont permettre d'aller dans les differentes parties de la page
switch ($op) {
    // Vue liste
    case 'liste':
        // @author   JJDAI
        //***************************************************************************************
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        //***************************************************************************************

        $criteria = new \CriteriaCompo();
        if (\Xmf\Request::hasVar('limit', 'REQUEST')) {
            $criteria->setLimit($_REQUEST['limit']);
            $limit = $_REQUEST['limit'];
        } else {
            $criteria->setLimit(10);
            $limit = 10;
        }
        if (\Xmf\Request::hasVar('start', 'REQUEST')) {
            $criteria->setStart($_REQUEST['start']);
            $start = $_REQUEST['start'];
        } else {
            $criteria->setStart(0);
            $start = 0;
        }
        $criteria->setSort('nom');
        $criteria->setOrder('ASC');
        $location_arr = $locationHandler->getObjects($criteria);
        $numrows      = $locationHandler->getCount($criteria);
        if ($numrows > $limit) {
            $pagenav = new \XoopsPageNav($numrows, $limit, $start, 'start', 'op=liste&limit=' . $limit);
            $pagenav = $pagenav->renderNav(4);
        } else {
            $pagenav = '';
        }
        //Affichage du tableau des téléchargements brisés
        if ($numrows > 0) {
            echo '<table width="100%" cellspacing="1" class="outer">';
            echo '<tr>';
            echo '<th align="center">' . _AM_EXTCAL_LOCATION_FORM_NOM . '</th>';
            echo '<th align="center" width="20%">' . _AM_EXTCAL_ADRESSE . '</th>';
            echo '<th align="center" width="5%">' . _MD_EXTCAL_CP . '</th>';
            echo '<th align="center" width="20%">' . _AM_EXTCAL_CITY . '</th>';
            echo '<th align="center" width="15%">' . _AM_EXTCAL_TELEPHONE . '</th>';
//             echo '<th align="center" width="10%">' . _AM_EXTCAL_MOBILE . '</th>';
            echo '<th align="center" width="10%">' . _AM_EXTCAL_ACTION . '</th>';
            echo '</tr>';
            $class = 'odd';
            foreach (array_keys($location_arr) as $i) {
                $class              = ('even' === $class) ? 'odd' : 'even';
                $location_id        = $location_arr[$i]->getVar('location_id');
                $location_nom       = $location_arr[$i]->getVar('nom');
                $location_adresse   = $location_arr[$i]->getVar('adresse');
                $location_cp        = $location_arr[$i]->getVar('cp');
                $location_city      = $location_arr[$i]->getVar('ville');
                $location_telephone = $location_arr[$i]->getVar('tel_fixe');
                $location_mobile    = $location_arr[$i]->getVar('tel_portable');
                echo '<tr class="' . $class . '">';
                echo '<td align="left">' . '<a href="location.php?op=edit_location&location_id=' . $location_id . '">' . $location_nom . '</a>' . '</td>';

                echo '<td align="left"><b>' . $location_adresse . '</td>';
                echo '<td align="center"><b>' . $location_cp . '</td>';
                echo '<td align="left"><b>' . $location_city . '</td>';
//                 echo '<td align="center"><b>' . $location_telephone . '</td>';
//                 echo '<td align="center"><b>' . $location_mobile . '</td>';
                echo '<td align="center"><b>' . $location_telephone . '<br>' . $location_mobile . '</td>';

                echo '<td align="center" width="15%">';
                echo '<a href="location.php?op=edit_location&location_id=' . $location_id . '"><img src=' . $pathIcon16 . '/edit.png alt="' . _AM_EXTCAL_LOCATION_FORM_EDIT . '" title="' . _AM_EXTCAL_LOCATION_FORM_EDIT . '"></a> ';
                echo '<a href="location.php?op=delete_location&location_id=' . $location_id . '"><img src=' . $pathIcon16 . '/delete.png alt="' . _AM_EXTCAL_LOCATION_FORM_DELETE . '" title="' . _AM_EXTCAL_LOCATION_FORM_DELETE . '"></a> ';
                echo '</td>';
            }
            echo '</table><br>';
            echo '<br><div align=right>' . $pagenav . '</div><br>';
        } else {
            echo '<div class="errorMsg" style="text-align: center;">' . _AM_EXTCAL_ERREUR_NO_LOCATION . '</div>';
        }

        // Affichage du formulaire
        $obj  = $locationHandler;
        $form = $obj->getLocationForm(0, 'admin');
        break;
    // permet de suprimmer le rapport de téléchargment brisé
    case 'delete_location':
        $obj = $locationHandler->get($_REQUEST['location_id']);
        if (\Xmf\Request::hasVar('ok', 'REQUEST') && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('location.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($locationHandler->delete($obj)) {
                redirect_header('location.php', 1, _AM_EXTCAL_REDIRECT_DELOK);
            }
        } else {
            xoops_confirm([
                              'ok'          => 1,
                              'location_id' => $_REQUEST['location_id'],
                              'op'          => 'delete_location',
                          ], $_SERVER['REQUEST_URI'], _AM_EXTCAL_LOCATION_SURDEL . '<br>');
        }
        break;

    case 'edit_location':
        // @author   JJDAI

        //***************************************************************************************
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        //***************************************************************************************
        //Affichage du formulaire de création des téléchargements
        //$obj  = $locationHandler->getLocation($_REQUEST['location_id'] );
        //$form = $locationHandler->getLocationForm('admin',false,[$_REQUEST['location_id']]);
        $form = $locationHandler->getLocationForm($_REQUEST['location_id'], 'admin');
        break;

    //**********************************************************
    case 'save_location':
         $locationHandler->savelocation('admin',$_REQUEST);
         /*
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('location.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (\Xmf\Request::hasVar('location_id', 'REQUEST')) {
            $obj = $locationHandler->get($_REQUEST['location_id']);
        } else {
            $obj = $locationHandler->create();
        }

        $obj->setVar('nom', $_REQUEST['nom']);
        $obj->setVar('description', $_REQUEST['description']);
        $obj->setVar('categorie', $_REQUEST['categorie']);
        $obj->setVar('adresse', $_REQUEST['adresse']);
        $obj->setVar('adresse2', $_REQUEST['adresse2']);
        $obj->setVar('cp', $_REQUEST['cp']);
        $obj->setVar('ville', $_REQUEST['ville']);
        $obj->setVar('tel_fixe', $_REQUEST['tel_fixe']);
        $obj->setVar('tel_portable', $_REQUEST['tel_portable']);
        $obj->setVar('mail', $_REQUEST['mail']);
        $obj->setVar('site', $_REQUEST['site']);
        $obj->setVar('horaires', $_REQUEST['horaires']);
        $obj->setVar('divers', $_REQUEST['divers']);
        $obj->setVar('tarifs', $_REQUEST['tarifs']);
        $obj->setVar('map', $_REQUEST['map']);

        //Logo
        $uploaddir_location = XOOPS_ROOT_PATH . '/uploads/extcal/location/';
        $uploadurl_location = XOOPS_URL . '/uploads/extcal/location/';

        $delimg = @$_REQUEST['delimg'];
        $delimg = isset($delimg) ? (int)$delimg : 0;
        if (0 == $delimg && !empty($_REQUEST['xoops_upload_file'][0])) {
            $upload = new \XoopsMediaUploader($uploaddir_location, [
                'image/gif',
                'image/jpeg',
                'image/pjpeg',
                'image/x-png',
                'image/png',
            ], 3145728, null, null);
            if ($upload->fetchMedia($_REQUEST['xoops_upload_file'][0])) {
                $upload->setPrefix('location_');
                $upload->fetchMedia($_REQUEST['xoops_upload_file'][0]);
                if (!$upload->upload()) {
                    $errors = $upload->getErrors();
                    redirect_header('javascript:history.go(-1)', 3, $errors);
                } else {
                    $logo = $upload->getSavedFileName();
                }
            } elseif (!empty($_REQUEST['file'])) {
                $logo = $_REQUEST['file'];
            }
        } else {
            $logo         = '';
            $url_location = XOOPS_ROOT_PATH . '/uploads/extcal/location/' . $_REQUEST['file'];
            if (is_file($url_location)) {
                chmod($url_location, 0777);
                unlink($url_location);
            }
        }
        $obj->setVar('logo', $logo);

        if ($locationHandler->insert($obj)) {
        }

        //require_once "../include/forms.php";
        echo $obj->getHtmlErrors();
        $form = $obj->getForm(false, 0);
        //echo "<hr>exit <<<<<<<<<<<<<<<<<<<<";exit;
        redirect_header('location.php', 2, _AM_EXTCAL_FORMOK);
         */

        break;
}

require_once __DIR__ . '/admin_footer.php';
