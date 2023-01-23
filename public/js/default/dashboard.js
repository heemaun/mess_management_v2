// dashboard();
function dashboard()
{
    $.ajax({
        url: "/members-months",
        type: "GET",
        dataType: "json",
        success: function(response){
            let m = response.m;
            let months = response.months;

            loadPieCharts(m,months);
            loadColumnCharts(m,months);
        }
    });

    function loadPieCharts(m,months)
    {
        google.charts.load("current", {"packages":["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data1 = google.visualization.arrayToDataTable([
                ["Sectors" , "Amount [Tk]"],
                ["Paid"    , m[0].gm_payment+m[0].fm_payment+m[0].sm_payment],
                ["Due"     , m[0].gm_due+m[0].sm_due+m[0].sm_due],
            ]);

            var data2 = google.visualization.arrayToDataTable([
                ["Sectors" , "Amount [Tk]"],
                ["Paid"    , m[0].gm_payment],
                ["Due"     , m[0].gm_due],
            ]);

            var data3 = google.visualization.arrayToDataTable([
                ["Sectors" , "Amount [Tk]"],
                ["Paid"    , m[0].fm_payment],
                ["Due"     , m[0].fm_due],
            ]);

            var data4 = google.visualization.arrayToDataTable([
                ["Sectors" , "Amount [Tk]"],
                ["Paid"    , m[0].sm_payment],
                ["Due"     , m[0].sm_due],
            ]);

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

            var chart1 = new google.visualization.PieChart(document.getElementById("piechart1"));
            var chart2 = new google.visualization.PieChart(document.getElementById("piechart2"));
            var chart3 = new google.visualization.PieChart(document.getElementById("piechart3"));
            var chart4 = new google.visualization.PieChart(document.getElementById("piechart4"));

            chart1.draw(data1, options1);
            chart2.draw(data2, options2);
            chart3.draw(data3, options3);
            chart4.draw(data4, options4);
        }
    }

    function loadColumnCharts(m,months)
    {
        google.charts.load("current", {"packages":["bar"]});
        google.charts.setOnLoadCallback(drawChart);

        let data = [];

        data[0] = [
            ["Month", "Rent", "Paid", "Due"],
        ];
        data[1] = [
            ["Month", "Rent", "Paid", "Due"],
        ];
        data[2] = [
            ["Month", "Rent", "Paid", "Due"],
        ];

        for(let x=0;x<m.length;x++){
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

            var chart1 = new google.charts.Bar(document.getElementById("columnchart1"));
            var chart2 = new google.charts.Bar(document.getElementById("columnchart2"));
            var chart3 = new google.charts.Bar(document.getElementById("columnchart3"));

            chart1.draw(data1, google.charts.Bar.convertOptions(options1));
            chart2.draw(data2, google.charts.Bar.convertOptions(options2));
            chart3.draw(data3, google.charts.Bar.convertOptions(options3));
        }
    }
}






