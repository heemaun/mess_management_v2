//month name maker
function monthNameCreator()
{
    let year = $("#month_create_year").val();
    let month = $("#month_create_month").val();

    $("#month_create_name_viewer").text("Month Name: "+year+"-"+month);
}
//month name maker end

//month create back to index
$("#content_loader").on("click","#month_create_back",function(e){
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
//month create back to index end

//month store function
$("#content_loader").on("submit","#month_create_form",function(e){
    e.preventDefault();
    let url = $(this).attr("action");
    let year = $("#month_create_year").val();
    let month = $("#month_create_month").val();
    let status = $("#month_create_status").val();

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data:{
            name: year+"-"+month,
            status: status,
        },
        beforeSend: function(){
            $(".month-create-error").text("");
        },
        success: function(response){
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#month_create_"+key+"_error").text(value);
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

                //on success redirect to month show
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
//month store function end
