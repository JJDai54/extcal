SET extFrom=html
SET extTo=tpl

rename extcal*.%extFrom%         extcal*.%extTo%
rename blocks\extcal*.%extFrom%  extcal*.%extTo%
rename admin\extcal*.%extFrom%   extcal*.%extTo%

rem pause