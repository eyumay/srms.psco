<?php

/**
 * StudentWithdrawal form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class StudentWithdrawalForm extends BaseStudentWithdrawalForm
{
  public function configure_specific()
  {
      unset($this['created_at'], $this['updated_at']);
      
  }
  public function configure()
  {
      parent::configure();
      $this->configure_specific();
  }
}
