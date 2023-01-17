//notice search
function searchNotice()
{
    let search = $("#notice_index_search").val();
    let status = $("#notice_index_status").val();
    let from = $("#notice_index_from").val();
    let to = $("#notice_index_to").val();

    if(from === ""){
        from = "1970-1-1";
    }
    if(to === ""){
        to = new Date().getFullYear()+"-12-31 23:59:59";
    }
    else{
        to = new Date().getFullYear()+"-12-31 23:59:59";
    }

    $.ajax({
        url: "/notices",
        type: "GET",
        data:{
            search: search,
            status: status,
            from: from,
            to: to,
        },
        success: function(response){
            $("#content_loader tbody").html(response);
        }
    });
}
//notice search end

//notice show function on table row click
$("#content_loader").on("click","#notice_index .clickable", function(){
    let url = $(this).attr("data-href");

    $.ajax({
        url: url,
        type: "GET",
        success: function(response){
            $("#content_loader").html(response);
        }
    });
});
//notice show function on table row click end

//notice create
$("#content_loader").on("click","#notice_index_create", function(e){
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
//notice create end
