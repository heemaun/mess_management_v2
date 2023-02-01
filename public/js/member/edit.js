//member create back to show
$("#content_loader").on("click","#member_edit_back",function(e){
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
//member create back to show end

//member update
$("#content_loader").on("submit","#member_edit_form",function(e){
    e.preventDefault();
    let url = $(this).attr("action");
    let name = $("#member_edit_name").val();
    let phone = $("#member_edit_phone").val();
    let email = $("#member_edit_email").val();
    let initial_balance = $("#member_edit_initial_balance").val();
    let current_balance = $("#member_edit_current_balance").val();
    let joining_date = $("#member_edit_joining_date").val();
    let leaving_date = $("#member_edit_leaving_date").val();
    let status = $("#member_edit_status").val();
    let floor = $("#member_edit_floor").val();

    $.ajax({
        url: url,
        type: "PUT",
        dataType: "json",
        data:{
            name: name,
            phone: phone,
            email: email,
            initial_balance: initial_balance,
            current_balance: current_balance,
            joining_date: joining_date,
            leaving_date: leaving_date,
            status: status,
            floor: floor,
        },
        beforeSend: function(){
            $(".member-edit-error").text("");
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#member_edit_"+key+"_error").text(value);
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
//member update end
