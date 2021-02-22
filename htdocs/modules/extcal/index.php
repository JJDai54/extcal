<?php

use XoopsModules\Extcal;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';

//modif JJD
require_once __DIR__ . '/include/constantes.php';

/** @var Extcal\Helper $helper */
$helper = Extcal\Helper::getInstance();

header("Location: " . XOOPS_URL . "/modules/extcal/{$helper->getConfig('start_page')}");
