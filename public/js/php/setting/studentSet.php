<script language="javascript" type="text/javascript">

    var profile = <?php echo json_encode($this->profile);?>;
    var preference = <?php echo json_encode($this->preference);?>;

    $(document).ready(function(){
        $("#firstname").val(profile[0]["firstname"]);
        $("#lastname").val(profile[0]["lastname"]);
        $("#phonenum").val(profile[0]["phoneNumber"]);
        $("#personallink").val(profile[0]["personalLink"]);
        $("#address").val(profile[0]["address"]);
        $("#school").val(profile[0]["school"]);
        $("#profile-visa option[value='" + profile[0]["visaStatus"] + "']" ).prop("selected", true);
        $("#current-resume").html(" Current Resume: " + profile[0]["resume"]);

        $("#min-salary").val(preference[0]["salary"]);
        $("#skill-primary").val(preference[0]["skill"]);
        $("#area").val(preference[0]["area"]);
        $("#level option[value='" + preference[0]["level"] + "']" ).prop("selected", true);
        $("#position option[value='" + preference[0]["position"] + "']" ).prop("selected", true);
        $("#search-visa option[value='" + preference[0]["visa"] + "']" ).prop("selected", true);
    })

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

    $("#profileForm").submit(function(event){
        event.preventDefault();

        var url = <?php echo json_encode(URL); ?>;
        var post_url = url + "setting/updateProfile";

        var post_data = new FormData();
        
        if(document.getElementById("resume").files.length > 0){
            post_data.append("resume", document.getElementById("resume").files[0]);
        }

        post_data.append("firstname", $("#firstname").val());
        post_data.append("lastname", $("#lastname").val());
        post_data.append("phonenum", $("#phonenum").val());
        post_data.append("personallink", $("#personallink").val());
        post_data.append("address", $("#address").val());
        post_data.append("school", $("#school").val());
        post_data.append("profile-visa", $("#profile-visa").val());

        $.ajax({
            url: post_url,
            type: "post",
            data: post_data,
            processData: false,
            contentType: false,
            success: function(data){
                
            }
        })
    })

</script>