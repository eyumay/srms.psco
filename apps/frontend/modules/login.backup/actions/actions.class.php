<?php

/**
 * login actions.
 *
 * @package    srms
 * @subpackage login
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
    $this->redirect('index/login');
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

			// set the session correctly 
	      $this->getUser()->setAuthenticated(true);
	      //$this->getUser()->setAttribute('user_id' , $user->getId());
	      $this->getUser()->setAttribute('department_id' , $user->getDepartmentId());
	      //$this->getUser()->setAttribute('department_name' , $user->getDepartment());
		   $this->getUser()->setFlash('notice', 'Welcome'. ' ' . $user->getLogin());
		   $this->redirect('user/show?id='.$user->getId().'&depid='.$user->getDepartmentId());
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
    $this->getUser()->setAuthenticated(false);
	$this->getUser()->setFlash('notice', 'You have been logged out!');
	$this->redirect('@user');
  } 

 }