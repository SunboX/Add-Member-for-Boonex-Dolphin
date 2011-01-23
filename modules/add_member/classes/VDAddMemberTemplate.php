<?php
/**
 * VisualDRUGS Add Member module for Boonex Dolphin v7.0.x
 *
 * @author     André Fiedler <kontakt@visualdrugs.net>
 * @copyright  2011 Dipl.-Ing. (FH) André Fiedler.
 * @license    MIT-style license
 * @version    1.0.0
 */

bx_import ('BxDolTwigTemplate');

class VDAddMemberTemplate extends BxDolTwigTemplate {
    
	public function __construct(&$oConfig, &$oDb) {
	    parent::__construct($oConfig, $oDb);
    }
}

?>
