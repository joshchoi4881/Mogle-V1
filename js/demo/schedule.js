var hours = 0;
var earnings = 0;
var color = "table-primary";
var button = "#firstPlatform";
$(function() {
    $("#hours").html(hours + " hours");
    $("#earnings").html("$" + earnings);
    $("#firstPlatform").click(function() {
        color = "table-primary";
        button = "#firstPlatform";
    });
    $("#secondPlatform").click(function() {
        color = "table-secondary";
        button = "#secondPlatform";
    });
    $("#thirdPlatform").click(function() {
        color = "table-success";
        button = "#thirdPlatform";
    });
    $("#fourthPlatform").click(function() {
        color = "table-danger";
        button = "#fourthPlatform";
    });
    $("#fifthPlatform").click(function() {
        color = "table-warning";
        button = "#fifthPlatform";
    });
    $("#sixthPlatform").click(function() {
        color = "table-info";
        button = "#sixthPlatform";
    });
    $(".cell").click(function() {
        var wage = 0;
        $(this).toggleClass("clicked");
        if($(this).hasClass("clicked")) {
            if($(button).text() == "Uber") {
                wage = 10.16;
            }
            else if($(button).text() == "Lyft") {
                wage = 10.16;
            }
            else if($(button).text() == "Uber Eats") {
                wage = 10;
            }
            else if($(button).text() == "DoorDash") {
                wage = 10;
            }
            else if($(button).text() == "Postmates") {
                wage = 10;
            }
            else if($(button).text() == "Grubhub") {
                wage = 12;
            }
            $(this).addClass(color);
            $(this).html($(button).text());
            $("#hours").html(++hours + " hours");
            earnings = earnings + wage;
            $("#earnings").html("$" + (earnings.toFixed(2)));
        } else {
            if($(this).text() == "Uber") {
                wage = 10.16;
            }
            else if($(this).text() == "Lyft") {
                wage = 10.16;
            }
            else if($(this).text() == "Uber Eats") {
                wage = 10;
            }
            else if($(this).text() == "DoorDash") {
                wage = 10;
            }
            else if($(this).text() == "Postmates") {
                wage = 10;
            }
            else if($(this).text() == "Grubhub") {
                wage = 12;
            }
            $(this).removeClass();
            $(this).addClass("cell");
            $(this).html("");
            $("#hours").html(--hours + " hours");
            earnings = earnings - wage;
            $("#earnings").html("$" + (earnings.toFixed(2)));
        }
    });
});