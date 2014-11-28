<script language="javascript" type="text/javascript">
    
    $("#profile").click(function() {
    	$("#profileResume").show();
    	$("#accountSettings").hide();
    	$("#searchPref").hide();
    	$("#appProgress").hide();
    })

    $("#account").click(function() {
    	$("#accountSettings").show();
    	$("#profileResume").hide();
    	$("#searchPref").hide();
    	$("#appProgress").hide();
    })


    $("#preference").click(function() {
        $("#searchPref").show();
        $("#accountSettings").hide();
        $("#profileResume").hide();
        $("#appProgress").hide();
    })

    $("#progress").click(function() {
        $("#appProgress").show();
        $("#accountSettings").hide();
        $("#profileResume").hide();
        $("#searchPref").hide();
    })

</script>