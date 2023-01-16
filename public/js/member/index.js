//member search
function searchMember()
{
    let search = $("#member_index_search").val();
    let status = $("#member_index_status").val();
    let floor = $("#member_index_floor").val();

    $.ajax({
        url: "/members",
        type: "GET",
        data:{
            search: search,
            status: status,
            floor: floor,
        },
        success: function(response){
            $("#content_loader tbody").html(response);
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
