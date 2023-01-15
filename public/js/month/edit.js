function monthEditNameCreator()
{
    let year = $("#month_edit_year").val();
    let month = $("#month_edit_month").val();

    $("#month_edit_name_viewer").text("Month Name: "+year+"-"+month);
}

$("#content_loader").on("click","#month_edit_back",function(e){
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
        },
        beforeSend: function(){
            $(".month-edit-error").text("");
            console.log(url,year,month,status);
        },
        success: function(response){
            console.log(response);
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#month_edit_"+key+"_error").text(value);
                });
            }

            else if(response.status === "exception"){
                toastr.error(response.message);
            }

            else if(response.status === "error"){
                toastr.error(response.message);
            }

            else{
                toastr.success(response.message);
                let url = response.url;
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
