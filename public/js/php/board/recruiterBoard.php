<script language="javascript" type="text/javascript">

var url = <?php echo json_encode(URL); ?>;

var pdfViewUpdate = function(resumeURL) {
    // change pdf path for pdfViewModal
};

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
};

// button => 0: show
// button => 1: hide
var button;
var toggle_history = function() {
    if (button == 0) {
        $('#hitory_data').html('Show History');
        $('.history_data').hide();
        button = 1;
    }
    else {
        $('#hitory_data').html('Hide History');
        $('.history_data').show();
        button = 0;
    }
};

var showHistory = function(jobId) {
    // get list of applied students
    var post_url = url + 'board/ajax_getHistoryJobById/' + jobId;
            
    $.ajax({
        url: post_url,
        type: 'post',
        data: 'json',
        success: function(jsonData) {
            var data = JSON.parse(jsonData);
            $('#hitory_data').html('Hide History');
            $("#hitory_data").attr("onclick","toggle_history()");
            button = 0;
            
            var content = '<table class="history_data" id="student-container"><tbody id="student-body">\n';
            content += '<tr><td style="color:red">Prev Data</td></tr>';
            data.forEach(function(element, index, array) {
                content += '<tr>\n';
                // add user information
                content += '<td>' + element.firstname + ' ' + element.lastname + '</td>\n';
                content += '<td>' + element.email + '</td>\n';
                if(element.personalLink) content += '<td><a href="' + element.personalLink + '" target="_blank">Personal Link</td>\n';
                content += '<td>' + element.phoneNumber + '</td>\n';
                content += '<td>' + element.school + '</td>\n';
                // create drop-down menu for job process
                content += '<td><select class="apply_status" id="process-' + element.userId + '" onchange="updateProgressStatus(\'' + element.userId + '\',\'' + jobId + '\', this)">' + element.status;
                var options = '';
                if (isEmpty(element.process)) {
                    options += '<option value="000000" selected="selected">New</option>'
                }
                else {
                    var find = false;
                    for (var key in element.process) {
                        if (element.status == key) {
                            find = true;
                            options += '<option value="'+key+'" selected="selected">'+element.process[key]+'</option>';
                        }
                        else options += '<option value="'+key+'">'+element.process[key]+'</option>';
                    }
                    
                    if (element.status == "222222") {
                        options += '<option value="222222" selected="selected">Done</option>';
                    }
                    else {
                        options += '<option value="222222">Done</option>';
                    }
                    
                    if (!find) {
                        options = '<option value="000000" selected="selected">New</option>' + options;
                    }
                    else {
                        options = '<option value="000000">New</option>' + options;
                    }
                }
                content += options;
                content += '</select></td>\n';
                // create resume button
                if(element.resume) content += '<td><a class="student-name" data-toggle="modal" data-target="#pdfViewModal" onclick="pdfViewUpdate(\'' + element.resume + '\')">Resume</a></td>\n';
                content += '</tr>\n';
            });
            content += '</tbody></table>';
            $("#jobModalBody").append(content);
        }
    });
};

// update job
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
                content += '<a id="hitory_data" onclick="showHistory(\''+ jobId +'\')">Show History</a>\n';
                content += '</tr>\n';
                content += '<tr>\n';
                // add user information
                content += '<td>' + element.firstname + ' ' + element.lastname + '</td>\n';
                content += '<td>' + element.email + '</td>\n';
                if(element.personalLink) content += '<td><a href="' + element.personalLink + '" target="_blank">Personal Link</td>\n';
                content += '<td>' + element.phoneNumber + '</td>\n';
                content += '<td>' + element.school + '</td>\n';
                // create drop-down menu for job process
                content += '<td><select class="apply_status" id="process-' + element.userId + '" onchange="updateProgressStatus(\'' + element.userId + '\',\'' + jobId + '\', this)">' + element.status;
                var options = '';
                if (isEmpty(element.process)) {
                    options += '<option value="000000" selected="selected">New</option>'
                }
                else {
                    var find = false;
                    for (var key in element.process) {
                        if (element.status == key) {
                            find = true;
                            options += '<option value="'+key+'" selected="selected">'+element.process[key]+'</option>';
                        }
                        else options += '<option value="'+key+'">'+element.process[key]+'</option>';
                    }
                    
                    if (element.status == "222222") {
                        options += '<option value="222222" selected="selected">Done</option>';
                    }
                    else {
                        options += '<option value="222222">Done</option>';
                    }
                    
                    if (!find) {
                        options = '<option value="000000" selected="selected">New</option>' + options;
                    }
                    else {
                        options = '<option value="000000">New</option>' + options;
                    }
                }
                content += options;
                content += '</select></td>\n';
                // create resume button
                if(element.resume) content += '<td><a class="student-name" data-toggle="modal" data-target="#pdfViewModal" onclick="pdfViewUpdate(\'' + element.resume + '\')">Resume</a></td>\n';
                content += '</tr>\n';
            });
            content += '</tbody></table>';
            $("#jobModalBody").html(content);
            $('#set-process-jobId').val(jobId);
        }
    });
};

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true;
}

