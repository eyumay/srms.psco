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
Class Statuses 
{   
    static public function getStudentStatus($studentEnrollments = null, $year = null, $semester = null, $sectionId = null )            
    {   
        if(is_null($studentEnrollments) || is_null($year) || is_null($semester))
            return 'Cannot Determine Status1';
        
        if(is_null($sectionId))
        {
            foreach($studentEnrollments as $enrollment)
            {
                $sectionId = $enrollment->getSectionId();
            }
        }
             
                
        if(!Doctrine_Core::getTable('SectionCourseOffering')->checkIfGradeSubmittedBySectionId($sectionId))
            return 'Cannot determine status2';        

   
        if(!($year == 1 && $semester == 1))
        {
            if(is_null(Statuses::getPreviousSGPA($studentEnrollments, $year, $semester)) )
                    return 'Cannot Determine CGPA'; 
            else
                $pgpa = Statuses::getCGPA($studentEnrollments, $year, $semester); 
        }
        
        if(is_null(Statuses::getGPA($studentEnrollments, $year, $semester)) )
                return 'Cannot Determine GPA'; 
        else
            $sgpa = Statuses::getGPA($studentEnrollments, $year, $semester); 
        
        if(is_null(Statuses::getCGPA($studentEnrollments, $year, $semester) ) )
                return 'Cannot Determine CGPA'; 
        else
            $cgpa = Statuses::getCGPA($studentEnrollments, $year, $semester); 
                
        

        ##checkIfDropout - 
        /*if(Statuses::checkIfDropout($studentEnrollments, $year, $semester))
        {
            return 'DROPOUT';           
        }
        
        ##checkIfWithdraw
        if(Statuses::checkIfWithdraw($studentEnrollments, $year, $semester))
        {
            return 'WITHDRAWN'; 
        }
         * 
         */        
        if(Statuses::checkIfAcademicDismissal($studentEnrollments, $sgpa, $cgpa, $year, $semester))
        {
            if(Statuses::checkIfAcademicDismissalWithReadmission($studentEnrollments, $sgpa, $cgpa, $year, $semester))
            {
                return "ADR";
            }
            else
            {
                return "AD";
            }
        } 
        
        if(Statuses::checkIfWarning($studentEnrollments, $sgpa, $cgpa, $year, $semester))
        {
            return "WARNING";
        }
        
        if(Statuses::checkIfPass($studentEnrollments, $sgpa, $cgpa, $year, $semester))
        {
            return "PASS"; 
        }

    }
    
    ####################################################################
    
    public static function checkIfDropout($studentEnrollments, $sgpa, $cgpa, $year, $semester) 
    {
        
    }
    
    public static function checkIfWithdraw($studentEnrollments, $sgpa, $cgpa, $year, $semester)
    {
        
    }
    
    static public function checkIfAcademicDismissal( $studentEnrollments, $sgpa, $cgpa, $year, $semester )
    {
        if(Statuses::checkIfCurrentSemesterIsAD($studentEnrollments, $sgpa, $cgpa, $year, $semester))
            return TRUE;
        elseif(Statuses::checkLastTwoSemestersSGPAForAD($studentEnrollments, $sgpa, $cgpa, $year, $semester))
            return TRUE;
        else 
            return FALSE;
    }
    static public function checkIfCurrentSemesterIsAD( $studentEnrollments, $sgpa, $cgpa, $year, $semester )
    {
          $yOneSoneMax      = 1.25;
          $yOneStwoMax      = 1.75;
          $yearOneAbove     = 2.00;             
          
          if(is_null($cgpa) || is_null($sgpa))
              return null;
          
          if($year == 1 && $semester == 1)
          {
            if($sgpa < $yOneSoneMax )
                return TRUE;
            else
                return FALSE; 
          }

          elseif($year == 1 && $semester == 2)
          {
            if($sgpa < $yOneStwoMax )
                return TRUE;
            else
                return FALSE;
          }
          elseif($year == 2 && $semester == 1)
          {
            if($cgpa < $yearOneAbove )
                return TRUE;
            else
                return FALSE;
          }
          elseif($year == 2 && $semester == 2)
          {
            if($cgpa < $yearOneAbove )
                return TRUE;
            else
                return FALSE;
          }
          elseif($year == 3 && $semester == 1)
          {
            if($cgpa < $yearOneAbove )
                return TRUE;
            else
                return FALSE;
          }
          elseif($year == 3 && $semester == 2)
          {
            if($cgpa < $yearOneAbove )
                return TRUE;
            else
                return FALSE;
          }
          elseif($year == 4 && $semester == 1)
          {
            if($cgpa < $yearOneAbove )
                return TRUE;
            else
                return FALSE;
          }
          elseif($year == 4 && $semester == 2)
          {
            if($cgpa < $yearOneAbove )
                return TRUE;
            else
                return FALSE;
          }
          elseif($year == 5 && $semester == 1)
          {
            if($cgpa < $yearOneAbove )
                return TRUE;
            else
                return FALSE;
          }
          elseif($year == 5 && $semester == 2)
          {
            if($cgpa < $yearOneAbove )
                return TRUE;
            else
                return FALSE;
          }
          elseif($year == 6 && $semester == 1)
          {
            if($cgpa < $yearOneAbove )
                return TRUE;
            else
                return FALSE;
          }
          elseif($year == 6 && $semester == 2)
          {
            if($cgpa < $yearOneAbove )
                return TRUE;
            else
                return FALSE;
          }
          else
              return FALSE;
    }

    static public function checkLastTwoSemestersSGPAForAD($studentEnrollments, $sgpa, $cgpa, $year, $semester)
    {
        ## check if Last two semesters are okay, i.e, less than allowed point, current semester and previous semester,
        ## If student's previous_chr AND previous_grade_points are 0, student is having first time enrollment,
        
        $lastTwoSemestersMaxPoint = 1.00; 
        
        $pgpa = Statuses::getPreviousSGPA($studentEnrollments, $year, $semester);
        
        if(!($year == 1 && $semester == 1))
        {
            if(is_null($sgpa) || is_null($pgpa))
                return null;

            if($sgpa < $lastTwoSemestersMaxPoint && $pgpa < $lastTwoSemestersMaxPoint)
                return TRUE;
            else
                return FALSE;          
        }
        return FALSE; 
    }                   
    
    
    static public function checkIfAcademicDismissalWithReadmission($studentEnrollments, $sgpa, $cgpa, $year, $semester)
    {
        $yOneSoneMax    = 1.00;        
        $yOneStwoMax    = 1.50;
        $yTwoSoneMax    = 1.67;
        $yTwoStwoMax    = 1.75;
        $yThreeMax      = 1.80;      
        $yFourMax       = 1.85;         
        $yFiveMax       = 1.90;
        $ySixMax        = 1.92; 
    

        if(is_null($cgpa) || is_null($sgpa))
           return null;

        if($year == 1 && $semester == 1)
        {
          if($sgpa >= $yOneSoneMax )
              return TRUE;
          else
              return FALSE; 
        }
        
        if($year == 1 && $semester == 2)
        {
            if($cgpa >= $yOneStwoMax )
                return TRUE;
            else
                return FALSE;
        }
        
        if($year == 2 && $semester == 1)
        {
            if($cgpa >= $yTwoSoneMax )
                return TRUE;
            else
                return FALSE;
        }
        
        if($year == 2 && $semester == 2)
        {
            if($cgpa >= $yTwoStwoMax )
                return TRUE;
            else
                return FALSE;
        }
        
        if($year == 3 && $semester == 1)
        {
            if($cgpa >= $yThreeMax )
                return TRUE;
            else
                return FALSE;
        }
        
        if($year == 3 && $semester == 2)
        {
            if($cgpa >= $yThreeMax )
                return TRUE;
            else
                return FALSE;
        }
        
        if($year == 4 && $semester == 1)
        {
            if($cgpa >= $yFourMax )
                return TRUE;
            else
                return FALSE;
        }
        
        if($year == 4 && $semester == 2)
        {
            if($cgpa >= $yFourMax )
                return TRUE;
            else
                return FALSE;
        }
        
        if($year == 5 && $semester == 1)
        {
            if($cgpa >= $yFiveMax )
                return TRUE;
            else
                return FALSE;
        }
        
        if($year == 5 && $semester == 2)
        {
            if($cgpa >= $yFiveMax )
                return TRUE;
            else
                return FALSE;
        }
        
        if($year == 6 && $semester == 1)
        {
            if($cgpa >= $ySixMax )
                return TRUE;
            else
                return FALSE;
        }
        
        if($year == 6 && $semester == 2)
        {
            if($cgpa >= $ySixMax )
                return TRUE;
            else
                return FALSE;     
        }
    }
    ############################################################################# END OF ACADEMIC DISMISSAL AND READMISSION RULES
    
    
    
    ###################### START WARINIGN CONDITIONS
    static public function checkIfWarning($studentEnrollments, $sgpa, $cgpa, $year, $semester)
    {
        $yOneSoneMax    = 1.75;
        $yOneSoneMin    = 1.25;
        $yOneAbove      = 1.00;  
          
          
        if($year == 1 && $semester == 1)
        {
          if($sgpa >= $yOneSoneMin && $sgpa < $yOneSoneMax )
              return TRUE;
          else
              return FALSE; 
        }
        
        ## TODO
        # check if CGPA is pass, and SGPA falls below 1 for the first time.
        /*
        if($year >= 2 )
        {

        } 
         * 
         */       
    }
    ################################################ END WARNING RULE

    
    ###################### START PASSING CONDITIONS
    static public function checkIfPass($studentEnrollments, $sgpa, $cgpa, $year, $semester)
    {
        $yOneSoneMax        = 1.75;
        $yOneStwoAndAbove   = 2.00; 
          
          
        if(is_null($cgpa) || is_null($sgpa))
            return null;
          
        if($year == 1 && $semester == 1)
        {
          if($sgpa >= $yOneSoneMax )
              return TRUE;
          else
              return FALSE; 
        }
        
        if($year == 1 && $semester == 2)
        {
          if($cgpa >= $yOneStwoAndAbove )
              return TRUE;
          else
              return FALSE; 
        }      
        if($year >= 2)
        {
          if($cgpa >= $yOneStwoAndAbove )
              return TRUE;
          else
              return FALSE; 
        }           
        
    }    
    
    static public function getGPA($studentEnrollments = null, $year = null, $semester = null)
    {
        $sTotalChrs     = 0;
        $sTotalGpts     = 0;
        
        if(is_null($studentEnrollments))
            return null; 
        else
        {
            $sTotalChrs     = Statuses::getSemesterCreditHours($studentEnrollments, $year, $semester);
            $sTotalGpts     = Statuses::getSemesterGradePoints($studentEnrollments, $year, $semester); 
            if($sTotalChrs == 0 || $sTotalGpts == 0 || is_null($sTotalChrs) || is_null($sTotalGpts) )
                return null;
            else
                return round($sTotalGpts / $sTotalChrs, 2);            
        }
    }
    static public function getCGPA($studentEnrollments = null, $year = null, $semester = null)
    {
        $totalChrs      = 0.00;
        $totalGpts      = 0.00; 

        if(is_null($studentEnrollments))
            return null; 
        else
        {        

            $totalGpts += Statuses::getTotalGradePoints($studentEnrollments, $year, $semester);
            $totalChrs += Statuses::getTotalCreditHours($studentEnrollments, $year, $semester);
                        
            if($totalChrs == 0 || $totalGpts == 0 || is_null($totalChrs) || is_null($totalGpts))
                return null;
            else
                return round($totalGpts/$totalChrs, 2);
        }
    }

    static public function getPreviousSGPA($studentEnrollments = null, $year = null, $semester = null)
    {
        $totalChrs      = 0;
        $totalGpts      = 0; 

        if(is_null($studentEnrollments))
            return null; 
        else
        {        

            $totalGpts += Statuses::getPreviousGradePoints($studentEnrollments, $year, $semester); 
            $totalChrs += Statuses::getPreviousCreditHours($studentEnrollments, $year, $semester);

            if($totalChrs == 0 || $totalGpts == 0)
                return null;
            else
                return round($totalGpts/$totalChrs, 2);
        }
    }    
    
    static public function getTotalCreditHours($studentEnrollments = null, $year = null, $semester = null)
    {
        $totalChrs      = 0; 

        if(is_null($studentEnrollments))
            return null; 
        else
        {        
            foreach($studentEnrollments as $enrollment)
            {
                if($enrollment->getYear() == $year && $enrollment->getSemester() == $semester)
                    $totalChrs += $enrollment->getTotalCreditHours(); 
            }
            if($totalChrs == 0)
                return null;
            else
                return $totalChrs;
        }
    }    
    
    static public function getTotalGradePoints($studentEnrollments = null, $year = null, $semester = null)
    {
        $totalGpts      = 0; 

        if(is_null($studentEnrollments))
            return null; 
        else
        {        
            foreach($studentEnrollments as $enrollment)
            {
                if($enrollment->getYear() == $year && $enrollment->getSemester() == $semester)
                    $totalGpts += $enrollment->getTotalGPts(); 
            }
            if($totalGpts == 0)
                return null;
            else
                return $totalGpts;
        }
    }     

    static public function getSemesterCreditHours($studentEnrollments = null, $year = null, $semester = null)
    {
        $semesterChrs      = 0;

        if(is_null($studentEnrollments))
            return null; 
        else
        {        
            foreach($studentEnrollments as $enrollment)
            {
                if(!$enrollment->getLeftout() && $enrollment->getYear() == $year && $enrollment->getSemester() == $semester)
                    $semesterChrs += $enrollment->getSemesterTotalChrs();
            }
            if($semesterChrs == 0)
                return null;
            else
                return $semesterChrs;
        }
    }    
    static public function getSemesterGradePoints($studentEnrollments = null, $year = null, $semester = null)
    {
        $semesterGpts      = 0;

        if(is_null($studentEnrollments))
            return null; 
        else
        {        
            foreach($studentEnrollments as $enrollment)
            {
                if(!$enrollment->getLeftout() && $enrollment->getYear() == $year && $enrollment->getSemester() == $semester)
                    $semesterGpts += $enrollment->getSemesterTotalGradePoints();
            }
            if($semesterGpts == 0)
                return null;
            else
                return $semesterGpts;
        }
    }    

    static public function getPreviousCreditHours($studentEnrollments = null, $year = null, $semester = null)
    {
        $previousChrs      = 0;

        if(is_null($studentEnrollments))
            return null; 
        else
        {        
            foreach($studentEnrollments as $enrollment)
            {
                if(!$enrollment->getLeftout() && $enrollment->getYear() == $year && $enrollment->getSemester() == $semester)
                    $previousChrs += $enrollment->getPreviousChrs();
            }
            if($previousChrs == 0)
                return null;
            else
                return $previousChrs;
        }
    }  
    static public function getPreviousGradePoints($studentEnrollments = null, $year = null, $semester = null)
    {
        $previousGpts      = 0;

        if(is_null($studentEnrollments))
            return null; 
        else
        {        
            foreach($studentEnrollments as $enrollment)
            {
                if(!$enrollment->getLeftout() && $enrollment->getYear() == $year && $enrollment->getSemester() == $semester)
                    $previousGpts += $enrollment->getPreviousTotalGradePoints();
            }
            if($previousGpts == 0)
                return null;
            else
                return $previousGpts;
        }
    }       
    
}

