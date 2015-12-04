<?php

/**
 * Grade form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     Eyuel G.
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FrontendGradeSubmissionForm extends BaseForm
{
  private $gradeChoices             = NULL;
  private $courseId                 = NULL;
  private $studentIdNamePairArray   = NULL; 

  public function __construct($studentIdNamePairArray = NULL, $courseId = NULL, $gradeChoices = NULL )
  {
    $this->gradeChoices             = $gradeChoices;
    $this->studentIdNamePairArray   = $studentIdNamePairArray; 
    $this->courseId                 = $courseId;
    
    
    parent::__construct();
  }
   
  public function configure() 
  {
    ## SET WIDGETS$this->setWidgets(array(
    $sNum   = 1;
    foreach ($this->studentIdNamePairArray as $id=>$studentFullName)
    {
        ## checkIfEnrollment is clearance enrollment
        if(Doctrine_Core::getTable('EnrollmentInfo')->findOneById($id)->checkIfClearanceEnrollment() )
        {
            $this->setWidget( 
                'grade_id_'.$id,  new sfWidgetFormChoice(array(
                                   'choices' => Doctrine_Core::getTable('Grade')->getClearanceGradeChoice(),
                                   'label'   => $sNum.'. '.$studentFullName
                    )) 				
            );
        }
        else
        {
            $this->setWidget( 
                'grade_id_'.$id,  new sfWidgetFormChoice(array(
                                   'choices' => $this->gradeChoices,
                                   'label'   => $sNum.'. '.$studentFullName
                    )) 				
            );            
        }
            
        $sNum++; 
    }

    $this->setWidget( 
        'course_id', new sfWidgetFormInputHidden(array(), array('value'=> $this->courseId) 	
    ));    

    ## SET VALIDATORS
    foreach ($this->studentIdNamePairArray as $id=>$studentFullName)
    {
            $this->setValidator('grade_id_'.$id, new sfValidatorNumber());
    }
    $this->setValidator('course_id', new sfValidatorNumber());
    $this->widgetSchema->setNameFormat('gradeform[%s]');
  }
}

