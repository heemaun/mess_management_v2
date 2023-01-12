$("body").on("click","#home_notice_view_close",function(){
    $("#home_notice_view").addClass("hide");
});

$("body").on("click","section aside .clickable",function(e){
    let url = $(this).attr("data-href");
    $.ajax({
        url: url,
        type: "GET",
        // dataType: "json",
        data: {
            from_home: true,
        },
        beforeSend: function(){
            $("#home_notice_view").addClass("hide");
        },
        success: function(response){
            $("#home_notice_view").html(response);
            $("#home_notice_view").removeClass("hide");
        }
    });
});
