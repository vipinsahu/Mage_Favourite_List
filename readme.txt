/********** Usage in product listing page ***********/

If you want to show the link of Favourite list, add below code in the following path:

app/design/frontend/THEME_PACKAGE_NAME/THEME_NAME/template/catalog/product/list.phtml

add below code for both Grid and List section of product listing page.


<?php if (Mage::helper('favouritelist')->isAllow()) : ?>

<a href="<?php echo Mage::helper('favouritelist')->getUrl($_product) ?>" class="link-favourite">
<?php echo $this->__('Add to Favourite List') ?>
</a>
<?php endif; ?>