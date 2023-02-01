//user edit
$("#content_loader").on("click","#user_show_edit",function(e){
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
//user edit end

//user edit back to user show
$("#content_loader").on("click","#user_show_back",function(e){
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
//user edit back to user show end

//user delete toggler
$("#content_loader").on("click","#user_show_delete",function(){
    $("#user_delete_div").removeClass("hide");
});

$("#content_loader").on("click","#user_delete_close",function(){
    $("#user_delete_div").addClass("hide");
});
//user delete toggler end

//user delete function
$("#content_loader").on("submit","#user_delete_form",function(e){
    e.preventDefault();
    let url = $("#user_delete_form").attr("action");
    let password = $("#user_delete_password").val();
    let permanent_delete = $("#user_delete_permanent").prop("checked");

    $.ajax({
        url: url,
        type: "DELETE",
        dataType: "json",
        data:{
            password: password,
            permanent_delete: permanent_delete,
        },
        beforeSend: function(){
            $(".user-delete-error").text("");
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            // checking if validator fails
            $("#loading_screen").toggleClass("loading-hide");
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#accounts_delete_"+key+"_error").text(value);
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
                toastr.warning(response.message);
                let url = response.url;

                //on success redirect to user index
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
//user delete function end
