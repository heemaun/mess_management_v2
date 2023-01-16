//loads home view in the content loader
function homeload()
{
    $.ajax({
        url: "/members/1/edit",
        // url: "/home",
        type: "GET",
        success: function(response){
            $("#content_loader").html(response);
        }
    });
}

homeload();
//end

//home month view changer
$("#content_loader").on("change","#home_month_name_select",function(){
    let key = $(this).val();
    $.ajax({
        url: "/months/"+key,
        type: "GET",
        data: {
            from_home: true,
        },
        beforeSend: function(){
            console.log(key);
        },
        success: function(response){
            $("#content_loader #table_container").html(response);
        }
    });
});
//home month view changer ends

//home month view floor changer
$("#content_loader").on("change","#home_floor_select",function(){
    $("#ground_floor_table_div").addClass("hide");
    $("#first_floor_table_div").addClass("hide");
    $("#second_floor_table_div").addClass("hide");
    $("#all_table_div").addClass("hide");

    let key = $(this).val();

    if(key === "ground_floor"){
        $("#ground_floor_table_div").removeClass("hide");
    }
    else if(key === "first_floor"){
        $("#first_floor_table_div").removeClass("hide");
    }
    else if(key === "second_floor"){
        $("#second_floor_table_div").removeClass("hide");
    }
    else{
        $("#ground_floor_table_div").removeClass("hide");
        $("#first_floor_table_div").removeClass("hide");
        $("#second_floor_table_div").removeClass("hide");
        $("#all_table_div").removeClass("hide");
    }
});
//home month view floor changer end
