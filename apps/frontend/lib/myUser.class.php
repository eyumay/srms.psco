<?php

class myUser extends sfBasicSecurityUser
{
  static public function getCourseIds()
  { 
    return $this->getAttribute('courseIds');  
  }
  static public function getStudentIds()
  {
    return $this->getAttribute('studentIds');  
  }  
}
