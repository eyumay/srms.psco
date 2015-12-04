<?php 
Class FormChoices
{
  static protected $sex = array(
      0  => 'Female',
      1  => 'Male',
  );
  static protected $courseTypes = array(
      'major'       => 'Major',
      'supportive'  => 'Supportive',
      'common'      => 'Common'
  );
  
  static protected $exemptionGradeTypes = array(
      'A+'  => 'A+',
      'A'   => 'A',
      'A-'  => 'A-',
      'B+'  => 'B+',
      'B-'  => 'B'
  );  

  static protected $regradeTypes = array(
      'gradecomplain'   => 'Grade Complain',
      'reexam'          => 'Reexamination',
      'makeup'          => 'Makeup Examination'
  );
  
  static public function getExemptionGradeTypes()
  {
    return self::$exemptionGradeTypes;
  }   
  
  static public function getCourseTypeChoices()
  {
    return self::$courseTypes;
  }  
  static public function getGenderChoices()
  {
    return self::$sex;
  } 

  static public function getRegradeTypeChoices()
  {
    return self::$regradeTypes;
  }
  static public function getYearsForDateOfBirth()
  {
    $years = range(date('Y')-60, date('Y'));
    $yearsList = array_combine($years, $years); ## This combines together array_key/value pair   	
    return $yearsList; 
  }
 
  static public function getAdmissionYearChoices()
  {
    $admission_years[''] = "Select Admission Year";
    $start = date('Y')-20;
    $end = date('Y');     
    for($i=$start; $i <= $end; $i++)
       $admission_years[$i] = $i; 
    return $admission_years; 
  }  
  static public function getAcademicYear()
  {
    $curent = date('Y') - 10;
    $length=strlen($curent);
    $characters = 2;
    $start = $length - $characters;     
    $time = substr($curent , $start ,$characters);
    $acadamicYear=array();
    for ($i = $curent-1; $i < 2093; $i++) {  
      $academicYearIndex = $i.'/'.$time;   
      $acadamicYear[$academicYearIndex]=$i.'/'.$time;    
      $time++; 
      if($time <10)
          $time = '0'.$time; 
    }
    return $acadamicYear ;
  }  
  
  static public function getYearChoices()
  {
    $yearChoices = array(1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5');
    return $yearChoices;
  } 
  static public function getSemesterChoices()
  {
    $semesterChoices = array(1=>'1', 2=>'2', 3=>'3');
    return $semesterChoices;
  }  
  static public function getSectionChoices()
  {
    $sectionChoices = array(1=>'1');
    return $sectionChoices;
  }   
  
  static public function getCreditHourChoices()
  {
    $creditHourChoices = array(1=>'1', 2=>'2', 3=>'3', 4=>'4');
    return $creditHourChoices;
  }
  
  public static function getGradeChoicesAsArray($gradeObject = NULL )
  {
      $gradeChoices     = array();
      $gradeChoices['']  = " --- Select grade --- " ;
      foreach($gradeObject as $gradeObj )
          $gradeChoices[$gradeObj->getId()] = $gradeObj->getGradeChar();

      return $gradeChoices;
  }
     
}
