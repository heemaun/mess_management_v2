//notice create back to index
$("#content_loader").on("click","#notice_create_back",function(e){
    e.preventDefault();
    let url = $(this).attr("href");

    $.ajax({
        url: url,
        type: "GET",
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#content_loader").html(response);
            $("#loading_screen").toggleClass("loading-hide");
        }
    });
});
//notice create back to index end

//notice store function
$("#content_loader").on("submit","#notice_create_form",function(e){
    e.preventDefault();
    let url = $(this).attr("action");
    let heading = $("#notice_create_heading").val();
    let body = $("#notice_create_body").val();
    let status = $("#notice_create_status").val();

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data:{
            heading: heading,
            body: body,
            status: status,
        },
        beforeSend: function(){
            $(".notice-create-error").text("");
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#notice_create_"+key+"_error").text(value);
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

                //on success redirect to notice show
                $.ajax({
                    url: url,
                    type: "GET",
                    beforeSend: function(){
                        $("#loading_screen").toggleClass("loading-hide");
                    },
                    success: function(response){
                        $("#loading_screen").toggleClass("loading-hide");
                        $("#content_loader").html(response);
                    }
                });
            }
        }
    });
});
//notice store function end
