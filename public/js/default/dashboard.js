function dashboard()
{
    $.ajax({
        url: "/members-months",
        type: "GET",
        dataType: "json",
        success: function(response){
            let m = response.m;
            let months = response.months;

            if(m.length !== 0 || months.length !== 0){
                loadPieCharts(m,months); // pie chart draw trigger
                loadColumnCharts(m,months); // column chart draw trigger
            }
        }
    });

    // pie chert draw
    function loadPieCharts(m,months)
    {
        google.charts.load("current", {"packages":["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // all floor data push
            var data1 = google.visualization.arrayToDataTable([
                ["Sectors" , "Amount [Tk]"],
                ["Paid"    , m[0].gm_payment+m[0].fm_payment+m[0].sm_payment],
                ["Due"     , m[0].gm_due+m[0].sm_due+m[0].sm_due],
            ]);
            // all floor data push end

            // ground floor data push
            var data2 = google.visualization.arrayToDataTable([
                ["Sectors" , "Amount [Tk]"],
                ["Paid"    , m[0].gm_payment],
                ["Due"     , m[0].gm_due],
            ]);
            // ground floor data push end

            // 1st floor data push
            var data3 = google.visualization.arrayToDataTable([
                ["Sectors" , "Amount [Tk]"],
                ["Paid"    , m[0].fm_payment],
                ["Due"     , m[0].fm_due],
            ]);
            // 1st floor data push end

            // 2nd floor data push
            var data4 = google.visualization.arrayToDataTable([
                ["Sectors" , "Amount [Tk]"],
                ["Paid"    , m[0].sm_payment],
                ["Due"     , m[0].sm_due],
            ]);
            // 2nd floor data push end

            // all floor chart options
            var options1 = {
                title: "All Floors",
                titleTextStyle: {
                    color: "white",
                    fontSize: 16,
                },
                is3D: true,
                legend: "none",
                pieSliceText: "label",
                backgroundColor: "black",
            };
            // all floor chart options end

            // ground floor chart options
            var options2 = {
                title: "Ground Floor",
                titleTextStyle: {
                    color: "white",
                    fontSize: 16,
                },
                pieHole: 0.4,
                legend: "none",
                pieSliceText: "label",
                backgroundColor: "black",
            };
            // ground floor chart options end

            // 1st floor chart options
            var options3 = {
                title: "1st Floors",
                titleTextStyle: {
                    color: "white",
                    fontSize: 16,
                },
                pieHole: 0.4,
                legend: "none",
                pieSliceText: "label",
                backgroundColor: "black",
            };
            // 1st floor chart options end

            // 2nd floor chart options
            var options4 = {
                title: "2nd Floors",
                titleTextStyle: {
                    color: "white",
                    fontSize: 16,
                },
                pieHole: 0.4,
                legend: "none",
                pieSliceText: "label",
                backgroundColor: "black",
            };
            // 2nd floor chart options end

            // html element selection
            var chart1 = new google.visualization.PieChart(document.getElementById("piechart1"));
            var chart2 = new google.visualization.PieChart(document.getElementById("piechart2"));
            var chart3 = new google.visualization.PieChart(document.getElementById("piechart3"));
            var chart4 = new google.visualization.PieChart(document.getElementById("piechart4"));

            // chart draw with data & options
            chart1.draw(data1, options1);
            chart2.draw(data2, options2);
            chart3.draw(data3, options3);
            chart4.draw(data4, options4);
        }
    }
    // pie chert draw ends

    // column chart draw
    function loadColumnCharts(m,months)
    {
        google.charts.load("current", {"packages":["bar"]});
        google.charts.setOnLoadCallback(drawChart);

        let data = [];

        // chart header set up
        //1st colimn horizontal axis name
        //2nd - 4th multiple vertical column data
        data[0] = [
            ["Month", "Rent", "Paid", "Due"],
        ];
        data[1] = [
            ["Month", "Rent", "Paid", "Due"],
        ];
        data[2] = [
            ["Month", "Rent", "Paid", "Due"],
        ];

        // data[0][x] means ground floor all months
        // data[x][0] means any floor first month
        // first data index defines floor & 2nd data index defines months
        for(let x=0;x<months.length;x++){
            data[0].push(
                [months[x].name.split("-")[0]+"/"+months[x].name.split("-")[1],m[x].gm_rent,m[x].gm_payment,m[x].gm_due]
            );
            data[1].push(
                [months[x].name.split("-")[0]+"/"+months[x].name.split("-")[1],m[x].fm_rent,m[x].fm_payment,m[x].fm_due]
            );
            data[2].push(
                [months[x].name.split("-")[0]+"/"+months[x].name.split("-")[1],m[x].sm_rent,m[x].sm_payment,m[x].sm_due]
            );
        }

        function drawChart() {
            var data1 = google.visualization.arrayToDataTable(data[0]);
            var data2 = google.visualization.arrayToDataTable(data[1]);
            var data3 = google.visualization.arrayToDataTable(data[2]);

            // ground floor chart options
            var options1 = {
                chart: {
                    title: "Ground Floor Recent History",
                    subtitle: "Rent, Payments and Dues: "+months[months.length-1].name.split("-")[0]+"/"+months[months.length-1].name.split("-")[1]+"-"+months[0].name.split("-")[0]+"/"+months[0].name.split("-")[1],
                },
                backgroundColor: "black",
                chartArea: {
                    backgroundColor: "black",
                },
                animation: {
                    duration: 1,
                    easing: "inAndOut",
                    startup: true,
                },
                annotations:{
                    alwaysOutside: true,
                },
                legend: {
                    position: "none",
                },
                vAxis: {
                    title: "TK",
                },
                width: "100%",
            };
            // ground floor chart options ends

            // 1st floor chart options
            var options2 = {
                chart: {
                    title: "1st Floor Recent History",
                    subtitle: "Rent, Payments and Dues: "+months[months.length-1].name.split("-")[0]+"/"+months[months.length-1].name.split("-")[1]+"-"+months[0].name.split("-")[0]+"/"+months[0].name.split("-")[1],
                },
                backgroundColor: "black",
                chartArea: {
                    backgroundColor: "black",
                },
                animation: {
                    duration: 1,
                    easing: "inAndOut",
                    startup: true,
                },
                annotations:{
                    alwaysOutside: true,
                },
                legend: {
                    position: "none",
                },
                vAxis: {
                    title: "TK",
                },
                width: "100%",
            };
            // 1st floor chart options ends

            // 2nd floor chart options
            var options3 = {
                chart: {
                    title: "2nd Floor Recent History",
                    subtitle: "Rent, Payments and Dues: "+months[months.length-1].name.split("-")[0]+"/"+months[months.length-1].name.split("-")[1]+"-"+months[0].name.split("-")[0]+"/"+months[0].name.split("-")[1],
                },
                backgroundColor: "black",
                chartArea: {
                    backgroundColor: "black",
                },
                animation: {
                    duration: 1,
                    easing: "inAndOut",
                    startup: true,
                },
                annotations:{
                    alwaysOutside: true,
                },
                legend: {
                    position: "none",
                },
                vAxis: {
                    title: "TK",
                },
                width: "100%",
            };
            // 2nd floor chart options ends

            // html element selection
            var chart1 = new google.charts.Bar(document.getElementById("columnchart1"));
            var chart2 = new google.charts.Bar(document.getElementById("columnchart2"));
            var chart3 = new google.charts.Bar(document.getElementById("columnchart3"));

            // column chart draw
            chart1.draw(data1, google.charts.Bar.convertOptions(options1));
            chart2.draw(data2, google.charts.Bar.convertOptions(options2));
            chart3.draw(data3, google.charts.Bar.convertOptions(options3));
        }
    }
    // column chart draw ends
}

$("#content_loader").on("submit","#home_rent_form",function(e){
    e.preventDefault();
    let url = $(this).attr("action");

    let ground_floor_rent = $("#ground_floor_rent").val();
    let first_floor_rent = $("#1st_floor_rent").val();
    let second_floor_rent = $("#2nd_floor_rent").val();

    $.ajax({
        url: url,
        type: "PUT",
        data: {
            ground_floor_rent: ground_floor_rent,
            first_floor_rent: first_floor_rent,
            second_floor_rent: second_floor_rent,
        },
        dataType: "json",
        success: function(response){
            //checking if validator fails
            if(response.status === "errors"){
                $.each(response.errors,function(key,value){
                    $("#home_"+key+"_error").text("["+value+"]");
                });
            }

            //checking if laravel / database fails
            else if(response.status === "exception"){
                toastr.error(response.message);
            }

            //checking other common error fails
            else if(response.status === "error"){
                toastr.error(response.message);
            }

            else{
                toastr.success(response.message);
            }
        }
    });
});

$("#content_loader").on("click","#home_rent_form_restore",function(){
    $.ajax({
        url: "/settings",
        type: "GET",
        dataType: "json",
        data: {
            from_ajax: "true",
        },
        success: function(response){
            let ground_floor_rent = $("#ground_floor_rent");
            let first_floor_rent = $("#1st_floor_rent");
            let second_floor_rent = $("#2nd_floor_rent");

            ground_floor_rent.val(response.settings[0].value);
            first_floor_rent.val(response.settings[0].value);
            second_floor_rent.val(response.settings[0].value);
        }
    });
});





