<?php

/**
 * StudentLoad form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class StudentLoadForm extends BaseStudentLoadForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at']);  
  }
}
