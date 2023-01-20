//adjustment search
function searchAdjustment()
{
    let search = $("#adjustment_index_search").val();
    let type = $("#adjustment_index_type").val();
    let status = $("#adjustment_index_status").val();
    let from = $("#adjustment_index_from").val();
    let to = $("#adjustment_index_to").val();

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
        },
        success: function(response){
            $("#content_loader tbody").html(response);
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
        success: function(response){
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
        success: function(response){
            $("#content_loader").html(response);
        }
    });
});
//adjustment create end
