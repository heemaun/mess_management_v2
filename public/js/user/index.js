//user search
function searchUser()
{
    let search = $("#user_index_search").val();
    let status = $("#user_index_status").val();

    $.ajax({
        url: "/users",
        type: "GET",
        data:{
            search: search,
            status: status,
        },
        success: function(response){
            $("#content_loader tbody").html(response);
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
