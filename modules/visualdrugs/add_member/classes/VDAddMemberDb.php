<?php
/**
 * VisualDRUGS Add Member module for Boonex Dolphin v7.0.x
 *
 * @author     André Fiedler <kontakt@visualdrugs.net>
 * @copyright  2011 Dipl.-Ing. (FH) André Fiedler.
 * @license    MIT-style license
 * @version    1.0.0
 */

bx_import('BxDolModuleDb');

class VDAddMemberDb extends BxDolModuleDb {

	public function __construct(&$config) {
		parent::__construct();
        $this->_sPrefix = $config->getDbPrefix();
    }
    
    public function insertProfile($data) {
        $nickname = $this->escape($data['NickName'], false);
        $email = $this->escape($data['Email']);
        $salt = base64_encode(substr(md5(microtime()), 2, 6));
        $password = encryptUserPwd($data['Password'], $salt);
        $firstname = '';
        if(isset($data['FirstName']))
            $firstname = $this->escape($data['FirstName']);
        $lastname = '';
        if(isset($data['LastName']))
            $lastname = $this->escape($data['LastName']);
        $zip = '';
        if(isset($data['zip']))
            $zip = $this->escape($data['zip']);
        $city = '';
        if(isset($data['City']))
            $city = $this->escape($data['City']);
        $country = '';
        if(isset($data['Country']))
            $country = $this->escape($data['Country']);
        $query = "
            INSERT INTO `Profiles`
                (`NickName`, `Email`, `Password`, `Salt`, `Status`, `Role`, `Country`, `City`, `DateReg`, `zip`, `FirstName`, `LastName`)
            VALUES
                ('{$nickname}', '{$email}', '{$password}', '{$salt}', 'Active', 2, '{$country}', '{$city}', NOW(), '{$zip}', '{$firstname}', '{$lastname}')
        ";
        $this->query($query);
    }
    
    public function isUnique($key, $value){
        $value = addslashes($value);
        $query = "SELECT COUNT(*) FROM `Profiles` WHERE `$key` = '$value'";
        if((int)db_value($query) > 0)
            return false;
        return true;
    }
}

?>
