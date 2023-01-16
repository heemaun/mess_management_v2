//month search
function searchMonth()
{
    let status = $("#month_index_status").val();
    let year = $("#month_index_year").val();
    let month = $("#month_index_month").val();

    $.ajax({
        url: "/months",
        type: "GET",
        data:{
            status: status,
            year: year,
            month: month,
        },
        success: function(response){
            $("#content_loader tbody").html(response);
        }
    });
}
//month search end

//month show function on table row click
$("#content_loader").on("click","#month_index .clickable", function(){
    let url = $(this).attr("data-href");

    $.ajax({
        url: url,
        type: "GET",
        success: function(response){
            $("#content_loader").html(response);
        }
    });
});
//month show function on table row click end

//month create
$("#content_loader").on("click","#month_index_create", function(e){
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
//month create end
