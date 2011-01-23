<?php
/**
 * VisualDRUGS Google Maps Directions for Boonex Dolphin v7.0.x
 *
 * @author     André Fiedler <kontakt@visualdrugs.net>
 * @copyright  2011 Dipl.-Ing. (FH) André Fiedler.
 * @license    MIT-style license
 * @version    1.0.0
 */

bx_import('BxDolAdminSettings');

class VDGoogleMapsDirectionsAdminSettings extends BxDolAdminSettings {
   
    public function _field($aItem) {
        $aField = parent::_field($aItem);
        switch($aItem['name']) {
            case 'visualdrugs_google_maps_directions_adress_html':
            case 'visualdrugs_google_maps_directions_header_html':
            case 'visualdrugs_google_maps_directions_footer_html':
                $aField['html'] = 2;
                break;
        }
        $aField['caption'] = _t($aField['caption']);
        return $aField;
    }
    
    public function saveChanges(&$aData) {
        $aCategories = explode(',', process_db_input($aData['cat']));
        foreach($aCategories as $mixedCategory) {
            if(!is_numeric($mixedCategory) || isset($this->_aCustomCategories[$mixedCategory]['save'])) {
                $mixedResult = $this->{$this->_aCustomCategories[$mixedCategory]['save']}($aData);
                if($mixedResult !== true)
                    return $mixedResult;
            }     
            else if(is_numeric($mixedCategory)) {
                $aItems = $this->_oDb->getAll("SELECT `Name` AS `name`, `desc` AS `title`, `Type` AS `type`, `AvailableValues` AS `extra`, `check` AS `check`, `err_text` AS `check_error` FROM `sys_options` WHERE `kateg`='" . (int)$mixedCategory . "'");

                $aItemsData = array();
                foreach($aItems as $aItem) {
                    if(is_array($aData[$aItem['name']]))
                        foreach($aData[$aItem['name']] as $sKey => $sValue)
                            $aItemsData[$aItem['name']][$sKey] = process_db_input($sValue);
                    else
                        $aItemsData[$aItem['name']] = process_db_input($aData[$aItem['name']]);

                    if(!empty($aItem['check'])) {
                        $oFunction = create_function('$arg0', $aItem['check']);
                        if(!$oFunction($aItemsData[$aItem['name']])) {
                            $this->_iCategoryActive = (int)$mixedCategory;
                            return MsgBox("'" . $aItem['title'] .  "' " . $aItem['check_error'], $this->_iResultTimer);
                        }
                    }

                    $bIsset = isset($aItemsData[$aItem['name']]);
                    if($bIsset && is_array($aItemsData[$aItem['name']]))
                        $aItemsData[$aItem['name']] = implode(',', $aItemsData[$aItem['name']]);
                    else if(!$bIsset)
                        $aItemsData[$aItem['name']] = $this->_empty($aItem);

                    setParam ($aItem['name'], $aItemsData[$aItem['name']]);
                }
            }
            if(isset($this->_aCustomCategories[$mixedCategory]['on_save']))
                $this->{$this->_aCustomCategories[$mixedCategory]['on_save']}();
        }
        return MsgBox(_t('_adm_txt_settings_success'), $this->_iResultTimer);
    }
}

?>