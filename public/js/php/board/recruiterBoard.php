<script language="javascript" type="text/javascript">

var url = <?php echo json_encode(URL); ?>;

var pdfViewUpdate = function(resumeURL) {
    // change pdf path for pdfViewModal
}

var updateProgressStatus = function(studentId, jobId, option) {
    // update changed statusId
    var post_url = url + 'board/ajax_updateProgressStatus/' + jobId + "/" + studentId + "/" + option.value;
            
    $.ajax({
        url: post_url,
        type: 'post',
        data: 'json',
        success: function(msg) {
            if (msg) {
                alert(msg);
            }
        }
    });
}

var updateJob = function(jobId, jobTitle) {
    // change title of modal
    $("#myModalJobTitleLabel").html(jobTitle);
 
    // get list of applied students
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
                // add user information
                content += '<td>' + element.firstname + ' ' + element.lastname + '</td>\n';
                content += '<td>' + element.email + '</td>\n';
                if(element.personalLink) content += '<td><a href="' + element.personalLink + '" target="_blank">Personal Link</td>\n';
                content += '<td>' + element.phoneNumber + '</td>\n';
                content += '<td>' + element.school + '</td>\n';
                // create drop-down menu
                content += '<td><select class="apply_status" id="' + element.userId + '" onchange="updateProgressStatus(\'' + element.userId + '\',\'' + jobId + '\', this)">' + element.status;
                if (element.status == 1) content +=      '<option value="1" selected="selected">New</option><option value="2">In Progress</option><option value="3">Done</option>';
                else if (element.status == 2) content += '<option value="1">New</option><option value="2" selected="selected">In Progress</option><option value="3">Done</option>';
                else if (element.status == 3) content += '<option value="1">New</option><option value="2">In Progress</option><option value="3" selected="selected">Done</option>';                
                content += '</select></td>\n';
                // create resume button
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