<?php

/**
 * session actions.
 *
 * @package    srms
 * @subpackage session
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sessionActions extends sfActions
{
 /** 
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->redirect('session/login');
  }

	/* 
    $login= $this->getRequestParameter('login');
    $password= new Password($this->getRequestParameter('password'));
  
    $c->add(UserPeer::CRYPT_PASSWORD, $password->getCryptHash());
	*/

	public function executeDologin(sfWebRequest $request)
	{
		$form = new LoginForm();
		$form->bind($this->getRequestParameter('credentials'));

		if($form->isValid()){ 
			$credentials = $request->getParameter('credentials');
			$login = $credentials['login'];
			$user = UserTable::getUserFromLogin($login);
               ## Store array of allowed sectionIds that can be accessed!
               $sectionIdsArray = Doctrine_Core::getTable('Program')
                       ->getProgramsByDepartmentId($user->getDepartmentId());			

			// set the session correctly 
	       $this->getUser()->setAuthenticated(true);
               
	       $this->getUser()->setAttribute('userId' , $user->getId());
	       $this->getUser()->setAttribute('departmentId' , $user->getDepartmentId());
	       $this->getUser()->setAttribute('departmentName' , $user->getDepartment());    
               $this->getUser()->setAttribute('sectionIds' , array_keys($sectionIdsArray) );
               $this->getUser()->setAttribute('credential' , $user->getPrivilege());

           ##Do Logging!!
                $newLog = new AuditLog();
                $action = 'User has logged into Student Record Management System';
                $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);               
               
		    $this->getUser()->setFlash('notice', 'Welcome'. ' ' . $user->getFirstName() );
		    //$this->redirect('filter/show?id='.$user->getId());
		    $this->redirect('programsection/index'); 
		} else {
			// give the form again 
			$this->form = $form;
			$this->setTemplate('login');
		}
	}

  public function executeLogin(sfWebRequest $request) 
  {
	$this->getUser()->setAuthenticated(false);
	$this->form = new LoginForm();	
  }

  public function executeLogout(sfWebRequest $request) 
  {
      
                $newLog = new AuditLog();
                $action = 'User has logged out from  Student Record Management System';
                $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);    
      
    $this->getUser()->setAuthenticated(false);
    $this->getUser()->getAttributeHolder()->remove('userId');
    $this->getUser()->getAttributeHolder()->remove('departmentId');
    $this->getUser()->getAttributeHolder()->remove('departmentName');
    $this->getUser()->getAttributeHolder()->remove('sectionIds');
    
	$this->getUser()->setFlash('notice', 'You have been logged out!');
	$this->redirect('student/index');
  } 
  public function executeComment(sfWebRequest $request){
     $this->redirect('@comment');
  } 
}
