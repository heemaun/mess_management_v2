//member create back to index
$("#content_loader").on("click","#member_create_back",function(e){
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
//member create back to index end

//member store function
$("#content_loader").on("submit","#member_create_form",function(e){
    e.preventDefault();
    let url = $(this).attr("action");
    let name = $("#member_create_name").val();
    let phone = $("#member_create_phone").val();
    let email = $("#member_create_email").val();
    let initial_balance = $("#member_create_initial_balance").val();
    let status = $("#member_create_status").val();
    let floor = $("#member_create_floor").val();

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data:{
            name: name,
            phone: phone,
            email: email,
            initial_balance: initial_balance,
            status: status,
            floor: floor,
        },
        beforeSend: function(){
            $(".member-create-error").text("");
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#member_create_"+key+"_error").text(value);
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
                let url = response.url;

                //on success redirect to member show
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
//member store function end
