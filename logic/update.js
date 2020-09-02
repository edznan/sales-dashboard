$(document).ready(function() {

    $("#submit-btn").click(function() {
        var newReportSalesNumber = 0;
        var reportFile = '';
        var summary = '';
        var success_msg = 'Updated successfully!';
        var error_msg = 'Try again please.';

        if($('#new-report-sales-number').val()) {
            newReportSalesNumber = $('#new-report-sales-number').val();
        } else {
            console.log('No value for sales number found!');
            $('.error_msg').css('display', 'block');
        }

        if($('#summary').val()) {
            summary = $('#summary').val();
        } else {
            console.log('No value for summary found!');
            $('.error_msg').css('display', 'block');
        }

        if($('#report-file').val()) {
            reportFile = $('#report-file').val();
            $('#report-file-submit').trigger('click');
        } else {
            console.log('No value for report file found!');
            $('.error_msg').css('display', 'block');
        }

        if(newReportSalesNumber.length > 0 && reportFile && summary.length > 0) {
            $.ajax({
                url: 'update.php',
                method: 'POST',
                data: {
                    new_report_sales_number: newReportSalesNumber,
                    summary: summary
                },
                success: function(response) {
                    if(response != 'success'){
                        $('#response').css({'background-color': '#ff0000', 'color': '#fff'});
                        $('#response').html(error_msg);
                    } else {
                        $('#response').css({'background-color': '#56baed', 'color': '#fff'});
                        $('#response').html(success_msg);
                        window.location = 'index.php';
                    }
                },
                dataType: 'text'
            })
        }
    });
});