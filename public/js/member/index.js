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
        success: function(response){
            $("#content_loader #member_index_table_container").html(response);
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
        success: function(response){
            $("#content_loader").html(response);
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
        success: function(response){
            $("#content_loader").html(response);
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
        success: function(response){
            $("#content_loader #member_index_table_container").html(response);
        }
    });
});
//pagination  links end
