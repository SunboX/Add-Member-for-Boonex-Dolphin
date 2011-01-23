<?php
/**
 * VisualDRUGS Google Maps Directions for Boonex Dolphin v7.0.x
 *
 * @author     André Fiedler <kontakt@visualdrugs.net>
 * @copyright  2011 Dipl.-Ing. (FH) André Fiedler.
 * @license    MIT-style license
 * @version    1.0.0
 */

bx_import('BxDolModule');
require_once('VDGoogleMapsDirectionsAdminSettings.php');

class VDGoogleMapsDirectionsModule extends BxDolModule {

    public function __construct(&$aModule) {        
        parent::__construct($aModule);
    }

    public function actionHome() {
        $this->_oTemplate->pageStart();
        $this->_oTemplate->addJs('http://maps.google.com/maps/api/js?sensor=false&key=' . getParam('visualdrugs_google_maps_directions_api_key'));
        $header = getParam('visualdrugs_google_maps_directions_header_html');
        $headerStriped = trim(strip_tags($header));
        $footer = getParam('visualdrugs_google_maps_directions_footer_html');
        $footerStriped = trim(strip_tags($footer));
        $adress = getParam('visualdrugs_google_maps_directions_adress_html');
        $adressStriped = trim(strip_tags($adress));
        $aVars = array(
            'map_type'       => strtoupper(getParam('visualdrugs_google_maps_directions_type')),
            'map_zoom'       => getParam('visualdrugs_google_maps_directions_zoom'),
            'map_height'     => getParam('visualdrugs_google_maps_directions_map_height'),
            'marker_title'   => getParam('visualdrugs_google_maps_directions_marker_title'),
            'lat'            => getParam('visualdrugs_google_maps_directions_lat'),
            'lng'            => getParam('visualdrugs_google_maps_directions_lng'),
            'bx_if:header'   => array(
                'condition'  => !empty($headerStriped),
                'content'    => array(
                    'header' => $header
                ),
            ),
            'bx_if:footer'   => array(
                'condition'  => !empty($footerStriped),
                'content'    => array(
                    'footer' => $footer
                ),
            ),
            'bx_if:adress'   => array(
                'condition'  => !empty($adressStriped),
                'content'    => array(
                    'adress' => str_replace('\'', '\\\'', $adress)
                ),
            )
        );
        
        echo $this->_oTemplate->parseHtmlByName('main', $aVars);
        $this->_oTemplate->pageCode(_t('_visualdrugs_google_maps_directions'), true);
    }
    
    /*
     * Admin
     */
    
    public public function actionAdministration() {

        if (!$GLOBALS['logged']['admin']) {
            $this->_oTemplate->displayAccessDenied ();
            return;
        }
        
        $this->_oTemplate->pageStart();

        $iId = $this->_oDb->getSettingsCategory();
        if(empty($iId)) {
            echo MsgBox(_t('_sys_request_page_not_found_cpt'));
            $this->_oTemplate->pageCodeAdmin(_t('_visualdrugs_google_maps_directions'));
            return;
        }
        
        $aVars = array();
        $sContent .= $this->_oTemplate->parseHtmlByName('admin_explanation', $aVars);
        echo $this->_oTemplate->adminBlock($sContent, _t('_visualdrugs_google_maps_directions_info'));

        $mixedResult = '';
        if(isset($_POST['save']) && isset($_POST['cat'])) {
            $oSettings = new VDGoogleMapsDirectionsAdminSettings($iId);
            $_POST['visualdrugs_google_maps_directions_zoom']         = (int)$_POST['visualdrugs_google_maps_directions_zoom'];
            $_POST['visualdrugs_google_maps_directions_map_height']   = (int)$_POST['visualdrugs_google_maps_directions_map_height'];
            $_POST['visualdrugs_google_maps_directions_lat']          = (float)$_POST['visualdrugs_google_maps_directions_lat'];
            $_POST['visualdrugs_google_maps_directions_lng']          = (float)$_POST['visualdrugs_google_maps_directions_lng'];
            $_POST['visualdrugs_google_maps_directions_marker_title'] = strip_tags($_POST['visualdrugs_google_maps_directions_marker_title']);
            $mixedResult = $oSettings->saveChanges($_POST);
        }

        $oSettings = new VDGoogleMapsDirectionsAdminSettings($iId);
        $sResult = $oSettings->getForm();
               
        if($mixedResult !== true && !empty($mixedResult))
            $sResult = $mixedResult . $sResult;

        echo DesignBoxAdmin(_t('_visualdrugs_google_maps_directions'), $sResult);
        
        $this->_oTemplate->pageCodeAdmin(_t('_visualdrugs_google_maps_directions_page'));
    }
}

?>
