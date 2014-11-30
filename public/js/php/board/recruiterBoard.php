<script language="javascript" type="text/javascript">

var pdfViewUpdate = function(resumeURL) {
    // change pdf path for pdfViewModal
}

var updateJob = function(jobId, jobTitle) {
    $("#myModalJobTitleLabel").html(jobTitle);
    
    var url = <?php echo json_encode(URL); ?>;
    var post_url = url + 'board/ajax_getJobById/' + jobId;
            
    $.ajax({
        url: post_url,
        type: 'post',
        data: 'json',
        success: function(jsonData) {
            var data = JSON.parse(jsonData);
            var content='<table id="student-container"><tbody id="student-body">\n';
            data.forEach(function(element, index, array) {
                content += '<tr>\n';
                content += '<td>' + element.firstname + ' ' + element.lastname + '</td>\n';
                content += '<td>' + element.email + '</td>\n';
                if(element.personalLink) content += '<td><a href="' + element.personalLink + '" target="_blank">Personal Link</td>\n';
                content += '<td>' + element.phoneNumber + '</td>\n';
                content += '<td>' + element.school + '</td>\n';
                if(element.resume) content += '<td><a class="student-name" data-toggle="modal" data-target="#pdfViewModal" onclick="pdfViewUpdate(\'' + element.resume + '\')">Resume</a></td>\n';
                content += '</tr>\n';
            });
            content += '</tbody></table>';
            $("#jobModalBody").html(content);
        }
    });
};

document.getElementById("addJobPost").onclick = function(){
    var addJobPost_request;
    if (addJobPost_request){
        addJobPost_request.abort();
    }

    var $input = $('jobpost').find("input, select, button, textarea, div");
    var serializedData = $(this).serialize();
    $input.prop("disabled", true);
    
    /*
    request = $.ajax({
        url: <?php echo json_encode(URL . 'setting/addCompany/'); ?>,
        type: 'post',
        data: serializedData,
        success: function(result) {
            var data = JSON.parse(result);
            if (!data.error_msg) {
                $("#company_list").append('<option value=' + data.id + '>' + data.company + '</option>');
            }
            else alert(data.error_msg);
        }
    });

    request.always(function() {
        $input.prop("disabled", false);
        $('#company_name').val('');
        $('#company_description').val('');
        $('#company_url').val('');
        $('#addCompanyBox').hide();
    });

    event.preventDefault();
    */
};



</script>