<script language="javascript" type="text/javascript">

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
            var content='<ul>\n';
            data.forEach(function(element, index, array) { //element.Type
                content += '<li><a class="student-name" data-toggle="modal" data-target="#pdfViewModal">' + element.firstname + ' ' + element.lastname + '</li>\n';
            });
            content += '</ul>';
            $("#jobModalBody").html(content);
        }
    });
};

</script>