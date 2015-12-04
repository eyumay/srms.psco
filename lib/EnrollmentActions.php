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
Class EnrollmentActions 
{   
    static public function getEnrollmentAction($studentEnrollment )            
    {
        if($studentEnrollment->getEnrollmentAction() == sfConfig::get('app_admission_enrollment'))
            return 'Admission';
        elseif($studentEnrollment->getEnrollmentAction() == sfConfig::get('app_promotion_enrollment'))
            return 'Promotion';
        elseif($studentEnrollment->getEnrollmentAction() == sfConfig::get('app_readmission_enrollment'))
            return 'Readmission';        
        elseif($studentEnrollment->getEnrollmentAction() == sfConfig::get('app_transfer_enrollment'))
            return 'Transfer';        
        elseif($studentEnrollment->getEnrollmentAction() == sfConfig::get('app_clearance_enrollment'))
            return 'Clearance';        
        elseif($studentEnrollment->getEnrollmentAction() == sfConfig::get('app_add_enrollment'))
            return 'Add';        
        else
            return 'Unable to determine';
    } 
    
    static public function isAdmission($studentEnrollment)
    {
        if($studentEnrollment->getEnrollmentAction() == sfConfig::get('app_admission_enrollment'))
            return TRUE;
        else 
            return FALSE; 
    }
    
    static public function isTransfer($studentEnrollment)
    {
        if($studentEnrollment->getEnrollmentAction() == sfConfig::get('app_transfer_enrollment'))
            return TRUE;
        else 
            return FALSE; 
    }
    
    static public function admission()
    {
        return sfConfig::get('app_admission_enrollment');
    }    
    static public function promotion()
    {
        return sfConfig::get('app_promotion_enrollment');
    } 
    static public function readmission()
    {
        return sfConfig::get('app_readmission_enrollment');
    } 
    static public function transfer()
    {
        return sfConfig::get('app_transfer_enrollment');
    } 
    static public function clearance()
    {
        return sfConfig::get('app_clearance_enrollment');
    } 
    static public function add()
    {
        return sfConfig::get('app_add_enrollment');
    }     
}

