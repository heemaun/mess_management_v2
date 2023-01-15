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
