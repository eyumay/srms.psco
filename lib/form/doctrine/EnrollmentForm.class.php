// lib/form/doctrine/EnrollmentForm.class.php 
class EnrollmentForm extends sfForm
{
  public function configure()
  {
    if (!$product = $this->getOption('product'))
    {
      throw new InvalidArgumentException('You must pro vide a product object.');
    }
 
    for ($i = 0; $i < $this->getOption('size', 2); $i++)
    {
      $productPhoto = new ProductPhoto();
      $productPhoto->Product = $product;
 
      $form = new ProductPhotoForm($productPhoto);
 
      $this->embedForm($i, $form);
    }
  }
} 