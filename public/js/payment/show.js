//payment edit
$("#content_loader").on("click","#payment_show_edit",function(e){
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
//payment edit end

//payment edit back to payment show
$("#content_loader").on("click","#payment_show_back",function(e){
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
//payment edit back to payment show end

//payment delete toggler
$("#content_loader").on("click","#payment_show_delete",function(){
    $("#payment_delete_div").removeClass("hide");
});

$("#content_loader").on("click","#payment_delete_close",function(){
    $("#payment_delete_div").addClass("hide");
});
//payment delete toggler end

//payment delete function
$("#content_loader").on("submit","#payment_delete_form",function(e){
    e.preventDefault();
    let url = $("#payment_delete_form").attr("action");
    let password = $("#payment_delete_password").val();
    let permanent_delete = $("#payment_delete_permanent").prop("checked");

    $.ajax({
        url: url,
        type: "DELETE",
        dataType: "json",
        data:{
            password: password,
            permanent_delete: permanent_delete,
        },
        beforeSend: function(){
            $(".payment-delete-error").text("");
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#payment_delete_"+key+"_error").text(value);
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

                //on success redirect to payment index
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
//payment delete function end

// redirecting to month / member
$("#content_loader").on("click","#payment_show label a,#payment_show_create",function(e){
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
// redirecting to month / member ends
