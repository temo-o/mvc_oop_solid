Users View

<button id="get_users">Get Users</button>
<div id="data"></div>

<script>
    $("#get_users").click(function(){
        var self = $(this);
        self.css("color","red");
        console.log("Get Users Clicked");
        var get_users_params={
            module: "user",
            exec: "get_users"
        };
        ajax(get_users_params).done(function(data){
            $("#data").html(data);
            console.log(data);
        });
        
    });
</script>