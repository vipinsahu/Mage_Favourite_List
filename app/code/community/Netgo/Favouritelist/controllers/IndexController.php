<?php
class Netgo_Favouritelist_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  
	  if(!Mage::getSingleton('customer/session')->isLoggedIn()) {
					   		 Mage::getSingleton('customer/session')->setAfterAuthUrl(Mage::helper('core/url')->getCurrentUrl());			      
						   $this->_redirectUrl(Mage::getUrl('customer/account/login/'));	
					   }
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("My Favouritelist"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("favouritelist", array(
                "label" => $this->__("My Favouritelist"),
                "title" => $this->__("My Favouritelist")
		   ));

      $this->renderLayout(); 
	  
    }
	
	public function addfavouritelistAction() {
	
	
	
	          $post_data=$this->getRequest()->getPost();
			  $prid=  (int)$this->getRequest()->getParam('product');
			 
			  
			  if(empty($post_data) and $prid >0)
			  {
			    $post_data['product']=$prid;
				$post_data['qty']=1;
				 
			  }
		    
			 //print_r($post_data);
			// die;
	       if($customer = Mage::getSingleton('customer/session')->isLoggedIn()) {
		         $customerData = Mage::getSingleton('customer/session')->getCustomer();
		       		$customerID=$customerData->getId(); 
					
					$productqty=$post_data['qty'];
					$productId=$post_data['product'];
					
					 $product=Mage::getModel('catalog/product')->load($productId);
					 $productType=$product->getTypeID();
					 
					   $super_attribute=$post_data['super_attribute'];
						
					    $options=$post_data['options'];
					    $links=$post_data['links'];
					    $bundle_option=$post_data['bundle_option'];			
                        $super_group=$post_data['super_group'];	 						
					    $postdata['customerid']=$customerID;
						$postdata['productid']=$productId;
						$postdata['producttype']=$productType;
						$postdata['productoption']=serialize($options);
						
						$postdata['productlink']=serialize($links);
						$postdata['bundle_option']=serialize($bundle_option);
						
						$postdata['product_super_attribute']=serialize($super_attribute);
						
						$postdata['super_group']=serialize($super_group);
						
						$postdata['productqty']=$productqty;
						
                       			  
				if ($postdata['productid']) {

					try {
					 
					 			 				     
						  
						$checkfv=  $this->checkfavouritelist($customerID,$productId,$postdata);
						if(!empty($checkfv))
						{
						  $fvid=$checkfv['id'];
						  $postdata['productqty']=$checkfv['qty'];
						  
						 
						}
						$model = Mage::getModel("favouritelist/favouritelist")
						->addData($postdata)
						->setId($fvid)
						->save();
						
                         Mage::getSingleton('core/session')->addSuccess($product->getName()." has been added in favourite list");
						
						 $this->_redirectUrl("favouritelist/index/");
						 
						 $url=Mage::getBaseUrl().'favouritelist/index/';
						
					} 
					catch (Exception $e) {
					 $url=Mage::getBaseUrl();
					return;
					}

				}
				
				
				
			}else
			 {
			     $url=Mage::getBaseUrl().'customer/account/login/';
				 Mage::getSingleton('customer/session')->setAfterAuthUrl(Mage::helper('core/url')->getCurrentUrl());
				 //die;
			 }
		
	       
				
			 $this->_redirectUrl($url);	
	  
	   
	}
	
	public function checkfavouritelist($customerID,$productId,$postdata)
	  {
	                    $favouriteList = Mage::getModel('favouritelist/favouritelist')->getCollection()
						  ->addFieldToFilter('customerid',$customerID)
						  ->addFieldToFilter('productid',$productId)
						  ->addFieldToFilter('producttype',$postdata['producttype'])
						  ->addFieldToFilter('productoption',$postdata['productoption'])
						  ->addFieldToFilter('productlink',$postdata['productlink'])
						  ->addFieldToFilter('bundle_option',$postdata['bundle_option'])
						  ->addFieldToFilter('product_super_attribute',$postdata['product_super_attribute'])
						  ->addFieldToFilter('super_group',$postdata['super_group'])->getData();
						  $data=array();
						    if(count($favouriteList)>0)
							{
							 
							  $data['id']=$favouriteList[0]['favouritelist_id'];
							  $data['qty']=$favouriteList[0]['productqty']+$postdata['productqty'];
							}
						 return $data;
	  }
	
	public function updatefavouritelistAction() {
	
	
	
	          $post_data=$this->getRequest()->getPost();
			  
			//  print_r($post_data);
		    // die;
	       if($customer = Mage::getSingleton('customer/session')->isLoggedIn()) {
		         $customerData = Mage::getSingleton('customer/session')->getCustomer();
		       		$customerID=$customerData->getId(); 
					
					$productqty=$post_data['qty'];
					$productId=$post_data['product'];
					
					 $product=Mage::getModel('catalog/product')->load($productId);
					 $productType=$product->getTypeID();
					 
					   $super_attribute=$post_data['super_attribute'];
						
					   $options=$post_data['options'];
					    $links=$post_data['links'];
					    $bundle_option=$post_data['bundle_option'];			
                        $super_group=$post_data['super_group'];	 						
					    $postdata['customerid']=$customerID;
						$postdata['productid']=$productId;
						$postdata['producttype']=$productType;
						$postdata['productoption']=serialize($options);
						
						$postdata['productlink']=serialize($links);
						$postdata['bundle_option']=serialize($bundle_option);
						
						$postdata['product_super_attribute']=serialize($super_attribute);
						
						$postdata['super_group']=serialize($super_group);
						
						$postdata['productqty']=$productqty;
						
                       			  
				if ($postdata) {

					try {

						$model = Mage::getModel("favouritelist/favouritelist")
						->addData($postdata)
						->setId($this->getRequest()->getParam("item"))
						->save();
						
                         Mage::getSingleton('core/session')->addSuccess($product->getName()." has been  updated in favourite list");
						
						 $this->_redirectUrl("favouritelist/index/");
						 
						 $url=Mage::getBaseUrl().'favouritelist/index/';
						
					} 
					catch (Exception $e) {
					 $url=Mage::getBaseUrl();
					return;
					}

				}
				
				
				
			}else
			 {
			     $url=Mage::getBaseUrl().'customer/account/login/';
				 Mage::getSingleton('customer/session')->setAfterAuthUrl(Mage::helper('core/url')->getCurrentUrl());
				 //die;
			 }
		
	       
				
			 $this->_redirectUrl($url);	
	  
	   
	}
	
	
	public function additemAction(){
	             
                      $productData=$this->getRequest()->getParams();
					  $itemId=$productData['item'];
					   $favouriteData = Mage::getModel('favouritelist/favouritelist')->load($itemId);
					  
					     $options =unserialize($favouriteData->getProductoption());
						 $product_super_attribute=unserialize($favouriteData->getProductSuperAttribute());
						 $links=unserialize($favouriteData->getProductlink());
						 
						 $bundle_option=unserialize($favouriteData->getBundleOption());
						 
						  $super_group=unserialize($favouriteData->getSuperGroup());
						 
                         $_product = Mage::getModel('catalog/product')->load($favouriteData->getProductid());
						  $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')->getParentIdsByChild($_product->getId());
						   $pid = $favouriteData->getProductid();
						   $cart = Mage::getSingleton('checkout/cart'); 
						   $cart->init();
						  
					
						    $productType=$_product->getTypeID();
								try {
							   if($productType=='simple' or $productType=='configurable')
							   {
																		 
								 $cart->addProduct($_product , 
										array( 'product_id' => $favouriteData->getProductid(),
													 'qty' => $favouriteData->getProductqty(),
													 'super_attribute' => $product_super_attribute,
													 'options' => $options));
													 
								}elseif($productType=='downloadable')
								{
								  $cart->addProduct($_product , 
										array( 'product_id' => $favouriteData->getProductid(),
													 'qty' => $favouriteData->getProductqty(),
													 'links' => $links,
													 'options' => $options));
								}
								elseif($productType=='bundle')
								{
								  $cart->addProduct($_product , 
										array( 'product_id' => $favouriteData->getProductid(),
													 'qty' => $favouriteData->getProductqty(),
													 'bundle_option' => $bundle_option,
													 'options' => $options));
								}
								elseif($productType=='virtual')
								{
								  $cart->addProduct($_product , 
										array( 'product_id' => $favouriteData->getProductid(),
													 'qty' => $favouriteData->getProductqty(),
													 'options' => $options));
								}elseif($productType=='grouped')
								{
								  $cart->addProduct($_product , 
										array( 'product_id' => $favouriteData->getProductid(),
													 'qty' => $favouriteData->getProductqty(),
													 'super_group' => $super_group));
								}
								
							 $cart->save(); 
							 $url=Mage::getBaseUrl().'checkout/cart/';		 
							}catch (Exception $e) {
												
						       Mage::getSingleton('core/session')->addError($e->getMessage());
							   
							   $url=$_product->getUrl();	
							 
						 
										
					          }
						   

                        
                           $this->_redirectUrl($url);							

																  
										  
										  
	
	}
	
	public function removeitemAction(){
	             
                      $productData=$this->getRequest()->getParams();
					   $itemId=$productData['item'];
					  
					
					  
					   if($itemId > 0 ) {
					try {
						$model = Mage::getModel("favouritelist/favouritelist");
						$model->setId($itemId)->delete();
						 Mage::getSingleton('core/session')->addSuccess("Item was successfully deleted");
						$url=Mage::getBaseUrl().'favouritelist/index/';
					  } 
					catch (Exception $e) {
												
						 Mage::getSingleton('core/session')->addError($e->getMessage());
						 $url=Mage::getBaseUrl().'favouritelist/index/';
										
					}
				}else
				 {
				   Mage::getSingleton('core/session')->addError('Item not found');
						 $url=Mage::getBaseUrl().'favouritelist/index/';
				 }
				
				
				
				  $this->_redirectUrl($url);
					  
		  
	
	}
	
	public function updateAction(){
	   
	 $post_data=$this->getRequest()->getPost();
		 
	  $qty=$post_data['qty'];
	 
	   try {

				 	foreach($qty as $fvid=>$prqty)
					{
					 $post_data['productqty']=$prqty;
					$model = Mage::getModel("favouritelist/favouritelist")
						->addData($post_data)
						->setId($fvid)
						->save();
                    }
					 Mage::getSingleton('core/session')->addSuccess('Item was updated');						
		} 
		catch (Exception $e) {
						
						 Mage::getSingleton('core/session')->addError($e->getMessage());
						
						
			}
	 
	              
		 $url=Mage::getBaseUrl().'favouritelist/index/';
	   $this->_redirectUrl($url);
		
	}
	public function addallitemAction(){
	   
	    $post_data=$this->getRequest()->getPost();
		
		      $customerData = Mage::getSingleton('customer/session')->getCustomer();
		      $customerId=$customerData->getId(); 
		       $favouriteList = Mage::getModel('favouritelist/favouritelist')->getCollection()->addFieldToFilter('customerid',$customerId);
			   
			   foreach($favouriteList as $fvdata)
			   {
			       
				   
				     $itemId=$fvdata->getId();
					   $favouriteData = Mage::getModel('favouritelist/favouritelist')->load($itemId);
					  
					     $options =unserialize($favouriteData->getProductoption());
						 $product_super_attribute=unserialize($favouriteData->getProductSuperAttribute());
						 
						  $links=unserialize($favouriteData->getProductlink());
						 
						 $bundle_option=unserialize($favouriteData->getBundleOption());
						 
						  $super_group=unserialize($favouriteData->getSuperGroup());
                         $_product = Mage::getModel('catalog/product')->load($favouriteData->getProductid());
						 
						  $pid = $favouriteData->getProductid();
						   $cart = Mage::getSingleton('checkout/cart'); 
						   $cart->init();
						  
					
						    $productType=$_product->getTypeID();
								try {
							   if($productType=='simple' or $productType=='configurable')
							   {
																		 
								 $cart->addProduct($_product , 
										array( 'product_id' => $favouriteData->getProductid(),
													 'qty' => $favouriteData->getProductqty(),
													 'super_attribute' => $product_super_attribute,
													 'options' => $options));
													 
								}elseif($productType=='downloadable')
								{
								  $cart->addProduct($_product , 
										array( 'product_id' => $favouriteData->getProductid(),
													 'qty' => $favouriteData->getProductqty(),
													 'links' => $links,
													 'options' => $options));
								}
								elseif($productType=='bundle')
								{
								  $cart->addProduct($_product , 
										array( 'product_id' => $favouriteData->getProductid(),
													 'qty' => $favouriteData->getProductqty(),
													 'bundle_option' => $bundle_option,
													 'options' => $options));
								}
								elseif($productType=='virtual')
								{
								  $cart->addProduct($_product , 
										array( 'product_id' => $favouriteData->getProductid(),
													 'qty' => $favouriteData->getProductqty(),
													 'options' => $options));
								}elseif($productType=='grouped')
								{
								  $cart->addProduct($_product , 
										array( 'product_id' => $favouriteData->getProductid(),
													 'qty' => $favouriteData->getProductqty(),
													 'super_group' => $super_group));
								}
								
									 $cart->save(); 
							
							}catch (Exception $e) {
												
						       Mage::getSingleton('core/session')->addError($e->getMessage());
							   
							   $url=$_product->getUrl();	
							 
						 
										
					          }
				   
				   
				   
			   }
			   
			 $url=Mage::getBaseUrl().'checkout/cart/';	
             $this->_redirectUrl($url);			 
	 }
	 
	  public function configureAction()
    {
	   
        $id = (int) $this->getRequest()->getParam('flid');
        try {
            /* @var $item Mage_Wishlist_Model_Item */
           
            
			$favouriteData = Mage::getModel('favouritelist/favouritelist')->load($id);

			$_product = Mage::getModel('catalog/product')->load($favouriteData->getProductid());
			
			
            $params = new Varien_Object();
            $params->setCategoryId(false);
            $params->setConfigureMode(true);
			
			
			 
			   if($favouriteData->getProducttype()=='configurable')
				{
				   $bRequest['super_attribute']=unserialize($favouriteData->getProductSuperAttribute());
				}
			   if($favouriteData->getProducttype()=='grouped')
				{
				   $bRequest['super_group']=unserialize($favouriteData->getSuperGroup());
				}
			 if($favouriteData->getProducttype()=='downloadable')
				{
				   $bRequest['links']=unserialize($favouriteData->getProductlink());
				}
				
			  if($favouriteData->getProducttype()=='bundle')
				{
				   $bRequest['bundle_option']=unserialize($favouriteData->getBundleOption());
				}
				
			
				
			    $bRequest['options']=unserialize($favouriteData->getProductoption());
				 $bRequest['qty']=$favouriteData->getProductqty();
			    $buyRequest = new Varien_Object($bRequest); 
			  
               $params->setBuyRequest($buyRequest);
			
			
            Mage::helper('catalog/product_view')->prepareAndRender($_product->getId(), $this, $params);
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
           
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($this->__('Cannot configure product'));
            Mage::logException($e);
            $this->_redirect('*');
            return;
        }
		//$this->loadLayout();  

 //$this->renderLayout(); 
    }
	 
}