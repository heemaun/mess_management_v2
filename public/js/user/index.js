//user search
function searchUser()
{
    let search = $("#user_index_search").val();
    let status = $("#user_index_status").val();
    let limit = $("#user_index_limit").val();

    $.ajax({
        url: "/users",
        type: "GET",
        data:{
            search: search,
            status: status,
            limit: limit,
        },
        success: function(response){
            $("#content_loader #user_index_table_container").html(response);
        }
    });
}
//user search end

//user show function on table row click
$("#content_loader").on("click","#user_index .clickable", function(){
    let url = $(this).attr("data-href");

    $.ajax({
        url: url,
        type: "GET",
        success: function(response){
            $("#content_loader").html(response);
        }
    });
});
//user show function on table row click end

//user create
$("#content_loader").on("click","#user_index_create", function(e){
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
//user create end

//pagination  links
$("#content_loader").on("click",".pagination a",function(e){
    e.preventDefault();
    let url = $(this).attr("href");
    let search = $("#user_index_search").val();
    let status = $("#user_index_status").val();
    let limit = $("#user_index_limit").val();

    $.ajax({
        url: url,
        type: "GET",
        data:{
            search: search,
            status: status,
            limit: limit,
        },
        success: function(response){
            $("#content_loader #user_index_table_container").html(response);
        }
    });
});
//pagination  links end
