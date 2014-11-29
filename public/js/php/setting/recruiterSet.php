<script language="javascript" type="text/javascript">
    
    $("#profile").click(function(){
    	$("#profileResume").show();
    	$("#accountSettings").hide();
    	$("#searchPref").hide();
    	$("#appProgress").hide();
    });

    $("#account").click(function(){
    	$("#accountSettings").show();
    	$("#profileResume").hide();
    	$("#searchPref").hide();
    	$("#appProgress").hide();
    });
    
    $('#addCompany').click(function() {
        $('#addCompanyBox').toggle();
    });
    
    var addCompany_request;
    $('#company-data').submit(function(event) {
        if (addCompany_request)
        {
            addCompany_request.abort();
        }

        var $input = $(this).find("input, select, button, textarea, div");
        var serializedData = $(this).serialize();
        $input.prop("disabled", true);

        request = $.ajax({
            url: <?php echo json_encode(URL . 'setting/addCompany/'); ?>,
            type: 'post',
            data: serializedData,
            success: function(result) {
                var data = JSON.parse(result);
                if (!data.error_msg) $("#company_list").append('<option value=1>' + data.company + '</option>');
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
    });
</script>