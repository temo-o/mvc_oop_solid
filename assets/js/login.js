$(document).on("submit", "#login_form", function(e) {

    e.preventDefault();

    var username = $("#username").val();
    var password = $("#password").val();
    var params = {
        module: "login",
        exec: "authenticate",
        username: username,
        password: password
    };

    ajax(params).done(function(data) {
        if (data.success) {
            location.href = "home";
        }
        console.log(data);
    });

});
$(document).on("click", "#logout", function(e) {

    e.preventDefault();

    var params = {
        module: "login",
        exec: "logout"
    };

    ajax(params).done(function(data) {
        console.log("Done");
        location.href = "login";
    });

});