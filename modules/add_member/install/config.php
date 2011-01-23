<?php
/**
 * VisualDRUGS Add Member module for Boonex Dolphin v7.0.x
 *
 * @author     André Fiedler <kontakt@visualdrugs.net>
 * @copyright  2011 Dipl.-Ing. (FH) André Fiedler.
 * @license    MIT-style license
 * @version    1.0.0
 */

$aConfig = array(
	
	'title' => 'Add new Member (backend)',
    'version' => '1.0.0',
	'vendor' => 'VisualDRUGS.net',
	'update_url' => '',
	
	'compatible_with' => array(
        '7.0.x'
    ),

	'home_dir' => 'visualdrugs/add_member/',
	'home_uri' => 'add_member',
	
	'db_prefix' => 'visualdrugs_add_member_',
    'class_prefix' => 'VDAddMember',
    
	'install' => array(
        'update_languages' => 1,
        'execute_sql' => 1,
        'recompile_permalinks' => 1
	),
	   
	'uninstall' => array (
        'update_languages' => 1,
        'execute_sql' => 1,
        'recompile_permalinks' => 1
    ),

	'language_category' => 'VisualDRUGS Add Member',

	'install_permissions' => array(),
    'uninstall_permissions' => array(),

	'install_info' => array(
		'introduction' => '',
		'conclusion' => ''
	),
	'uninstall_info' => array(
		'introduction' => '',
		'conclusion' => ''
	)
);

?>
