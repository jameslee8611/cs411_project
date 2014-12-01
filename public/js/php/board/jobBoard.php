<script language="javascript" type="text/javascript">
    $("#searchbar").submit(function(event){
    	event.preventDefault();
    	$("#job-body").empty();
		
		var search = $("#search-input").val();
		search = search.trim();
		
		var url = <?php echo json_encode(URL); ?>;
		var post_url = url + 'board/ajax_getJobList';
		$.ajax({
			url: post_url,
			type: 'post',
			data: 'json',
			success: function(data){
				var jobs = JSON.parse(data);
				showJobs(jobs, search);
			}
		})
	})

    function showJobs(jobs, search){
    	var length = jobs.length;
    	if(search != ''){
	    	for(var i = 0; i < length; i++){
				if((jobs[i].title.toLowerCase()).indexOf(search.toLowerCase()) > -1){
                    if(jobs[i].description.length > 219){
                        var description = jobs[i].description.substr(0, 217) + " ... ";
                    }else{
                        var description = jobs[i].description;
                    }

					$("#job-body").append('<tr><td>' + '<a href="#" class="job-title"><h4>' + jobs[i].title + '</h4></a>' + '<div>Company: ' + 
						jobs[i].companyName + '  /  Location: ' + jobs[i].location + '</div>' + '<div class="job-description">' + description 
						+ '</div>' + '<div>Date Posted: ' + jobs[i].postedDate + '</div>' + '</td></tr>');
				}
			}
		}else{
			for(var i = 0; i < length; i++){
                if(jobs[i].description.length > 219){
                    var description = jobs[i].description.substr(0, 217) + " ... ";
                }else{
                    var description = jobs[i].description;
                }
				$("#job-body").append('<tr><td>' + '<a href="#" class="job-title"><h4>' + jobs[i].title + '</h4></a>' + '<div>Company: ' + 
					jobs[i].companyName + '  /  Location: ' + jobs[i].location + '</div>' + '<div class="job-description">' + description 
					+ '</div>' + '<div>Date Posted: ' + jobs[i].postedDate + '</div>' + '</td></tr>');
			}
		}
    }

    $(".job-title").click(function(){
    	var jobRow = $(this).closest("tr").find("td");
    	var job = $(jobRow[0]).find(".jobID");
    	var jobId = job[0].innerHTML;
    	fillApplyModal(jobId);
    })

    function fillApplyModal(jobId){
    	$("#applyModalBody").empty();
    	var url = <?php echo json_encode(URL); ?>;
		var post_url = url + 'board/ajax_findJobById';
    	$.ajax({
    		url: post_url,
    		type: 'post',
    		data: {'jobID': jobId},
    		dataType: 'json',
    		success: function(data){
    			$("#applyModalBody").append('<div><h4>' + data.title + '</h4></div>' + '<div>Company: ' + 
					data.companyName + ' Location: ' + data.location + '</div>' + '<div>Type: ' + data.type + '</div>'  
					+ '<div>Area: ' + data.area + ' Level: ' + data.level + '</div>' + '<div>Skill: ' + data.requiredSkill + '</div>' 
					+ '<div>Salary: ' + data.salary + ' Date Posed: ' + data.postedDate + ' Visa Type: ' + data.seekerVisaType + '</div>'
					+ '<div class="job-description">' + data.description + '</div>' + '<div id="currentJobId">' + jobId + '</div>');
    		}
    	})
    }

    $("#applyButton").click(function(){
    	var jobId = $("#currentJobId").html();
    	var url = <?php echo json_encode(URL); ?>;
		var post_url = url + 'board/ajax_applyJob';
    	$.ajax({
    		url: post_url,
    		type: "post",
    		data: {"jobId" : jobId},
    		success: function(data){
    			alert(data);
    		}
    	})
    })

</script>

