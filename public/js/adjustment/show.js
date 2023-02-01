//adjustment edit
$("#content_loader").on("click","#adjustment_show_edit",function(e){
    e.preventDefault();
    let url = $(this).attr("href");

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
});
//adjustment edit end

//adjustment edit back to adjustment show
$("#content_loader").on("click","#adjustment_show_back",function(e){
    e.preventDefault();
    let url = $(this).attr("href");

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
});
//adjustment edit back to adjustment show end

//adjustment delete toggler
$("#content_loader").on("click","#adjustment_show_delete",function(){
    $("#adjustment_delete_div").removeClass("hide");
});

$("#content_loader").on("click","#adjustment_delete_close",function(){
    $("#adjustment_delete_div").addClass("hide");
});
//adjustment delete toggler end

//adjustment delete function
$("#content_loader").on("submit","#adjustment_delete_form",function(e){
    e.preventDefault();
    let url = $("#adjustment_delete_form").attr("action");
    let password = $("#adjustment_delete_password").val();
    let permanent_delete = $("#adjustment_delete_permanent").prop("checked");

    $.ajax({
        url: url,
        type: "DELETE",
        dataType: "json",
        data:{
            password: password,
            permanent_delete: permanent_delete,
        },
        beforeSend: function(){
            $(".adjustment-delete-error").text("");
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#adjustment_delete_"+key+"_error").text(value);
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

                //on success redirect to adjustment index
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
//adjustment delete function end

// redirecting to month / member
$("#content_loader").on("click","#adjustment_show label a",function(e){
    e.preventDefault();
    let url = $(this).attr("href");

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
});
// redirecting to month / member ends
