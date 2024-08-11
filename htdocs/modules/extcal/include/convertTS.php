<?php
/**


test.sages91.fr/modules/extcal/include/convertTS.php?ts=1599048000


 **/
//echo "===>" .  __FILE__ . "<br>";

$ts = $_GET['ts'];
echo date('j-m-y : H-i', $ts) . "<br>";
