
-- permalinks
DELETE FROM `sys_permalinks` WHERE `standard` = 'modules/?r=add_member/';

-- admin menu
DELETE FROM `sys_menu_admin` WHERE `name` = 'vd_add_member';
