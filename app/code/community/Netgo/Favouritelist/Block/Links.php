<?php

class Netgo_Favouritelist_Block_Links extends Mage_Core_Block_Template
{
    
    public function addFavtLink()
    {
        $parentBlock = $this->getParentBlock();
   
               $helper = Mage::helper('favouritelist');	
		    	$customerData = Mage::getSingleton('customer/session')->getCustomer();
		       	$customerId=$customerData->getId(); 
		       $favouriteList = Mage::getModel('favouritelist/favouritelist')->getCollection()->addFieldToFilter('customerid',$customerId);
              $count=$favouriteList->getSize();
      
              if ($count == 1) {
                $text = $this->__('My Favourite List (%s item)', $count);
            } elseif ($count > 0) {
                $text = $this->__('My Favourite List (%s items)', $count);
            } else {
                $text = $this->__('My Favourite List');
            }
        
          
            $parentBlock->addLink($text, 'favouritelist/index', $text, true, array(), 50, null, 'class="top-link-fav"');
      
        return $this;
    }

 
}
