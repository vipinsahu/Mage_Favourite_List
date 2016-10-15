<?php
class Netgo_Favouritelist_Helper_Data extends Mage_Core_Helper_Abstract
{


    public function __construct(){
	
	        		if(Mage::getStoreConfig('favouritelist/favouritelistsetting/enable')==0 and (!Mage::app()->getStore()->isAdmin()))
					{
					
					  Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl());
					 
					}
					
              }
			  
			  public function getUrl($product)
				{
				
				      $fid = (int)  Mage::app()->getRequest()->getParam('flid');
					 
					  if($fid > 0){
					  
					     $fvurl=Mage::getBaseUrl().'favouritelist/index/updatefavouritelist/item/'.$fid;
					  
					  }else
					   {
					$fvurl=Mage::getBaseUrl().'favouritelist/index/addfavouritelist/product/'.$product->getId();
					}					
					return $fvurl;
				}
				
				public function isAllow()
				{
					
					return Mage::getStoreConfig('favouritelist/favouritelistsetting/enable');
				}

  
}
	 