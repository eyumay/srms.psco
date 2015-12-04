function addNewField() {
    return $.ajax({
        type: 'GET',
        url: '/frontend_dev.php/studentsection/showResult?num=' + $('#maxnum').val() + '&' 
             + 'program=' + $('#student_section_program').val()+ '&'+ 'year=' + $('#student_section_student_year').val()+ '&'
             + 'semester=' + $('#student_section_student_year').val()+'&'+'naming='+ $('#naming').val(),
        async: false
    }).responseText;
}



$(document).ready(function() {
    $('#result').click(function(e) {
        e.preventDefault();
        $('#check').remove();
        $('table#showresults').append(addNewField());
        

    });
});



