<html>

    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />

        <?php use_stylesheet('bootstrap.css') ?>
        <?php use_javascript('bootstrap.js') ?>


        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>


        <script language="javascript" type="text/javascript">
            <!--
            function mypopup()
            {
                idnumber=document.getElementById("student_student_id").value;
                //alert(idnumber);
                var link = 'http://localhost/camera/test.php?id=' + idnumber; 
                // alert(link);
                mywindow = window.open(link, "Take Picture", location=1,status=1,scrollbars=1,  width=600,height=500);
                mywindow.moveTo(0, 0);
            }

            // -->
        </script>

    </head>
    <body bgcolor="#ffffff">

    
       <div class="cont">

            <div class="nav nav-tabs " style="background-color: 000099" >
				 <!--                
                <img src="/images/srslogo.jpg" width="100%" height="100%" alt="srs logo"/>
                <p style="text-align: center">
                <font style="font-family: serif; font-size:x-large ; color: #f1f1f1; text-align: center">    </font>               
                </p>
                --> 
                <h1 style="color: white;" align="center"> Student Record Management System </h1> 
            </div>

     
	  <?php if($sf_user->isAuthenticated()): ?>

		  

	  <!-- #end mainLinks --> 

            <div class="leftlink">
                <!--                <div id="accordion">-->
                <button style="width: 100%" type="button" class="btn  btn-primary" data-toggle="collapse" data-target="#student-actions">
                    Students
                </button>
                <div id="student-actions" class="collapse">
                    <ul class="nav nav-tabs nav-stacked">                        
                        <li><a href="<?php echo url_for('student/chooseProgramSection') ?>">  Admission </a></li>
                        <li><a href="<?php echo url_for('student/index') ?>">  Manage Student Record  </a></li>
                        <li><a href="<?php echo url_for('dropadd/index') ?>">Add And Drop</a></li>
                        <li><a href="<?php echo url_for('exemption/index') ?>">Exemption of Students</a></li>
                        <li><a href="<?php echo url_for('regrade/index') ?>">Regrade </a></li>
                        <li><a href="<?php echo url_for('withdraw/index') ?>"> Withdraw </a></li>
                        <li><a href="<?php echo url_for('readmission/index') ?>"> Re admission </a></li>
                        <!--
                        <li><a href="#">Promotion</a></li>
                        <li><a href="<?php echo url_for('student/showregistrationfilterform') ?>">  Registration</a></li>
                        <li><a href="#"> Withdraw or Dropout</a></li>
                        
                        <li><a href="#"> Under</a></li>
                        -->
                        <li><a href="<?php echo url_for('transfer/index') ?>"> Transfer </a></li>
                        <li><a href="<?php echo url_for('centerchange/index') ?>"> Center Change </a></li>
                    </ul>
                </div>
                <button style="width: 100%" type="button" class="btn  btn-primary" data-toggle="collapse" data-target="#registration-actions">
                    Registration
                </button>
                <div id="registration-actions" class="collapse"> 
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="<?php echo url_for('registration/index') ?>"> Register Per Class </a></li>
                    </ul>
                </div>                
                <button style="width: 100%" type="button" class="btn  btn-primary" data-toggle="collapse" data-target="#student-program-section">
                    Sections / Classes
                </button>
                <div id="student-program-section" class="collapse">
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="<?php echo url_for('programsection/index') ?>"> View Available Sections </a></li>
                        <li><a href="<?php echo url_for('programsection/new') ?>"> Create Section </a></li>
                        <li><a href="<?php echo url_for('programsection/filterToEnrollToSection') ?>"> Enroll Students to Section</a></li>
                        <li><a href="<?php echo url_for('sectioncourseoffering/index') ?>"> Course Offering </a></li>                        
                    </ul>
                </div>

                <button style="width: 100%" type="button" class="btn  btn-primary" data-toggle="collapse" data-target="#grade-actions">
                    Grade 
                </button>
                <div id="grade-actions" class="collapse">
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="#">Enter Grade Per Student</a></li>
                        <li><a href="<?php echo url_for('submitgrade/index') ?>">Enter Grade Per Sectoin</a></li>                                                
                    </ul>
                </div>


                <button style="width: 100%" type="button" class="btn  btn-primary" data-toggle="collapse" data-target="#course-actions">
                    Courses
                </button>
                <div id="course-actions" class="collapse">
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="<?php echo url_for('sectioncourseoffering/index') ?>"> Course Offering for Section </a></li>
                        
                    </ul>
                </div>

                
                <?php if($sf_user->getAttribute('credential') == 'hod'): ?> 
                <button style="width: 100%" type="button" class="btn  btn-primary" data-toggle="collapse" data-target="#admin-actions">
                    Administration 
                </button>
                <div id="admin-actions" class="collapse ">
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="<?php echo url_for('course/index') ?>">Manage Course  </a></li>
                        <li><a href="<?php echo url_for('program/index') ?>"> Manage Program </a></li>
                        <li><a href="<?php echo url_for('curriculum/index') ?>"> Manage Curriculum </a></li>
                        <li><a href="<?php echo url_for('managesection/index') ?>"> Manage Program Section  </a></li>

                    </ul>
                </div>
                <?php endif; ?>
                <button style="width: 100%" type="button" class="btn  btn-primary" data-toggle="collapse" data-target="#logout-actions">
                    Logout
                </button>
                <div id="logout-actions" class="collapse">
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="<?php echo url_for('session/logout') ?>"> Logout </a></li>
                    </ul>
                </div>                

            </div>

          <?php endif; ?>  






            <!--        <button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#demo">
                        simple collapsible
                    </button>
            
                    <div id="demo" class="collapse in">Copyright © 2013, All Rights Reserved   </div>-->




            <div class="mbody">
						 <div style="font-size: 11px"><?php if ($sf_user->hasFlash('notice')): ?>
						<div class="flash_notice">
						<?php  
									  echo $sf_user->getFlash('notice');
									  $sf_user->setFlash('notice', '');
						?>
						</div>
						<?php endif; ?>
						
						<?php if ($sf_user->hasFlash('error')): ?>
						<div class="flash_error">
						<?php echo $sf_user->getFlash('error');
			                    $sf_user->setFlash('error', '');
				       ?>
						</div>
						<?php endif; ?>
						</div>          
						  
                <?php echo $sf_content ?>
            </div>
        </div>
<!--        <div class="navbar" style="background-color: #9398c9">

            <h6 style="text-align: center"> Copyright © 2013, All Rights Reserved    </h6>


        </div>-->

    </body>
</html>
