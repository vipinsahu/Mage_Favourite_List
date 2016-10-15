<?php   
class Netgo_Favouritelist_Block_Index extends Mage_Core_Block_Template{   


    
     public function __construct(){
        parent::__construct();
		  
		       $helper = Mage::helper('favouritelist');	
		        $customerData = Mage::getSingleton('customer/session')->getCustomer();
		       	$customerId=$customerData->getId(); 
		       $favouriteList = Mage::getModel('favouritelist/favouritelist')->getCollection()->addFieldToFilter('customerid',$customerId)->setOrder('favouritelist_id', 'DESC');;
	
            $this->setFavouritelist($favouriteList);
		 
		
}	
	  


}