<html>
    
  <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
        <?php include_http_metas() ?>
  
       <?php use_stylesheet('back.css') ?>

        <script>

            $(function() {
                $("#accordion").accordion({
                    event: "click hoverintent"
                });
            });

            var cfg = ($.hoverintent = {
                sensitivity: 7,
                interval: 100
            });

            $.event.special.hoverintent = {
                setup: function() {
                    $(this).bind("mouseover", jQuery.event.special.hoverintent.handler);
                },
                teardown: function() {
                    $(this).unbind("mouseover", jQuery.event.special.hoverintent.handler);
                },
                handler: function(event) {
                    var that = this,
                            args = arguments,
                            target = $(event.target),
                            cX, cY, pX, pY;

                    function track(event) {
                        cX = event.pageX;
                        cY = event.pageY;
                    }
                    ;
                    pX = event.pageX;
                    pY = event.pageY;
                    function clear() {
                        target
                                .unbind("mousemove", track)
                                .unbind("mouseout", arguments.callee);
                        clearTimeout(timeout);
                    }
                    function handler() {
                        if ((Math.abs(pX - cX) + Math.abs(pY - cY)) < cfg.sensitivity) {
                            clear();
                            event.type = "hoverintent";
                            // prevent accessing the original event since the new event
                            // is fired asynchronously and the old event is no longer
                            // usable (#6028)
                            event.originalEvent = {};
                            jQuery.event.handle.apply(that, args);
                        } else {
                            pX = cX;
                            pY = cY;
                            timeout = setTimeout(handler, cfg.interval);
                        }
                    }
                    var timeout = setTimeout(handler, cfg.interval);
                    target.mousemove(track).mouseout(clear);
                    return true;
                }
            };
            //tabs -----------------------------------------------
            $(function() {
                $("#tabs").tabs();
            });
            var $tabs = $("#tabs").tabs(); // first tab selected

            $('#my-text-link').click(function() { // bind click event to link
                $tabs.tabs('select', 2); // switch to third tab
                return false;
            });
        </script>
    </head>
    <body bgcolor="#ffffff">
        <div class="cont">



            <div class="menu">

                <p class="plink" align="center"> Student Registration System </p>

              </div>    
             <div class="leftlink">

                    <div id="accordion">
                      


                     
                    
                       <h3>Administration</h3>
                        <div>
                            <ul>
       
                                <li><?php echo link_to('Manage Faculty', 'faculty') ?></li>
                                <li><?php echo link_to('Manage Department', 'department') ?></li>
                                <li><?php echo link_to('Manage Program Type', 'program_type') ?></li>
                                <li><?php echo link_to('Manage Enrollment Type', 'enrollment_type') ?></li>
                                <li><?php echo link_to('Manage Program', 'program') ?></li>
                                <li><?php echo link_to('Manage Program Section', 'program_section') ?></li>
                                <li><?php echo link_to('Manage Grade Type', 'grade_type') ?></li>
                                <li><?php echo link_to('Manage Grade', 'grade') ?></li>
                                <li><?php echo link_to('Manage Course', 'course') ?></li>
                                <li><?php echo link_to('Manage Actions', 'student_semester_action') ?></li>
                                <li><?php echo link_to('Manage Statuses', 'student_academic_status') ?></li>
                                <li><?php echo link_to('Manage Events', 'calendar_events') ?></li>
                                <li><?php echo link_to('Manage Calendar', 'academic_calendar') ?></li>
                                <li><?php echo link_to('Manage Calendar Events', 'academic_calendar_events') ?></li>
                                
                            </ul>
                        </div>
                    </div>

                </div>


                </div>               

                    
               <div class="mbody">
                    <?php echo $sf_content ?>
                </div>
            </div>

            <div class="footer">
                <p align="center"> Copyright © 2013, Public Service College of Oromia All Rights Reserved    </p>

            </div>

    </body>
</html>
