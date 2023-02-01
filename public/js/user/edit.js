//user create back to show
$("#content_loader").on("click","#user_edit_back",function(e){
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
//user create back to show end

//user update
$("#content_loader").on("submit","#user_edit_form",function(e){
    e.preventDefault();
    let url = $(this).attr("action");

    let name = $("#user_edit_name").val();
    let phone = $("#user_edit_phone").val();
    let email = $("#user_edit_email").val();
    let status = $("#user_edit_status").val();

    $.ajax({
        url: url,
        type: "PUT",
        dataType: "json",
        data:{
            name: name,
            phone: phone,
            email: email,
            status: status,
            password: "false",
        },
        beforeSend: function(){
            $(".user-edit-error").text("");
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#user_edit_"+key+"_error").text(value);
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

                //on success redirect to user show
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
            }
        }
    });
});
//user update end
