/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    var $search = $('#stud').addClass('overlabel');
    var $searchInput = $search.find('#newstid');
    var $searchLabel = $search.find('#label1');
    if ($searchInput.val()) {
        $searchLabel.hide();
    }
    $searchInput
            .focus(function() {
        $searchLabel.hide();
    })
            .blur(function() {
        if (this.value == '') {
            $searchLabel.show();
        }
    });
    $searchLabel.click(function() {
        $searchInput.trigger('focus');
    });
});



$(document).ready(function() {
    var $search = $('#searchbyname').addClass('overlabel');
    var $searchInput = $search.find('#search-text2');
    var $searchLabel = $search.find('#label2');
    if ($searchInput.val()) {
        $searchLabel.hide();
    }
    $searchInput
            .focus(function() {
        $searchLabel.hide();
    })
            .blur(function() {
        if (this.value == '') {
            $searchLabel.show();
        }
    });
    $searchLabel.click(function() {
        $searchInput.trigger('focus');
    });
});
$(document).ready(function() {
    var $search = $('#searchbycollege').addClass('overlabel');
    var $searchInput = $search.find('#instructor_filters_college_id');
    var $searchLabel = $search.find('#label3');
    if ($searchInput.val()) {
        $searchLabel.hide();
    }
    $searchInput
            .focus(function() {
        $searchLabel.hide();
    })
            .blur(function() {
        if (this.value == '') {
            $searchLabel.show();
        }
    });
    $searchLabel.click(function() {
        $searchInput.trigger('focus');
    });
});
////////////////////////////////////////////////////////
$(document).ready(function() {
    var $search = $('#searchbydepartment').addClass('overlabel');
    var $searchInput = $search.find('#instructor_filters_department_id');
    var $searchLabel = $search.find('#label4');
    if ($searchInput.val()) {
        $searchLabel.hide();
    }
    $searchInput
            .focus(function() {
        $searchLabel.hide();
    })
            .blur(function() {
        if (this.value == '') {
            $searchLabel.show();
        }
    });
    $searchLabel.click(function() {
        $searchInput.trigger('focus');
    });
});

