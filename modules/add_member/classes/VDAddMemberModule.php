<?php
/**
 * VisualDRUGS Add Member module for Boonex Dolphin v7.0.x
 *
 * @author     André Fiedler <kontakt@visualdrugs.net>
 * @copyright  2011 Dipl.-Ing. (FH) André Fiedler.
 * @license    MIT-style license
 * @version    1.0.0
 */

bx_import('BxDolProfileFields');

class VDAddMemberModule extends BxDolModule {

    public function __construct(&$aModule) {        
        parent::__construct($aModule);
    }
    
    /*
     * Admin
     */
    
    public public function actionAdministration() {

        if (!$GLOBALS['logged']['admin']) {
            $this->_oTemplate->displayAccessDenied();
            return;
        }
        
        $this->_oTemplate->pageStart();

        if(isset($_POST['save'])) {
            
            $error = false;
            
            if(!isset($_POST['NickName'])){
                echo MsgBox(_t('_FieldError_NickName_Mandatory'));
                $error = true;
            }
            if(!$this->_oDb->isUnique('NickName', $_POST['NickName'])){
                echo MsgBox(_t('_FieldError_NickName_Unique'));
                $error = true;
            }
            if(!isset($_POST['Email'])){
                echo MsgBox(_t('_FieldError_Email_Mandatory'));
                $error = true;
            }
            if(!$this->_oDb->isUnique('Email', $_POST['Email'])){
                echo MsgBox(_t('_FieldError_Email_Unique'));
                $error = true;
            }
            if(!isset($_POST['Password'])){
                echo MsgBox(_t('_FieldError_Password_Mandatory'));
                $error = true;
            }
            
            if(!$error){
                $this->_oDb->insertProfile($_POST);
                echo MsgBox(_t('_visualdrugs_add_member_profile_created'));
                $_POST = array();
            }
        }

        $oProfileFields = new BxDolProfileFields(0);
        $countries = $oProfileFields->convertValues4Input('#!Country');
        asort($countries);

        $aForm = array(
            'form_attrs' => array(
                'id' => 'adm-settings-form',
                'name' => 'adm-settings-form',
                'action' => '',
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            ),
            'params' => array(
                'db' => array(
                    'table' => 'Profiles',
                    'key' => 'Name',
                    'uri' => '',
                    'uri_title' => '',
                    'submit_name' => 'save'
                ),
            ),
            'inputs' => array(
                'nickname' => array(
                    'type' => 'text',
                    'name' => 'NickName',
                    'value' => isset($_POST['nickname']) ? $_POST['nickname'] : '',
                    'caption' => _t('_NickName'),
                    'required' => true,
                    'checker' => array (
                        'func' => 'length',
                        'params' => array(3, 100),
                        'error' => _t('_categ_form_field_name_err'),
                    ),
                    'db' => array(
                        'pass' => 'Xss'
                    ),
                    'display' => true,
                ),
                'password' => array(
                    'type' => 'text',
                    'name' => 'Password',
                    'value' => isset($_POST['password']) ? $_POST['password'] : '',
                    'caption' => _t('_FieldCaption_Password_Join'),
                    'required' => true,
                    'checker' => array (
                        'func' => 'length',
                        'params' => array(3, 100),
                        'error' => _t('_FieldError_Password_Min', 3),
                    ),
                    'db' => array(
                        'pass' => 'Xss'
                    ),
                    'display' => true,
                ),
                'firstname' => array(
                    'type' => 'text',
                    'name' => 'FirstName',
                    'value' => isset($_POST['firstname']) ? $_POST['firstname'] : '',
                    'caption' => _t('_FieldCaption_FirstName_Edit'),
                    'required' => false,
                    'checker' => array (),
                    'db' => array(
                        'pass' => 'Xss'
                    ),
                    'display' => true,
                ),
                'lastname' => array(
                    'type' => 'text',
                    'name' => 'LastName',
                    'value' => isset($_POST['lastname']) ? $_POST['lastname'] : '',
                    'caption' => _t('_FieldCaption_LastName_Edit'),
                    'required' => false,
                    'checker' => array (),
                    'db' => array(
                        'pass' => 'Xss'
                    ),
                    'display' => true,
                ),
                'email' => array(
                    'type' => 'text',
                    'name' => 'Email',
                    'value' => isset($_POST['email']) ? $_POST['email'] : '',
                    'caption' => _t('_E-mail'),
                    'required' => true,
                    'checker' => array (
                        'func' => 'length',
                        'params' => array(3, 100),
                        'error' => _t('_categ_form_field_name_err'),
                    ),
                    'db' => array(
                        'pass' => 'Xss'
                    ),
                    'display' => true,
                ),
                'zip' => array(
                    'type' => 'text',
                    'name' => 'zip',
                    'value' => isset($_POST['zip']) ? $_POST['zip'] : '',
                    'caption' => _t('_FieldCaption_zip_Edit'),
                    'required' => false,
                    'checker' => array (),
                    'db' => array(
                        'pass' => 'Xss'
                    ),
                    'display' => true,
                ),
                'city' => array(
                    'type' => 'text',
                    'name' => 'City',
                    'value' => isset($_POST['city']) ? $_POST['city'] : '',
                    'caption' => _t('_City'),
                    'required' => false,
                    'checker' => array (),
                    'db' => array(
                        'pass' => 'Xss'
                    ),
                    'display' => true,
                ),
                'country' => array(
                    'type' => 'select',
                    'name' => 'Country',
                    'values' => $countries,
                    'caption' => _t('_Country'),
                    'required' => false,
                    'checker' => array (),
                    'db' => array(
                        'pass' => 'Xss'
                    ),
                    'display' => true,
                ),
                'save' => array(
                    'type' => 'submit',
                    'name' => 'save',
                    'value' => _t('_adm_btn_settings_save'),
                )
            )
        );
        
        $oForm = new BxTemplFormView($aForm);
        $oForm->initChecker();

        $sResult = $oForm->getCode();

        echo DesignBoxAdmin(_t('_visualdrugs_add_member_pinfo'), $sResult);
        
        $this->_oTemplate->pageCodeAdmin(_t('_visualdrugs_add_member'));
    }
}

?>
