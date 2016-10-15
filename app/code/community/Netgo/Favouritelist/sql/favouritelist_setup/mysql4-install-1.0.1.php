<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table favouritelist(favouritelist_id int not null auto_increment, customerid int,  productid int, producttype varchar(100), productoption text,productlink varchar(500), bundle_option varchar(500), product_super_attribute varchar(500), super_group varchar(500), productqty int, primary key(favouritelist_id));
  
SQLTEXT;

$installer->run($sql);
$installer->endSetup();
	 