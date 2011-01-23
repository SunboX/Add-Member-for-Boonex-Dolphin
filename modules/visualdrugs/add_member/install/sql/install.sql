-- settings

SET @iMaxOrder = (SELECT `menu_order` + 1 FROM `sys_options_cats` ORDER BY `menu_order` DESC LIMIT 1);

-- permalinks
INSERT INTO `sys_permalinks` VALUES (NULL, 'modules/?r=add_member/', 'm/add_member/', 'visualdrugs_add_member_permalinks');

-- admin menu
SET @iMax = (SELECT MAX(`order`) FROM `sys_menu_admin` WHERE `parent_id` = '2');

INSERT IGNORE INTO `sys_menu_admin` (`parent_id`, `name`, `title`, `url`, `description`, `icon`, `order`) VALUES
    (2, 'vd_add_member', '_visualdrugs_add_member', '{siteUrl}modules/?r=add_member/administration/', 'Add Member', 'modules/visualdrugs/add_member/|admin_menu_icon.png', @iMax+1);
