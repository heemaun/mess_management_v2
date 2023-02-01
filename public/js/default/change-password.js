//change password trigger
$("#change_password a").click(function(){
    $("#right_ul").toggleClass("hide");
    $("#change_password_div").toggleClass("hide");
});

$("#change_password_close").click(function(){
    $("#change_password_current").val("");
    $("#change_password_new").val("");
    $("#change_password_confirm").val("");

    $(".change-password-error").text("");

    $("#change_password_div").toggleClass("hide");
});
//change password trigger ends

//change password funcitonality
$("#change_password_form").submit(function(e){
    e.preventDefault();
    let url = $(this).attr("action");

    let current_password = $("#change_password_current").val();
    let new_password = $("#change_password_new").val();
    let new_password_confirmation = $("#change_password_confirm").val();

    $.ajax({
        url: url,
        type: "PUT",
        dataType: "json",
        data:{
            current_password: current_password,
            new_password: new_password,
            new_password_confirmation: new_password_confirmation,
            password: "true",
        },
        beforeSend: function(){
            $(".change-password-error").text("");
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#change_password_"+key+"_error").text(value[0]);
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
                $("#change_password_div").toggleClass("hide");
            }
        }
    });
});
//change password funcitonality ends
