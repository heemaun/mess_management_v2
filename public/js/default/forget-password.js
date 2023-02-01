$("#forget_password_trigger").click(function(){
    $("#login_div").toggleClass("hide");
    let stage = $("#forget_password_form").attr("data-stage");
    $.ajax({
        url: "/forget-password",
        type: "GET",
        data:{
            stage: stage,
        },
        success: function(response){
            $("#forget_password_div").html(response);
            $("#forget_password_div").toggleClass("hide");
        }
    });
});

$("body").on("click","#forget_password_form_close",function(){
    $("#forget_password_div").html("").toggleClass("hide");
});

$("body").on("submit","#forget_password_form",function(e){
    e.preventDefault();

    let url = $(this).attr("action");
    let email = $("#forget_password_email").val();
    let code = $("#forget_password_code").val();
    let user_email = $("#forget_password_user_email").val();
    let new_password = $("#forget_password_new_password").val();
    let new_password_confirmation = $("#forget_password_new_password_confirmation").val();
    let stage = $(this).attr("data-stage");

    $.ajax({
        url: url,
        type: "POST",
        data: {
            email: email,
            code: code,
            stage: stage,
            user_email: user_email,
            new_password: new_password,
            new_password_confirmation: new_password_confirmation,
        },
        beforeSend: function(){
            $(".forget-password-error").text("");
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#forget_password_"+key+"_error").text(value[0]);
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

                if(response.login === true){
                    $("#forget_password_div").html("").toggleClass("hide");
                    $("#login_div").toggleClass("hide");
                }

                else{
                    let url = response.url;
                    let stage = response.stage;
                    let user_email = response.user_email;

                    $.ajax({
                        url: url,
                        type: "GET",
                        data:{
                            stage: stage,
                        },
                        success: function(response){
                            $("#forget_password_div").html(response);
                            $("#forget_password_user_email").val(user_email);
                        }
                    });
                }
            }
        }
    });
});
