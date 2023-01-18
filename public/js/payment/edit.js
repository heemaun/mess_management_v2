//payment create back to show
$("#content_loader").on("click","#payment_edit_back",function(e){
    e.preventDefault();
    let url = $(this).attr("href");

    $.ajax({
        url: url,
        type: "GET",
        success: function(response){
            $("#content_loader").html(response);
        }
    });
});
//payment create back to show end

//payment update
$("#content_loader").on("submit","#payment_edit_form",function(e){
    e.preventDefault();
    let url = $(this).attr("action");
    let heading = $("#payment_edit_heading").val();
    let body = $("#payment_edit_body").val();
    let status = $("#payment_edit_status").val();

    $.ajax({
        url: url,
        type: "PUT",
        dataType: "json",
        data:{
            heading: heading,
            body: body,
            status: status,
        },
        beforeSend: function(){
            $(".payment-edit-error").text("");
        },
        success: function(response){
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#payment_edit_"+key+"_error").text(value);
                });
            }

            //checking if laravel / database fails
            else if(response.status === "exception"){
                toastr.error(response.message);
            }

            //checking other common error fails
            else if(response.status === "error"){
                toastr.error(response.message);
            }

            else{
                toastr.success(response.message);
                let url = response.url;

                //on success redirect to payment show
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response){
                        $("#content_loader").html(response);
                    }
                });
            }
        }
    });
});
//payment update end
