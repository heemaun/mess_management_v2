//ajax setup for post
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

//home notice viwer toogler
$("body").on("click","#home_notice_view_close",function(){
    $("#home_notice_view").addClass("hide");
});

$("body").on("click","section aside .clickable",function(e){
    let url = $(this).attr("data-href");
    $.ajax({
        url: url,
        type: "GET",
        data: {
            from_home: true,
        },
        beforeSend: function(){
            $("#home_notice_view").addClass("hide");
        },
        success: function(response){
            $("#home_notice_view").html(response);
            $("#home_notice_view").removeClass("hide");
        }
    });
});
//home notice viwer toogler end


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
        },
        success: function(response){
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

//navbar controls
$("#navbar li a").click(function(e){
    e.preventDefault();
    url = $(this).attr("href");

    $.ajax({
        url: url,
        type: "GET",
        success: function(response){
            $("#content_loader").html(response);
        }
    });
});
//navbar controls end

//right-trigger-controlls
$("#right_trigger").click(function(){
    $("#right_ul").toggleClass("hide");
});
//right-trigger-controlls ends

//profile trigger
$("#profile a").click(function(e){
    e.preventDefault();
    let url = $(this).attr("href");

    $.ajax({
        url: url,
        type: "GET",
        success: function(response){
            $("#content_loader").html(response);
            $("#right_ul").toggleClass("hide");
        }
    });
});
//profile trigger ends

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
            console.log(current_password,new_password,new_password_confirmation);
        },
        success: function(response){
            console.log(response);
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
