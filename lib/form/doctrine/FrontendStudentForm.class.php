<?php

/**
 * Student form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FrontendStudentForm extends BaseStudentForm
{

  //private $sectionId        = NULL;
  
  public function __construct($studentObj = NULL )
  {
    //$this->sectionId        = $sectionId;
    
    
    parent::__construct($studentObj);
  }

  public function configure()
  { 
    parent::configure(); 
    unset($this['admission_year'], $this['id']); 
    
    ## WIDGETS ###################    
    $this->widgetSchema['name'] =  new sfWidgetFormInput();
    $this->validatorSchema['name'] = new sfValidatorRegex(array( 
        'pattern'=>'/^[a-zA-Z\s]{2,}$/'), array(
        'invalid' => 'Name is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));    
    
    $this->widgetSchema['fathers_name'] =  new sfWidgetFormInput();
    $this->validatorSchema['fathers_name'] = new sfValidatorRegex(array(
        'pattern'=>'/^[a-zA-Z\s]{2,}$/'), array(
        'invalid' => 'Father name is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));
    
    
    $this->widgetSchema['grandfathers_name'] =  new sfWidgetFormInput();
    $this->validatorSchema['grandfathers_name'] = new sfValidatorRegex(array(
        'pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => true), array(
        'invalid' => 'Grand Father name is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));    
    
    $this->widgetSchema['mother_name'] =  new sfWidgetFormInput();
    $this->validatorSchema['mother_name'] = new sfValidatorRegex(array
    ('pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => true), array(
     'invalid' => 'Mother name is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
        ));         
    
    //$this->widgetSchema['name'] =  new sfWidgetFormInput();       
    $this->widgetSchema['date_of_birth'] = new sfWidgetFormDate(array('can_be_empty' =>true, 'years' => FormChoices::getYearsForDateOfBirth() ));
    $this->validatorSchema['date_of_birth'] = new sfValidatorDate(array('required' => true));
    
    $this->widgetSchema['sex'] = new sfWidgetFormChoice(array('choices' => FormChoices::getGenderChoices(), 'expanded' => true ));
    $this->validatorSchema['sex'] = new sfValidatorChoice(array('choices' => array_keys(FormChoices::getGenderChoices()), 'required' => true ));
    
    $this->widgetSchema['nationality'] =  new sfWidgetFormInput();
    $this->validatorSchema['nationality'] = new sfValidatorRegex(array
('pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => true), array('invalid' => 'Nationlity is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));    
        
    //$this->widgetSchema['admission_year'] = new sfWidgetFormChoice(array('choices'=> FormChoices::getAdmissionYearChoices() ));     
    $this->widgetSchema['birth_location'] =  new sfWidgetFormInput();  
    $this->validatorSchema['birth_location'] = new sfValidatorRegex(array
('pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => false), array('invalid' => 'Birth location is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));    
    
    $this->widgetSchema['residence_city'] =  new sfWidgetFormInput();
    $this->validatorSchema['residence_city'] = new sfValidatorRegex(array
('pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => false), array('invalid' => 'Residence city is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));    
    
    $this->widgetSchema['residence_woreda'] =  new sfWidgetFormInput();
    $this->validatorSchema['residence_woreda'] = new sfValidatorRegex(array
('pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => false), array('invalid' => 'Woreda is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));     
    
    
    $this->widgetSchema['residence_kebele'] =  new sfWidgetFormInput();
    $this->validatorSchema['residence_kebele'] = new sfValidatorString(array('required'=>false));
    
    $this->widgetSchema['residence_house_number'] =  new sfWidgetFormInput();
    $this->validatorSchema['residence_house_number'] = new sfValidatorString(array('required'=>false));
    
    $this->widgetSchema['ethnicity'] =  new sfWidgetFormInput();
    $this->validatorSchema['ethnicity'] = new sfValidatorRegex(array
('pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => false), array('invalid' => 'Ethnicity is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));    
    
    $this->widgetSchema['telephone'] =  new sfWidgetFormInput();
    $this->validatorSchema['telephone'] = new sfValidatorString(array('required' => true));
    //$this->validatorSchema['telephone'] = new sfValidatorRegex(array('pattern'=>'/\+[0-9]{6,}/',  'required' => true));    $this->validatorSchema['telephone'] = new sfValidatorRegex(array('pattern'=>'/\+[0-9]{6,}/',  'required' => true));    

    
    $this->widgetSchema['email'] = new sfWidgetFormInputText();
    $this->validatorSchema['email'] = new sfValidatorEmail(array('required' => false));

    //$this->validatorSchema['admission_year'] = new sfValidatorChoice(array('choices' => array_keys(FormChoices::getAdmissionYearChoices()), 'required' => true ));
    ##   PREVENT REPETITION IN REGISTRATION
    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Student', 'column' => array('first_name', 'middle_name', 'last_name', 'date_of_birth')), array('invalid' => 'This student is already registered ! ! '))            
    );
    $this->widgetSchema->setLabels(array(
        'student_uid' => 'Student ID No. *',
        'name' => 'Name *',
        'fathers_name' => 'Fathers Name *', 
        'grandfathers_name' => 'Grandfathers Name *',
        'mother_name' => 'Mother Name *',
        'date_of_birth' => 'Date of Birth *',
        'sex' => 'Sex *',
        'nationality' => 'Nationality *',
        'telephone' => 'Telephone *',
    ));
    
   $this->widgetSchema->setNameFormat('studentform[%s]');
	 
         
  }
}
