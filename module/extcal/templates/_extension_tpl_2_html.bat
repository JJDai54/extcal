SET extFrom=tpl
SET extTo=html

rename "extcal*.%extFrom%"         "extcal*.%extTo%"
rename "blocks\extcal*.%extFrom%"  "extcal*.%extTo%"
rename "admin\extcal*.%extFrom%"   "extcal*.%extTo%"

rem pause