//payment search
function searchPayment()
{
    let search = $("#payment_index_search").val();
    let status = $("#payment_index_status").val();
    let from = $("#payment_index_from").val();
    let to = $("#payment_index_to").val();
    let limit = $("#payment_index_limit").val();

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
        url: "/payments",
        type: "GET",
        data:{
            search: search,
            status: status,
            from: from,
            to: to,
            limit: limit,
        },
        success: function(response){
            $("#content_loader #payment_index_table_container").html(response);
        }
    });
}
//payment search end

//payment show function on table row click
$("#content_loader").on("click","#payment_index .clickable", function(){
    let url = $(this).attr("data-href");

    $.ajax({
        url: url,
        type: "GET",
        success: function(response){
            $("#content_loader").html(response);
        }
    });
});
//payment show function on table row click end

//payment create
$("#content_loader").on("click","#payment_index_create", function(e){
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
//payment create end

//pagination  links
$("#content_loader").on("click","#payment_index .pagination a",function(e){
    e.preventDefault();
    let url = $(this).attr("href");
    let search = $("#payment_index_search").val();
    let status = $("#payment_index_status").val();
    let from = $("#payment_index_from").val();
    let to = $("#payment_index_to").val();
    let limit = $("#payment_index_limit").val();

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
            status: status,
            from: from,
            to: to,
            limit: limit,
        },
        success: function(response){
            $("#content_loader #payment_index_table_container").html(response);
        }
    });
});
//pagination  links end

//filter trigger
$("#content_loader").on("click","#payment_index_filter_trigger",function(){
    $(".top").toggleClass("top-hide");
    $(this).toggleClass("filter-close");
});
//filter trigger ends
