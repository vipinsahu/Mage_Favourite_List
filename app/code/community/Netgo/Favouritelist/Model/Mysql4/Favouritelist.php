<?php
class Netgo_Favouritelist_Model_Mysql4_Favouritelist extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("favouritelist/favouritelist", "favouritelist_id");
    }
}