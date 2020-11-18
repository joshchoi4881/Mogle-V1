function saveEmail() {
    const input = $("#emailNewsletter").val();
    console.log(input);
    $.ajax({
        url: "/mogle/AJAX/newsletter.php",
        method: "POST",
        data: { email: input },
        timeout: 0,
        success: (data) => {
            console.log("DATA: " + data);
            $("#response").html(data);
        },
        error: (xhr, status, error) => {
            console.log(xhr.responseText);
            $("#response").html(xhr.responseText);
        },
    });
}