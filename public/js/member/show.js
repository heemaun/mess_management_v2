//member edit
$("#content_loader").on("click","#member_show_edit",function(e){
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
//member edit end

//member edit back to member show
$("#content_loader").on("click","#member_show_back",function(e){
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
//member edit back to member show end

//member delete toggler
$("#content_loader").on("click","#member_show_delete",function(){
    $("#member_delete_div").removeClass("hide");
});

$("#content_loader").on("click","#member_delete_close",function(){
    $("#member_delete_div").addClass("hide");
});
//member delete toggler end

//member delete function
$("#content_loader").on("submit","#member_delete_form",function(e){
    e.preventDefault();
    let url = $("#member_delete_form").attr("action");
    let password = $("#member_delete_password").val();
    let permanent_delete = $("#member_delete_permanent").prop("checked");

    $.ajax({
        url: url,
        type: "DELETE",
        dataType: "json",
        data:{
            password: password,
            permanent_delete: permanent_delete,
        },
        beforeSend: function(){
            $(".member-delete-error").text("");
        },
        success: function(response){
            //checking if validator fails
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

                //on success redirect to member index
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
//member delete function end