var change_process_request;

$("#job-process-setting-form").submit(function(event) {
    event.preventDefault();

    if (change_process_request){
        change_process_request.abort();
    }

    var $input = $(this).find("input, select, button, textarea, div");
    var serializedData = $(this).serialize();
    $input.prop("disabled", true);

    request = $.ajax({
        url: <?php echo json_encode(URL . 'board/ajax_change_job_process/'); ?>,
        type: 'post',
        data: serializedData,
        success: function(jsonData) {
            var data = JSON.parse(jsonData);
            
            if (data.error_message) {
                alert(data.error_msg);
            }
            else {
                var id='';
                for (var user_key in data.user_info) {
                    id = data.user_info[user_key].studentId;
                    var content='';
                    if(data.user_info[user_key].status == "000000") content += '<option value="'+data.user_info[user_key].status+'" selected="selected">New</option>'
                    else content += '<option value="000000">New</option>'
                    for (var key in data) {
                        if (key != "user_info") {
                            if(data.user_info[user_key].status == key) content += '<option value="'+key+'" selected="selected">'+data[key]+'</option>';
                            else content += '<option value="'+key+'">'+data[key]+'</option>';
                        }
                    }
                    if(data.user_info[user_key].status == "222222") content += '<option value="'+data.user_info[user_key].status+'" selected="selected">Done</option>'
                    else content += '<option value="222222">Done</option>'
                    $('#process-'+id).html(content);
                }
            }
        }
    });

    request.always(function() {
        $input.prop("disabled", false);
        $('#setJobProcessModal').modal('hide')
    });

    event.preventDefault();
});

var addJobPost_request;
$('#jobpost').submit(function(event) {
    
    event.preventDefault();

    if (addJobPost_request){
        addJobPost_request.abort();
    }

    var $input = $(this).find("input, select, button, textarea, div");
    var serializedData = $(this).serializeArray();
    var company = <?php echo json_encode($this->companyInfo); ?>;
    serializedData.push({name: 'jobcompany', value: company});
    $input.prop("disabled", true);

    request = $.ajax({
        url: <?php echo json_encode(URL . 'board/addJobPost/'); ?>,
        type: 'post',
        data: serializedData,
        success: function(result) {
            
            var data = JSON.parse(result);
            if (!data.error_msg) {
                //alert(data.company + ' ' + data.title + ' ' + data.area + ' ' + data.type + ' ' + data.location + ' ' + data.jobId + ' ' + data.postedDate);
                
                $('#job-container').find('tbody:last').append(
                    '<tr>' +
                        '<td>' +
                            '<a class="job-title" id="' + data.jobId + '" data-toggle="modal" data-target="#jobModal" onclick="updateJob(\'' + data.jobId + '\',\'' + data.title + '\')"><h4>' + data.title + '</h4></a>' +
                            '<div>' + data.company + ' - ' + data.location + '</div>' +
                            '<div class="job-description">' + data.description + '</div>' +
                            '<div>' + data.postedDate + '</div>' +
                            '<div class="jobID">JobID: ' + data.jobId + '</div>' +
                        '</td>' +
                    '</tr>'
                );
                
 
            }
            else{
                alert(data.error_msg);
            }
        }
    });

    request.always(function() {
        $input.prop("disabled", false);
        $('input[type="text"]').val('');
    });

    event.preventDefault();    
});

$('#job-submit').click(function(){
    $('#myModal').modal('hide');
});

$('#job-close').click(function() {
    $('input[type="text"]').val('');
});

</script>