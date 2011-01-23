
-- settings
SET @iCategId = (SELECT `ID` FROM `sys_options_cats` WHERE `name` = 'VisualDRUGS Google Maps Directions' LIMIT 1);
DELETE FROM `sys_options` WHERE `kateg` = @iCategId;
DELETE FROM `sys_options_cats` WHERE `ID` = @iCategId;
DELETE FROM `sys_options` WHERE `Name` = 'visualdrugs_google_maps_directions_permalinks';

-- permalinks
DELETE FROM `sys_permalinks` WHERE `standard` = 'modules/?r=directions/';

-- admin menu
DELETE FROM `sys_menu_admin` WHERE `name` = 'vd_google_maps_directions';

-- site menu
SET @iTMParentId = (SELECT `ID` FROM `sys_menu_top` WHERE `Name` = 'Directions' AND `Parent` = 0 LIMIT 1);
DELETE FROM `sys_menu_top` WHERE `Name` = 'Directions' OR `Parent` = @iTMParentId;