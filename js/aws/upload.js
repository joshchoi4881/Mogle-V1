let files = null;
const screenshots = document.getElementById("screenshots");
screenshots.addEventListener("change", (event) => {
    files = event.target.files;
    if(files !== null) {
        multipleFileUploadHandler();
    } else {
        $("#response1").html("Please select screenshots to upload!");
    }
});
const extractButton = document.getElementById("extract");
extractButton.addEventListener("click", (event) => {
    if(files !== null) {
        extract(files);
    } else {
        $("#response2").html("There was an error in processing your screenshots.");
    }
});
async function multipleFileUploadHandler() {
    const data = new FormData();
    // If file selected
    if(files) {
        for(let i = 0; i < files.length; i++) {
            data.append("screenshots", files[i], files[i].name);
        }
        const instance = axios.create({
            baseURL: "http://localhost:8000"
        });
        instance.post("/upload_screenshots", data, {
            headers: {
                "accept": "application/json",
                "Accept-Language": "en-US,en;q=0.8",
                "Content-Type": `multipart/form-data; boundary=${data._boundary}`,
            }
        }).then((response) => {
                console.log("Response: ", response);
                if(200 === response.status) {
                    // If file size is larger than expected.
                    if(response.data.error) {
                        if("LIMIT_FILE_SIZE" === response.data.error.code) {
                            console.log("Max size: 50MB");
                            $("#response1").html("Max size: 50MB");
                            $("#screenshots").val("");
                        } else if("LIMIT_UNEXPECTED_FILE" === response.data.error.code) {
                            console.log("Max 50 images allowed");
                            $("#response1").html("Max 50 images allowed. Please try again with less than 50 images.");
                            $("#screenshots").val("");
                        } else {
                            // If not the given file type
                            console.log(response.data.error);
                        }
                    } else {
                        // Success
                        let fileName = response.data;
                        for(let i = 0; i < files.length; i++) {
                            files[i].s3name = fileName["filesArray"][i]["key"];
                            console.log(files[i].s3name);
                        }
                        console.log("File Name: ", fileName);
                        console.log("File Uploaded");
                        $("#response1").html("Now extract the data from the screenshots!");
                        $("#extract").show();
                    }
                }
            }).catch((error) => {
            // If another error
            console.log(error);
        });
    } else {
        // If file not selected, throw error
        console.log("Please upload file");
    }
};
function extract() {
    for(let i = 0; i < files.length; i++) {
        console.log(files[i].s3name);
        console.log(i);
        axios({
            method: "POST",
            baseURL: "https://t8gb9ldru9.execute-api.us-east-1.amazonaws.com/Mogle-API-Beta",
            url: "/",
            data: {
                file: files[i].s3name
            },
            headers: {
                "accept": "application/json"
            }
        }).then((response) => {
                console.log("Response: ", response);
                if(200 === response.status) {
                    // If file size is larger than expected.
                    if(response.data.error) {
                        if("LIMIT_FILE_SIZE" === response.data.error.code) {
                            console.log("Max size: 50MB");
                        } else if("LIMIT_UNEXPECTED_FILE" === response.data.error.code) {
                            console.log("Max 50 images allowed");
                        } else {
                            // If not the given file type
                            console.log(response.data.error);
                        }
                    } else {
                        // Success
                        let data = response.data;
                        console.log("Data: ", data);
                        console.log("Data Extracted");
                        const points = data.body;
                        let string = "";
                        let platform = data.body[0][0];
                        if(platform == "Uber") {
                            string += "<label>Platform:<br/><input id='platform" + i + "' type='text' value='" + platform + "' readonly></label>";
                            string += "<label>*Location:<br/><input id='location" + i + "' type='text' required></label>";
                            string += "<h5>Data:</h5>"
                            for(let j = 0; j < points.length; j++) {
                                string += "<label>Data Point " + (j + 1) + ":<br/><input class='datetime" + i + "' type='text' value='" + points[j][1] + "' readonly>";
                                string += "<input class='earnings" + i + "' type='text' value='" + points[j][2] + "' readonly></label></br>";
                            }
                            string += "<button onclick='uploadData(" + i + ")'>Looks Good!</button>";
                            $("<div id='form" + i + "' class='card'><h4>" + files[i].name + "</h4>" + string + "</div>").insertBefore("#forms");
                        } else if(platform == "DoorDash") {
                            string += "<label>Platform:<br/><input id='platform" + i + "' type='text' value='" + platform + "' readonly></label>";
                            total_earnings = data.body[0][1];
                            start_datetime = data.body[0][2];
                            end_datetime = data.body[0][3];
                            active_time = data.body[0][4];
                            dash_time = data.body[0][5];
                            deliveries = data.body[0][6];
                            string += "<label>Total Earnings:<br/><input id='total_earnings" + i + "' type='text' value='" + total_earnings + "' readonly></label>";
                            string += "<label>Start Datetime:<br/><input id='start_datetime" + i + "' type='text' value='" + start_datetime + "' readonly></label>";
                            string += "<label>End Datetime:<br/><input id='end_datetime" + i + "' type='text' value='" + end_datetime + "' readonly></label>";
                            string += "<label>Active Time:<br/><input id='active_time" + i + "' type='text' value='" + active_time + "' readonly></label>";
                            string += "<label>Dash Time:<br/><input id='dash_time" + i + "' type='text' value='" + dash_time + "' readonly></label>";
                            string += "<label>Deliveries:<br/><input id='deliveries" + i + "' type='text' value='" + deliveries + "' readonly></label>";
                            string += "<br/><button onclick='discardData(" + i + ")'>Discard</button>";
                            string += "<br/><button onclick='uploadData(" + i + ")'>Looks Good!</button>";
                            string += "<br/><p id='responseText" + i + "'></p>";
                            $("<div id='form" + i + "' class='card'><h4>" + files[i].name + "</h4>" + string + "</div>").insertBefore("#forms");
                        }
                    }
                }
            }).catch((error) => {
            // If another error
            console.log(error);
        });
    }
    $("#response2").html("Data successfully extracted! Please fill out the remaining fields as accurately as possible and ensure that the following information is correct!");
    $(".city").show();
    $(".state").show();
};
function discardData(id) {
    $("#form" + id).hide();
}
function uploadData(id) {
    console.log(id);
    const platform = $("#platform" + id).val();
    const city = $("#cityInput").val();
    const state = $("#stateInput").val();
    const location = city + ";" + state;
    console.log("Location: " + location);
    if(city != "" && state != "") {
        if(platform == "DoorDash") {
            const total_earnings = $("#total_earnings" + id).val();
            const start_datetime = $("#start_datetime" + id).val();
            const end_datetime = $("#end_datetime" + id).val();
            const active_time = $("#active_time" + id).val();
            const dash_time = $("#dash_time" + id).val();
            const deliveries = $("#deliveries" + id).val();
            console.log(platform, location, total_earnings, start_datetime, end_datetime, active_time, dash_time, deliveries);
            axios({
                method: "POST",
                baseURL: "http://localhost:8000",
                url: "/upload_data",
                data: {
                    platform: platform,
                    location: location,
                    total_earnings: total_earnings,
                    start_datetime: start_datetime,
                    end_datetime: end_datetime,
                    active_time: active_time,
                    dash_time: dash_time,
                    deliveries: deliveries
                },
                headers: {
                    "accept": "application/json"
                }
            }).then((response) => {
                console.log("Response: ", response);
                if(200 === response.status) {
                    console.log(response.data);
                    $("#form" + id).hide();
                } else {
                    console.log(response.error);
                }
            });
        }
    } else {
        $("#responseText" + id).html("Please fill out all required fields before submitting");
    }
}