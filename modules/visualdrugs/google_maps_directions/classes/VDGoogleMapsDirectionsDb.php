<?php
/**
 * VisualDRUGS Google Maps Directions for Boonex Dolphin v7.0.x
 *
 * @author     André Fiedler <kontakt@visualdrugs.net>
 * @copyright  2011 Dipl.-Ing. (FH) André Fiedler.
 * @license    MIT-style license
 * @version    1.0.0
 */

bx_import('BxDolModuleDb');

class VDGoogleMapsDirectionsDb extends BxDolModuleDb {

	public function __construct(&$oConfig) {
		parent::__construct();
        $this->_sPrefix = $oConfig->getDbPrefix();
    }
    
    public function getSettingsCategory() {
        return $this->getOne("SELECT `ID` FROM `sys_options_cats` WHERE `name` = 'VisualDRUGS Google Maps Directions' LIMIT 1");
    }
}

?>
