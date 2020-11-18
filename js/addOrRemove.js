/* Add/remove button animation change */
$(function() {
    $(".btn").click(function() {
        var gig = $(this).attr("id");
        $("." + gig).toggleClass("btn-primary");
        $("." + gig).toggleClass("btn-danger");
        if($("." + gig).hasClass("btn-primary")) {
            $("." + gig).html("Add");
        } else {
            $("." + gig).html("Remove");
        }
    });
  });
  /* Adds or removes gig
  userId is the id of the user and gig is the name of the gig */
  function addOrRemove(userId, gig) {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            if(this.responseText == "Added") {
                if($("#yourGigs ." + gig).length) {
                } else {
                    $("#yourGigs").append("<div class='gigDiv'><p>" + gig + "</p><button class='btn btn-danger " + gig + "' onclick=\"addOrRemove(" + userId + ", '" + gig + "')\">Remove</button></div><br/>");
                    $("#yourGigs ." + gig).click(function() {
                        $("." + gig).toggleClass("btn-primary");
                        $("." + gig).toggleClass("btn-danger");
                        if($("." + gig).hasClass("btn-primary")) {
                            $("." + gig).html("Add");
                        } else {
                            $("." + gig).html("Remove");
                        }
                    });
                }
            }
        }
    };
    xhttp.open("GET", "AJAX/addOrRemove.php?userId=" + userId + "&gig=" + gig, true);
    xhttp.send();
  }