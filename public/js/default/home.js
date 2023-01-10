function homeload()
{
    $.ajax({
        url: "/home",
        type: "GET",
        success: function(response){
            $("#content_loader").html(response);
        }
    });
}

homeload();
