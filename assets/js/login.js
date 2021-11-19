$(document).on("submit", "#login_form", function(e) {

    e.preventDefault();

    var self = $(this);

    var username = $("#username").val();
    var password = $("#password").val();

    var checked_user_type_elem = self.find("input[name='user_type']:checked");
    var selected_user_type;
    if(checked_user_type_elem !== false){
        selected_user_type = self.find("input[name='user_type']:checked").val();
    }
    else{
        console.log("No user type checked");
        return 0;
    }
    
    var params = {
        module: "login",
        exec: "authenticate_"+selected_user_type,
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