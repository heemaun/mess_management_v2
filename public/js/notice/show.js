//notice edit
$("#content_loader").on("click","#notice_show_edit",function(e){
    e.preventDefault();
    let url = $(this).attr("href");

    $.ajax({
        url: url,
        type: "GET",
        success: function(response){
            $("#content_loader").html(response);
        }
    });
});
//notice edit end

//notice edit back to notice show
$("#content_loader").on("click","#notice_show_back",function(e){
    e.preventDefault();
    let url = $(this).attr("href");

    $.ajax({
        url: url,
        type: "GET",
        success: function(response){
            $("#content_loader").html(response);
        }
    });
});
//notice edit back to notice show end

//notice delete toggler
$("#content_loader").on("click","#notice_show_delete",function(){
    $("#notice_delete_div").removeClass("hide");
});

$("#content_loader").on("click","#notice_delete_close",function(){
    $("#notice_delete_div").addClass("hide");
});
//notice delete toggler end

//notice delete function
$("#content_loader").on("submit","#notice_delete_form",function(e){
    e.preventDefault();
    let url = $("#notice_delete_form").attr("action");
    let password = $("#notice_delete_password").val();
    let permanent_delete = $("#notice_delete_permanent").prop("checked");

    $.ajax({
        url: url,
        type: "DELETE",
        dataType: "json",
        data:{
            password: password,
            permanent_delete: permanent_delete,
        },
        beforeSend: function(){
            $(".notice-delete-error").text("");
        },
        success: function(response){
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#notice_delete_"+key+"_error").text(value);
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

                //on success redirect to notice index
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response){
                        $("#content_loader").html(response);
                    }
                });
            }
        }
    });
});
//notice delete function end
