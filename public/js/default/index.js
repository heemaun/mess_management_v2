//ajax setup for post
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

//toastr settings
toastr.options = {
    "debug": false,
    "positionClass": "toast-bottom-left",
    "onclick": null,
    "fadeIn": 500,
    "fadeOut": 500,
    "timeOut": 2000,
    "extendedTimeOut": 500
}

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
            $("#loading_screen").toggleClass("loading-hide");
            $("#home_notice_view").addClass("hide");
        },
        success: function(response){
            $("#home_notice_view").html(response);
            $("#home_notice_view").removeClass("hide");
            $("#loading_screen").toggleClass("loading-hide");
        }
    });
});
//home notice viwer toogler end

//navbar controls
$("#navbar li a").click(function(e){
    e.preventDefault();
    let url = $(this).attr("href");
    let id = $(this).attr("id");

    $.ajax({
        url: url,
        type: "GET",
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#content_loader").html(response);
            if(id === "home"){
                dashboard();
            }
            $("#navbar").toggleClass("center-ul-show");
            $("#center_ul_toggler").toggleClass("center-ul-close");
            $("#loading_screen").toggleClass("loading-hide");
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
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#content_loader").html(response);
            $("#right_ul").toggleClass("hide");
            $("#loading_screen").toggleClass("loading-hide");
        }
    });
});
//profile trigger ends

//center ul toggler
$("#center_ul_toggler").click(function(){
    $(this).toggleClass("center-ul-close");
    $("#navbar").toggleClass("center-ul-show");
});
//center ul toggler ends

//repositining right ul location
$(document).ready(function(){
    $("#right_ul,#center_ul_toggler,#navbar").css("top",$("nav").height());
    $("main,.content-loader").css("margin-top",$("nav").height());
});
//repositining right ul location ends

$("#up-arrow").click(function(){
    $("html, body").animate(
        {
            scrollTop: $("html").offset().top,
        },
        2000
    );
});
