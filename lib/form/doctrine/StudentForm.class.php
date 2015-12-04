<?php

/**
 * Student form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class StudentForm extends BaseStudentForm
{

  private $departmentId     = NULL;
  private $sectionId        = NULL;
  
  public function __construct($departmentId = NULL, $sectionId = NULL, $studentObj = NULL )
  {
    $this->departmentId     = $departmentId;
    $this->sectionId        = $sectionId;
    
    
    parent::__construct($studentObj);
  }

  public function configure()
  { 
 
    
    ## WIDGETS ###################         
    $this->widgetSchema['date_of_birth'] = new sfWidgetFormDate(array('can_be_empty' =>true, 'years' => FormChoices::getYearsForDateOfBirth() ));
    $this->widgetSchema['sex'] = new sfWidgetFormChoice(array('choices' => FormChoices::getGenderChoices(), 'expanded' => true ));
    $this->widgetSchema['admission_year'] = new sfWidgetFormChoice(array('choices'=> FormChoices::getAdmissionYearChoices() )); 
    $this->widgetSchema['email'] = new sfWidgetFormInputText();

    ## VALIDATORS ##
    $this->validatorSchema['name'] = new sfValidatorRegex(array( 
        'pattern'=>'/^[a-zA-Z\s]{2,}$/'), array(
        'invalid' => 'Name is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));
    $this->validatorSchema['fathers_name'] = new sfValidatorRegex(array(
        'pattern'=>'/^[a-zA-Z\s]{2,}$/'), array(
        'invalid' => 'Father name is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));
    $this->validatorSchema['grandfathers_name'] = new sfValidatorRegex(array
('pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => false), array('invalid' => 'Grand Father name is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));     
    $this->setValidatorSchema['date_of_birth'] = new sfValidatorDate();
    $this->validatorSchema['sex'] = new sfValidatorChoice(array('choices' => array_keys(FormChoices::getGenderChoices()), 'required' => true ));
    $this->validatorSchema['admission_year'] = new sfValidatorChoice(array('choices' => array_keys(FormChoices::getAdmissionYearChoices()), 'required' => true ));
    $this->setValidatorSchema['email']         = new sfValidatorEmail();
    $this->validatorSchema['nationality'] = new sfValidatorRegex(array
('pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => false), array('invalid' => 'Nationlity is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));
    $this->validatorSchema['birth_location'] = new sfValidatorRegex(array
('pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => false), array('invalid' => 'Birth location is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));
    $this->validatorSchema['residence_city'] = new sfValidatorRegex(array
('pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => false), array('invalid' => 'Residence city is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));        
    $this->validatorSchema['residence_woreda'] = new sfValidatorRegex(array
('pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => false), array('invalid' => 'Woreda is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));    
    $this->validatorSchema['ethnicity'] = new sfValidatorRegex(array
('pattern'=>'/^[a-zA-Z\s]{2,}$/', 'required' => false), array('invalid' => 'Ethnicity is invalid, Enter Any character in the range a-z or A-Z, spaces and minimum two characters'
    ));    
	$this->validatorSchema['email'] = new sfValidatorEmail(
        array('required' => false));
    
   $this->validatorSchema['telephone'] = new sfValidatorRegex(array
('pattern'=>'/\+[0-9]{6,}/',
           'required' => false));         
    
    ##   PREVENT REPETITION IN REGISTRATION
    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Student', 'column' => array('first_name', 'middle_name', 'last_name', 'date_of_birth')), array('invalid' => 'This student is already registered ! ! '))
    );
    
    $this->widgetSchema->setLabels(array(
        'name'=>'Name *',
        'fathers_name'=>'Fathers Name *',
        'grandfathers_name'=>'Grandfathers Name *',
        'mother_name'=>'Mother Name *',
        'date_of_birth'=>'Date of Birth *',
        'admission_year'=>'Admission Year *',
        'nationality'=>'Nationality *',
        'sex'=>'Sex *'
    ));
    
    ##   Unset some values not needed in the process 
    unset($this['created_at'], $this['updated_at'], $this['photo'], $this['student_uid'] );  

    
    
    if(!is_null($this->sectionId))
    {
        $sectionDetail = Doctrine_Core::getTable('ProgramSection')->findOneById($this->sectionId);
        
        $studentCenter			= new StudentCenter(); 
        $studentCenter->setCenterId($sectionDetail->getCenterId());
        $studentCenter->Student	= $this->getObject();    
        $studentCenterForm 		= new FrontendStudentCenterForm($studentCenter);
        $this->embedForm('studentcenter', $studentCenterForm); 
        
        $enrollmentInfoObj              = new EnrollmentInfo();
        $enrollmentInfoObj->setProgramId($sectionDetail->getProgramId());
        $enrollmentInfoObj->setAcademicYear($sectionDetail->getAcademicYear());
        
        $enrollmentInfoObj->Student	= $this->getObject(); 
        $enrollmentForm			= new FrontendEnrollmentInfoForm($enrollmentInfoObj, $this->departmentId);  
        $this->embedForm('studentEnrollment', $enrollmentForm);        
    }
    else
    {
        ##   Embedd StudentCenterForm 
        $studentCenter				= new StudentCenter(); 
        
        $studentCenter->Student	= $this->getObject();    
        $studentCenterForm 			= new StudentCenterForm($studentCenter);
        $this->embedForm('studentcenter', $studentCenterForm);   

        ## Embed EnrollmentInfoForm, some are to be saved to EnrollmentInfo Table
        $enrollmentInfoObj 				= new EnrollmentInfo();
        $enrollmentInfoObj->Student	= $this->getObject(); 
        $enrollmentForm			= new EnrollmentInfoForm($enrollmentInfoObj, $this->departmentId);  
        $this->embedForm('studentEnrollment', $enrollmentForm); 
   
        ## Embed EnrollmentInfoForm, some are to be saved to EnrollmentInfo Table
        $enrollmentInfoObj 				= new EnrollmentInfo();
        $enrollmentInfoObj->Student	= $this->getObject(); 
        $enrollmentForm			= new EnrollmentInfoForm($enrollmentInfoObj, $this->departmentId);  
        $this->embedForm('studentEnrollment', $enrollmentForm);
    }
	 
         
  }
}
