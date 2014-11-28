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
					$("#job-body").append('<tr><td>' + '<a href="#" class="job-title"><h4>' + jobs[i].title + '</h4></a>' + '<div>' + 
						jobs[i].companyName + ' ' + jobs[i].location + '</div>' + '<div class="job-description">' + jobs[i].description 
						+ '</div>' + '<div>' + jobs[i].postedDate + '</div>' + '</td></tr>');
				}
			}
		}else{
			for(var i = 0; i < length; i++){
				$("#job-body").append('<tr><td>' + '<a href="#" class="job-title"><h4>' + jobs[i].title + '</h4></a>' + '<div>' + 
					jobs[i].companyName + ' ' + jobs[i].location + '</div>' + '<div class="job-description">' + jobs[i].description 
					+ '</div>' + '<div>' + jobs[i].postedDate + '</div>' + '</td></tr>');
			}
		}
    }

</script>

