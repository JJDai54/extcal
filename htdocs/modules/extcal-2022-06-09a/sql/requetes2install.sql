
-- Requetes de base de reformulation des tables 
-- Requetes pour front office 

create view `%1$s_extcal_rs_event` AS SELECT
       te.*,
       tc.cat_name as cat_name,
       tl.nom as location_name
FROM %1$s_extcal_event te
LEFT JOIN %1$s_extcal_cat tc ON te.cat_id = tc.cat_id
LEFT JOIN %1$s_extcal_location tl ON te.location_id = tl.location_id;