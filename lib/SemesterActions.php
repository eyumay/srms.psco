<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StudentStatus
 *
 * @author eyumay
 */
Class SemesterActions 
{   
    static public function getSemesterAction($studentEnrollment )            
    {
        if( is_null($studentEnrollment->getSectionId()) )
            return 'Admitted';
        elseif($studentEnrollment->getSemesterAction() == sfConfig::get('app_enrolled_semester_action'))
            return 'Enrolled';
        elseif($studentEnrollment->getSemesterAction() == sfConfig::get('app_registered_semester_action'))
            return 'Registered';        
        elseif($studentEnrollment->getSemesterAction() == sfConfig::get('app_promoted_semester_action'))
            return 'Promoted';         
        elseif($studentEnrollment->getSemesterAction() == sfConfig::get('app_withdrawn_semester_action'))
            return 'Withdrawn';         
        elseif($studentEnrollment->getSemesterAction() == sfConfig::get('app_under_semester_action'))
            return 'Under';        
        elseif($studentEnrollment->getSemesterAction() == sfConfig::get('app_dismissed_semester_action'))
            return 'Dismissed';    
        elseif($studentEnrollment->getSemesterAction() == sfConfig::get('app_dropout_semester_action'))
            return 'Dropout';                      
        elseif($studentEnrollment->getSemesterAction() == sfConfig::get('app_transferred_semester_action'))
            return 'Transferred'; 
        elseif($studentEnrollment->getSemesterAction() == sfConfig::get('app_graduated_semester_action'))
            return 'Graduated';  
        else
            return 'Unable to determine';
    }   
    
    static public function isEnrolled($studentEnrollment)
    {
        if($studentEnrollment->getSemesterAction() == sfConfig::get('app_enrolled_semester_action'))
            return TRUE;
        else
            return FALSE; 
    }             
    
    static public function isRegistered($studentEnrollment)
    {
        if($studentEnrollment->getSemesterAction() == sfConfig::get('app_registered_semester_action'))
            return TRUE;
        else
            return FALSE; 
    }
    
    static public function isPromoted($studentEnrollment)
    {
        if($studentEnrollment->getSemesterAction() == sfConfig::get('app_promoted_semester_action'))
            return TRUE;
        else
            return FALSE; 
    }      
    
    static public function isWithdrawn($studentEnrollment)
    {
        if($studentEnrollment->getSemesterAction() == sfConfig::get('app_withdrawn_semester_action'))
            return TRUE;
        else
            return FALSE; 
    }    
    
    static public function isUnder($studentEnrollment)
    {
        if($studentEnrollment->getSemesterAction() == sfConfig::get('app_under_semester_action'))
            return TRUE;
        else
            return FALSE; 
    }     
    
    static public function isDismissed($studentEnrollment)
    {
        if($studentEnrollment->getSemesterAction() == sfConfig::get('app_dismissed_semester_action'))
            return TRUE;
        else
            return FALSE; 
    } 
    
    static public function isDropout($studentEnrollment)
    {
        if($studentEnrollment->getSemesterAction() == sfConfig::get('app_dropout_semester_action'))
            return TRUE;
        else
            return FALSE; 
    }     
    
    static public function isGraduated($studentEnrollment)
    {
        if($studentEnrollment->getSemesterAction() == sfConfig::get('app_graduated_semester_action'))
            return TRUE;
        else
            return FALSE; 
    }    
    
    static public function checkToDeleteCourseOffering($studentEnrollment)
    {
        if($studentEnrollment->getSemesterAction() == sfConfig::get('app_registered_semester_action'))
            return FALSE;        
        elseif($studentEnrollment->getSemesterAction() == sfConfig::get('app_promoted_semester_action'))
            return FALSE;          
        else
            return TRUE; 
    }
    
    static public function checkModifyStudentProfile($studentObj = null)
    {
        if(!is_null($studentObj))
        {
            $canBeModified = TRUE;
            foreach($studentObj->getEnrollmentInfos() as $enrollment)
            {
                if(SemesterActions::isRegistered($enrollment) || 
                        SemesterActions::isPromoted($enrollment) || 
                        SemesterActions::isWithdrawn($enrollment) || 
                        SemesterActions::isUnder($enrollment) ||
                        SemesterActions::isDismissed($enrollment) ||
                        SemesterActions::isDropout($enrollment) ||
                        SemesterActions::isGraduated($enrollment)
                        )
                    $canBeModified = FALSE; 
            }
            
            return $canBeModified; 
        }
        else
            return FALSE; 
        
        
    }
    
    static public function enrolled()
    {
        return sfConfig::get('app_enrolled_semester_action'); 
    }
    static public function registered()
    {
        return sfConfig::get('app_registered_semester_action'); 
    }    
    static public function promoted()
    {
        return sfConfig::get('app_promoted_semester_action'); 
    }    
    static public function withdrawn()
    {
        return sfConfig::get('app_withdrawn_semester_action'); 
    }    
    static public function under()
    {
        return sfConfig::get('app_under_semester_action'); 
    }    
    static public function dismissed()
    {
        return sfConfig::get('app_dismissed_semester_action'); 
    }        
    static public function dropout()
    {
        return sfConfig::get('app_dropout_semester_action');
    }
    static public function transferred()
    {
        return sfConfig::get('app_transferred_semester_action');
    } 
}

