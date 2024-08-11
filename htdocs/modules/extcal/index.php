<?php

use XoopsModules\Extcal;
//echo "===>" .  __FILE__ . "<br>";


require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once __DIR__ . '/header.php';
//modif JJD
require_once __DIR__ . '/include/constantes.php';

header("Location: " . XOOPS_URL . "/modules/extcal/{$extcalHelper->getConfig('start_page')}");
