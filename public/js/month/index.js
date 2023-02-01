//month search
function searchMonth()
{
    let status = $("#month_index_status").val();
    let year = $("#month_index_year").val();
    let month = $("#month_index_month").val();
    let limit = $("#month_index_limit").val();

    $.ajax({
        url: "/months",
        type: "GET",
        data:{
            status: status,
            year: year,
            month: month,
            limit: limit,
        },
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#content_loader #month_index_table_container").html(response);
            $("#loading_screen").toggleClass("loading-hide");
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
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#content_loader").html(response);
            $("#loading_screen").toggleClass("loading-hide");
        }
    });
});
//month create end

//pagination  links
$("#content_loader").on("click","#month_index .pagination a",function(e){
    e.preventDefault();
    let url = $(this).attr("href");
    let status = $("#month_index_status").val();
    let year = $("#month_index_year").val();
    let month = $("#month_index_month").val();
    let limit = $("#month_index_limit").val();

    $.ajax({
        url: url,
        type: "GET",
        data:{
            status: status,
            year: year,
            month: month,
            limit: limit,
        },
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#content_loader #month_index_table_container").html(response);
            $("#loading_screen").toggleClass("loading-hide");
        }
    });
});
//pagination  links end

//filter trigger
$("#content_loader").on("click","#month_index_filter_trigger",function(){
    $(".top").toggleClass("top-hide");
    $(this).toggleClass("filter-close");
});
//filter trigger ends
