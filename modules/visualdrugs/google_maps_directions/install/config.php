<?php
/**
 * VisualDRUGS Google Maps Directions for Boonex Dolphin v7.0.x
 *
 * @author     André Fiedler <kontakt@visualdrugs.net>
 * @copyright  2011 Dipl.-Ing. (FH) André Fiedler.
 * @license    MIT-style license
 * @version    1.0.0
 */

$aConfig = array(
	
	'title' => 'Google Maps Directions Page',
    'version' => '1.0.0',
	'vendor' => 'VisualDRUGS.net',
	'update_url' => '',
	
	'compatible_with' => array(
        '7.0.x'
    ),

	'home_dir' => 'visualdrugs/google_maps_directions/',
	'home_uri' => 'directions',
	
	'db_prefix' => 'visualdrugs_google_maps_directions_',
    'class_prefix' => 'VDGoogleMapsDirections',
    
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

	'language_category' => 'VisualDRUGS Google Maps Directions',

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
