//adjustment create back to index
$("#content_loader").on("click","#adjustment_create_back",function(e){
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
//adjustment create back to index end

//get member by floor
$("#content_loader").on("change","#adjustment_create_floor",function(){
    let floor = $(this).val();

    $.ajax({
        url: "/members",
        type: "GET",
        dataType: "json",
        data: {
            from_payment_create: true,
            floor: floor,
        },
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
            $("#adjustment_create_member").find('option').remove().end().append('<option value="all">Select a member</option>');
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            $.each(response.data,function(key,value){
                $("#adjustment_create_member").append('<option value="'+value.id+'">'+value.name+'</option>')
            });
        }
    });
});
//get member by floor end

//adjustment store function
$("#content_loader").on("submit","#adjustment_create_form",function(e){
    e.preventDefault();
    let url = $(this).attr("action");
    let member_id = $("#adjustment_create_member").val();
    let amount = $("#adjustment_create_amount").val();
    let type = $("#adjustment_create_type").val();
    let status = $("#adjustment_create_status").val();
    let note = $("#adjustment_create_note").val();

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data:{
            member_id: member_id,
            amount: amount,
            type: type,
            status: status,
            note: note,
        },
        beforeSend: function(){
            $(".adjustment-create-error").text("");
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#adjustment_create_"+key+"_error").text(value);
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

                //on success redirect to adjustment show
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
//adjustment store function end
