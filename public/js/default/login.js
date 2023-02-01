//login controller starts

//login div toggler
$("#login").click(function(e){
    e.preventDefault();
    $("#login_div").removeClass("hide");
});

$("#login_div_close").click(function(){
    $("#login_div").addClass("hide");
});
//login div toggler ends

$("#login_form").submit(function(e){
    e.preventDefault();
    let url = $(this).attr("action");
    let type = $(this).attr("method");
    let email = $("#login_email").val();
    let password = $("#login_password").val();

    $.ajax({
        url: url,
        type: type,
        dataType: "json",
        data:{
            email: email,
            password: password,
        },
        beforeSend: function(){
            $(".login-error").text("");
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#login_"+key+"_error").text(value);
                });
            }

            else if(response.status === "error"){
                toastr.error(response.message);
            }

            else{
                window.location = response.url;
                toastr.success(response.message);
            }
        }
    });
});
//login controller ends
