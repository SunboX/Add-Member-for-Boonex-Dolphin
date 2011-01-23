-- settings

SET @iMaxOrder = (SELECT `menu_order` + 1 FROM `sys_options_cats` ORDER BY `menu_order` DESC LIMIT 1);

INSERT INTO `sys_options_cats` (`name`, `menu_order`) VALUES ('VisualDRUGS Google Maps Directions', @iMaxOrder);

SET @iCategId = (SELECT LAST_INSERT_ID());

INSERT INTO `sys_options` (`Name`, `VALUE`, `kateg`, `desc`, `Type`, `check`, `err_text`, `order_in_kateg`, `AvailableValues`) VALUES
    ('visualdrugs_google_maps_directions_permalinks', 'on', 26, 'Enable friendly permalinks in Google Maps', 'checkbox', '', '', '0', ''),
    ('visualdrugs_google_maps_directions_header_html', '', @iCategId, '_visualdrugs_google_maps_directions_text_above', 'text', '', '', '1', ''),
    ('visualdrugs_google_maps_directions_api_key', '', @iCategId, '_visualdrugs_google_maps_directions_api_key', 'digit', '', '', '2', ''),
    ('visualdrugs_google_maps_directions_adress_html', '', @iCategId, '_visualdrugs_google_maps_directions_your_adress', 'text', '', '', '3', ''),
    ('visualdrugs_google_maps_directions_lat', '0.0', @iCategId, '_visualdrugs_google_maps_directions_your_lat', 'digit', '', '', '4', ''),
    ('visualdrugs_google_maps_directions_lng', '0.0', @iCategId, '_visualdrugs_google_maps_directions_your_lng', 'digit', '', '', '5', ''),
    ('visualdrugs_google_maps_directions_zoom', '8', @iCategId, '_visualdrugs_google_maps_directions_init_zoom', 'digit', '', '', '6', ''),
    ('visualdrugs_google_maps_directions_type', 'Roadmap', @iCategId, '_visualdrugs_google_maps_directions_init_type', 'select', '', '', '7', 'Roadmap,Satellite,Hybrid,Terrain'),
    ('visualdrugs_google_maps_directions_map_height', '500', @iCategId, '_visualdrugs_google_maps_directions_map_height', 'digit', '', '', '8', ''),
    ('visualdrugs_google_maps_directions_marker_title', '', @iCategId, '_visualdrugs_google_maps_directions_marker_title', 'digit', '', '', '9', ''),
    ('visualdrugs_google_maps_directions_footer_html', '', @iCategId, '_visualdrugs_google_maps_directions_text_below', 'text', '', '', '10', '');

-- permalinks
INSERT INTO `sys_permalinks` VALUES (NULL, 'modules/?r=directions/', 'm/directions/', 'visualdrugs_google_maps_directions_permalinks');

-- admin menu
SET @iMax = (SELECT MAX(`order`) FROM `sys_menu_admin` WHERE `parent_id` = '2');

INSERT IGNORE INTO `sys_menu_admin` (`parent_id`, `name`, `title`, `url`, `description`, `icon`, `order`) VALUES
    (2, 'vd_google_maps_directions', '_visualdrugs_google_maps_directions', '{siteUrl}modules/?r=directions/administration/', 'Google Maps', 'modules/visualdrugs/google_maps_directions/|top_menu_icon.png', @iMax+1);

-- site menu
SELECT @iTMOrder:=MAX(`Order`) FROM `sys_menu_top` WHERE `Parent`='0';
INSERT INTO `sys_menu_top` (`Parent`, `Name`, `Caption`, `Link`, `Order`, `Visible`, `Target`, `Onclick`, `Check`, `Editable`, `Deletable`, `Active`, `Type`, `Picture`, `BQuickLink`, `Statistics`) VALUES
    (0, 'Directions', '_visualdrugs_google_maps_directions_top_menu_item', 'modules/?r=directions/home/|modules/?r=directions/', @iTMOrder+1, 'non,memb', '', '', '', 1, 1, 1, 'top', 'modules/visualdrugs/google_maps_directions/|top_menu_icon.png', 1, '');
