<div class="row">
    <div class="col-12 mb-2 mt-2">
    
        <div class="row m-0 ml-2" id="restaurants_wrapper">
            

        </div>
    </div>
</div>

<script>

    var module_name = "restaurant";
    var base_folder;
    $(document).ready(function(){
        
        get_restaurants();
        base_folder = decodeURIComponent(readCookie("BASE_FOLDER"));
        if(base_folder == null || base_folder == "null"){
            base_folder = "";
        }
    });

    $("#add_"+module_name).click(function(){
        var self = $(this);
        roles_select2();
        $("#add_"+module_name+"_modal").modal("show");  
    });

    $("#add_"+module_name+"_form").submit(function(e){

        e.preventDefault();

        var form = $(this);
        var fd = form.serialize();

        console.log(fd);

        ajax(fd).done(function(data){

            console.log(data);

        });

    });


    $("#restaurants_wrapper").off().on("click",".restaurant_details", function(e){
        e.preventDefault();
        console.log("Clicked");
        var get_restaurants_params={
            module: module_name,
            exec: ("get_"+module_name+"_details"),
            id: $(this).data("id")
        };
        ajax(get_restaurants_params).done(function(data){

            if(data.hasOwnProperty("id")){
                
                var content = 
                `
                    <a onClick="get_restaurants()" style="display:block; width:100%; cursor:pointer; color:skyblue;">Back</a>
                    <h1 style="display:block; width:100%">${data.title}</h1>
                    <h4 style="display:block; width:100%">Bid: ${data.bid}</h4>
                    <h4 style="display:block; width:100%">restaurant_type_id: ${data.restaurant_type_id}</h4>
                
                `;

                $("#restaurants_wrapper").html(content);
            }

            console.log(data);
        });

        console.log("Need Restaurant Details");

    });


    function get_restaurants(){
        var get_restaurants_params={
            module: module_name,
            exec: ("get_"+module_name)
        };
        ajax(get_restaurants_params).done(function(data){

            if(data.success){
                var restaurants_wrapper = $("#restaurants_wrapper");
                restaurants_wrapper.html("");
                $(data.result).each(function(index, row){
                    restaurants_wrapper.append(
                        `
                        <div class="col-4 mr-2 mb-1">
                            <div class="row">
                                <div class="col-6 p-0" style="border:1px solid black;">
                                    <img src="${base_folder}/image?text=${row.title}&width=200&height=200" />
                                </div>
                                <div class="col-6" style="border:1px solid black;">

                                    <div class="row mb-4">
                                    </div>

                                    <div class="row">
                                        <span class="col-4">Title: </span>
                                        <span class="col-8 restaurant_details" data-id="${row.id}">${row.title}</span>
                                    </div>

                                    <div class="row">
                                        <span class="col-4">Bid: </span>
                                        <span class="col-8">${row.bid}</span>
                                    </div>

                                    <div class="row">
                                        <span class="col-4">Type: </span>
                                        <span class="col-8">${row.restaurant_type_id}</span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        `
                    );
                });

            }

            $("#data").html(data);
            console.log(data);
        });
    }

    function roles_select2(){

        var get_roles_params={
            module: 'roles',
            exec: "get_roles"
        };

        ajax(get_roles_params).done(function(data){
            
            if(data.success){

                var select2 = $("#role_dropdown");
                select2.empty();
                select2.append(`<option id="-1" disabled >Please select</option>`);
                $(data.result).each(function(index, row){
                   select2.append(`<option id="${row['id']}">${row["title"]}</option>`);
                });
                select2.select2({
                    width: "100%",
                    dropdownParent: select2.parent()
                });
                select2.val(-1).trigger("change.select2");

            }

            $("#data").html(data);
            console.log(data);
        });
    }

</script>