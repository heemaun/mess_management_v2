//adjustment search
function searchAdjustment()
{
    let search = $("#adjustment_index_search").val();
    let type = $("#adjustment_index_type").val();
    let status = $("#adjustment_index_status").val();
    let from = $("#adjustment_index_from").val();
    let to = $("#adjustment_index_to").val();
    let limit = $("#adjustment_index_limit").val();

    if(from === ""){
        from = "1970-1-1";
    }
    if(to === ""){
        to = new Date().getFullYear()+"-12-31 23:59:59";
    }
    else{
        to = to+" 23:59:59";
    }

    $.ajax({
        url: "/adjustments",
        type: "GET",
        data:{
            search: search,
            type: type,
            status: status,
            from: from,
            to: to,
            limit: limit,
        },
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#content_loader #adjustment_index_table_container").html(response);
            $("#loading_screen").toggleClass("loading-hide");
        }
    });
}
//adjustment search end

//adjustment show function on table row click
$("#content_loader").on("click","#adjustment_index .clickable", function(){
    let url = $(this).attr("data-href");

    $.ajax({
        url: url,
        type: "GET",
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            $("#content_loader").html(response);
        }
    });
});
//adjustment show function on table row click end

//adjustment create
$("#content_loader").on("click","#adjustment_index_create", function(e){
    e.preventDefault();
    let url = $(this).attr("href");

    $.ajax({
        url: url,
        type: "GET",
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            $("#content_loader").html(response);
        }
    });
});
//adjustment create end

//pagination  links
$("#content_loader").on("click","#adjustment_index .pagination a",function(e){
    e.preventDefault();
    let url = $(this).attr("href");
    let search = $("#adjustment_index_search").val();
    let type = $("#adjustment_index_type").val();
    let status = $("#adjustment_index_status").val();
    let from = $("#adjustment_index_from").val();
    let to = $("#adjustment_index_to").val();
    let limit = $("#adjustment_index_limit").val();

    if(from === ""){
        from = "1970-1-1";
    }
    if(to === ""){
        to = new Date().getFullYear()+"-12-31 23:59:59";
    }
    else{
        to = to+" 23:59:59";
    }

    $.ajax({
        url: url,
        type: "GET",
        data:{
            search: search,
            type: type,
            status: status,
            from: from,
            to: to,
            limit: limit,
        },
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#loading_screen").toggleClass("loading-hide");
            $("#content_loader #adjustment_index_table_container").html(response);
        }
    });
});
//pagination  links end

//filter trigger
$("#content_loader").on("click","#adjustment_index_filter_trigger",function(){
    $(".top").toggleClass("top-hide");
    $(this).toggleClass("filter-close");
});
//filter trigger ends
