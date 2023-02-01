//member search
function searchMember()
{
    let search = $("#member_index_search").val();
    let status = $("#member_index_status").val();
    let floor = $("#member_index_floor").val();
    let limit = $("#member_index_limit").val();

    $.ajax({
        url: "/members",
        type: "GET",
        data:{
            search: search,
            status: status,
            floor: floor,
            limit: limit,
        },
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#content_loader #member_index_table_container").html(response);
            $("#loading_screen").toggleClass("loading-hide");
        }
    });
}
//member search end

//member show function on table row click
$("#content_loader").on("click","#member_index .clickable", function(){
    let url = $(this).attr("data-href");

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
//member show function on table row click end

//member create
$("#content_loader").on("click","#member_index_create", function(e){
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
//member create end

//pagination  links
$("#content_loader").on("click","#member_index .pagination a",function(e){
    e.preventDefault();
    let url = $(this).attr("href");
    let search = $("#member_index_search").val();
    let status = $("#member_index_status").val();
    let floor = $("#member_index_floor").val();
    let limit = $("#member_index_limit").val();

    $.ajax({
        url: url,
        type: "GET",
        data:{
            search: search,
            status: status,
            floor: floor,
            limit: limit,
        },
        beforeSend: function(){
            $("#loading_screen").toggleClass("loading-hide");
        },
        success: function(response){
            $("#content_loader #member_index_table_container").html(response);
            $("#loading_screen").toggleClass("loading-hide");
        }
    });
});
//pagination  links end

//filter trigger
$("#content_loader").on("click","#member_index_filter_trigger",function(){
    $(".top").toggleClass("top-hide");
    $(this).toggleClass("filter-close");
});
//filter trigger ends
