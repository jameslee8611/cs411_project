<script language="javascript" type="text/javascript">

    $(document).on('click', ".company-name", function(){
    	var companyRow = $(this).closest("tr").find("td");
    	var company = $(companyRow[0]).find(".companyId");
    	var companyId = company[0].innerHTML;
    	var modal = $(this).attr("data-target");
    	fillLikeModal(companyId, modal);
    });

    function fillLikeModal(companyId, modal){
    	$(modal + "Body").empty();
    	var url = <?php echo json_encode(URL); ?>;
		var post_url = url + 'company/ajax_findCompanyById';
    	$.ajax({
    		url: post_url,
    		type: 'post',
    		data: {'companyId': companyId},
    		dataType: 'json',
    		success: function(data){
    			$(modal + 'Body').append('<div><h4>' + data.name  + '</h4></div>' + '<div class="company-description">' + data.description
    			 + '</div>' + '<div id="currentCompanyId">' + companyId + '</div>');
    		}
    	})
    }

    $("#likeButton").click(function(){
    	var companyId = $("#currentCompanyId").html();
    	var url = <?php echo json_encode(URL); ?>;
		var post_url = url + 'company/ajax_likeCompany';
    	$.ajax({
    		url: post_url,
    		type: "post",
    		data: {"companyId" : companyId},
    		success: function(data){
    			$("#company-body .companyId:contains('" + companyId + "')").closest("tr").find(".company-name").attr("data-target", "#dislikeModal");
    			$("#liked-company-body").append("<tr>" + $("#company-body .companyId:contains('" + companyId + "')").closest("tr").html() + "</tr>");
    			$("#company-body .companyId:contains('" + companyId + "')").closest("tr").remove();
    		}
    	})
    })

    $("#dislikeButton").click(function(){
    	var companyId = $("#currentCompanyId").html();
    	var url = <?php echo json_encode(URL); ?>;
		var post_url = url + 'company/ajax_dislikeCompany';
    	$.ajax({
    		url: post_url,
    		type: "post",
    		data: {"companyId" : companyId},
    		success: function(data){
    			$("#liked-company-body .companyId:contains('" + companyId + "')").closest("tr").find(".company-name").attr("data-target", "#likeModal");
    			$("#company-body").append("<tr>" + $("#liked-company-body .companyId:contains('" + companyId + "')").closest("tr").html() + "</tr>");
    			$("#liked-company-body .companyId:contains('" + companyId + "')").closest("tr").remove();
    		}
    	})
    })

</script>

