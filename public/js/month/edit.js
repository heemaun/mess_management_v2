//month name maker
function monthEditNameCreator()
{
    let year = $("#month_edit_year").val();
    let month = $("#month_edit_month").val();

    $("#month_edit_name_viewer").text("Month Name: "+year+"-"+month);
}
//month name maker end

//month create back to show
$("#content_loader").on("click","#month_edit_back",function(e){
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
//month create back to show end

//month update
$("#content_loader").on("submit","#month_edit_form",function(e){
    e.preventDefault();
    let url = $(this).attr("action");
    let year = $("#month_edit_year").val();
    let month = $("#month_edit_month").val();
    let status = $("#month_edit_status").val();

    $.ajax({
        url: url,
        type: "PUT",
        dataType: "json",
        data:{
            name: year+"-"+month,
            status: status,
            year: year,
            month: month,
        },
        beforeSend: function(){
            $(".month-edit-error").text("");
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#month_edit_"+key+"_error").text(value[0]);
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
//month update end
