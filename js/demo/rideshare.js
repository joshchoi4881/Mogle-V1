$(document).ready(function() {
    $.ajax({
    url: "/mogle/graphs/data.php",
    type: "GET",
    success: function(data) {
        var hourManhattanNewYork = [];
        var uberManhattanNewYork = [];
        var lyftManhattanNewYork = [];
        var hourPrincetonNewJersey = [];
        var uberPrincetonNewJersey = [];
        var lyftPrincetonNewJersey = [];
        var hourPhiladelphiaPennsylvania = [];
        var uberPhiladelphiaPennsylvania = [];
        var lyftPhiladelphiaPennsylvania = [];
        for (var i in data[0]) {
        hourManhattanNewYork.push(
            data[0][i].dayOfWeek + ", " + data[0][i].hour + ":00"
        );
        uberManhattanNewYork.push(data[0][i].average);
        lyftManhattanNewYork.push(data[1][i].average);
        }
        for (var i in data[2]) {
        hourPrincetonNewJersey.push(
            data[2][i].dayOfWeek + ", " + data[2][i].hour + ":00"
        );
        uberPrincetonNewJersey.push(data[2][i].average);
        lyftPrincetonNewJersey.push(data[3][i].average);
        }
        for (var i in data[4]) {
        hourPhiladelphiaPennsylvania.push(
            data[4][i].dayOfWeek + ", " + data[4][i].hour + ":00"
        );
        uberPhiladelphiaPennsylvania.push(data[4][i].average);
        lyftPhiladelphiaPennsylvania.push(data[5][i].average);
        }
        var chartManhattanNewYork = {
        labels: hourManhattanNewYork,
        datasets: [
            {
            label: "Uber, Manhattan",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(59, 89, 152, 0.75)",
            borderColor: "rgba(59, 89, 152, 1)",
            pointHoverBackgroundColor: "rgba(59, 89, 152, 0.75)",
            pointHoverBorderColor: "rgba(59, 89, 152, 1)",
            data: uberManhattanNewYork
            },
            {
            label: "Lyft, Manhattan",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(29, 202, 255, 0.75)",
            borderColor: "rgba(29, 202, 255, 1)",
            pointHoverBackgroundColor: "rgba(29, 202, 255, 0.75)",
            pointHoverBorderColor: "rgba(29, 202, 255, 1)",
            data: lyftManhattanNewYork
            }
        ]
        };
        var chartPrincetonNewJersey = {
        labels: hourPrincetonNewJersey,
        datasets: [
            {
            label: "Uber, Princeton",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(110, 44, 0, 0.75)",
            borderColor: "rgba(110, 44, 0, 1)",
            pointHoverBackgroundColor: "rgba(110, 44, 0, 0.75)",
            pointHoverBorderColor: "rgba(110, 44, 0, 1)",
            data: uberPrincetonNewJersey
            },
            {
            label: "Lyft, Princeton",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(237, 187, 153, 0.75)",
            borderColor: "rgba(237, 187, 153, 1)",
            pointHoverBackgroundColor: "rgba(237, 187, 153, 0.75)",
            pointHoverBorderColor: "rgba(237, 187, 153, 1)",
            data: lyftPrincetonNewJersey
            }
        ]
        };
        var chartPhiladelphiaPennsylvania = {
        labels: hourPhiladelphiaPennsylvania,
        datasets: [
            {
            label: "Uber, Philadelphia",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(20, 90, 50, 0.75)",
            borderColor: "rgba(20, 90, 50, 1)",
            pointHoverBackgroundColor: "rgba(20, 90, 50, 0.75)",
            pointHoverBorderColor: "rgba(20, 90, 50, 1)",
            data: uberPhiladelphiaPennsylvania
            },
            {
            label: "Lyft, Philadelphia",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(169, 223, 191, 0.75)",
            borderColor: "rgba(169, 223, 191, 1)",
            pointHoverBackgroundColor: "rgba(169, 223, 191, 0.75)",
            pointHoverBorderColor: "rgba(169, 223, 191, 1)",
            data: lyftPhiladelphiaPennsylvania
            }
        ]
        };
        var manhattanNewYork = $("#manhattanNewYork");
        var princetonNewJersey = $("#princetonNewJersey");
        var philadelphiaPennsylvania = $("#philadelphiaPennsylvania");
        var graphManhattanNewYork = new Chart(manhattanNewYork, {
        type: "line",
        data: chartManhattanNewYork
        });
        var graphPrincetonNewJersey = new Chart(princetonNewJersey, {
        type: "line",
        data: chartPrincetonNewJersey
        });
        var graphPhiladelphiaPennsylvania = new Chart(
        philadelphiaPennsylvania,
        {
            type: "line",
            data: chartPhiladelphiaPennsylvania
        }
        );
        var chartCombined = {
            labels: hourManhattanNewYork,
            datasets: [
                {
                label: "Uber, Manhattan",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(59, 89, 152, 0.75)",
                borderColor: "rgba(59, 89, 152, 1)",
                pointHoverBackgroundColor: "rgba(59, 89, 152, 0.75)",
                pointHoverBorderColor: "rgba(59, 89, 152, 1)",
                data: uberManhattanNewYork
                },
                {
                label: "Lyft, Manhattan",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(29, 202, 255, 0.75)",
                borderColor: "rgba(29, 202, 255, 1)",
                pointHoverBackgroundColor: "rgba(29, 202, 255, 0.75)",
                pointHoverBorderColor: "rgba(29, 202, 255, 1)",
                data: lyftManhattanNewYork
                },
                {
                label: "Uber, Princeton",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(110, 44, 0, 0.75)",
                borderColor: "rgba(110, 44, 0, 1)",
                pointHoverBackgroundColor: "rgba(110, 44, 0, 0.75)",
                pointHoverBorderColor: "rgba(110, 44, 0, 1)",
                data: uberPrincetonNewJersey
                },
                {
                label: "Lyft, Princeton",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(237, 187, 153, 0.75)",
                borderColor: "rgba(237, 187, 153, 1)",
                pointHoverBackgroundColor: "rgba(237, 187, 153, 0.75)",
                pointHoverBorderColor: "rgba(237, 187, 153, 1)",
                data: lyftPrincetonNewJersey
                },
                {
                label: "Uber, Philadelphia",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(20, 90, 50, 0.75)",
                borderColor: "rgba(20, 90, 50, 1)",
                pointHoverBackgroundColor: "rgba(20, 90, 50, 0.75)",
                pointHoverBorderColor: "rgba(20, 90, 50, 1)",
                data: uberPhiladelphiaPennsylvania
                },
                {
                label: "Lyft, Philadelphia",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(169, 223, 191, 0.75)",
                borderColor: "rgba(169, 223, 191, 1)",
                pointHoverBackgroundColor: "rgba(169, 223, 191, 0.75)",
                pointHoverBorderColor: "rgba(169, 223, 191, 1)",
                data: lyftPhiladelphiaPennsylvania
                }
            ]
        };
        var combined = $("#combined");
        var graphCombined = new Chart(combined, {
            type: "line",
            data: chartCombined
        });
    },
    error: function(data) {
        console.log(data);
    }
    });
});
function find() {
    const input = $("#address").val();
    console.log(input);
    $("#status").text("Waiting");
    if($("#next").length) {
        $("#next").remove();
    }
    $.ajax({
        url: "/mogle/AJAX/HTTP/rideshare.php",
        method: "POST",
        data: { address: input },
        timeout: 0,
        success: (data) => {
            console.log("DATA: " + data);
            data = JSON.parse(data);
            $("#status").text("Success");
            $("#status").append("<p id='next'></p>");
            $("#result1").text(data.uber);
            $("#result2").text(data.lyft);
        },
        error: (xhr, status, error) => {
            console.log(xhr.responseText);
            $("#status").text(xhr.responseText);
            $("#status").append("<p id='next'></p>");
            $("#result1").text("Error");
            $("#result2").text("Error");
        },
    });
}