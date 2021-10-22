<div class="row">
    <div class="col-12 mb-2 mt-2">
        <a class="btn btn-success cursor_pointer" id="add_user">Add User</a>
    </div>
</div>

<!-- USER PAGE MODALS - START -->

<div class="modal fade" id="add_user_modal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-top" style="min-width: 74vw;">				
        <div class="modal-content">					
            <div class="modal-header">						
                <h4 class="modal-title">Add User</h4>						
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>					
            </div>					
            <div class="modal-body" id="add_user_modal_body">												
                <div class="row">    
                    <div class="col-lg-12">
                        

                                <form role="form" class="parsley-examples" id="add_user_form" style="marign-bottom: 0px;">

                                    <div class="row mb-3">                
                                        <label for="first_name" class="col-sm-2 col-form-label">First Name: 
                                            <span class="text-danger">*</span>
                                        </label>                
                                        <div class="col-sm-4">
                                            <input type="text" name="first_name" required class="form-control reset" id="first_name" value="" placeholder="First Name" style="" />                
                                        </div>												                
                                        <label for="last_name" class="col-sm-2 col-form-label">Last Name: 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" name="last_name" required class="form-control reset" id="last_name" placeholder="Last Name" value="" />                
                                        </div>
                                    </div>

                                    <div class="row mb-3">                
                                        <label for="first_name" class="col-sm-2 col-form-label">Email: 
                                            <span class="text-danger">*</span>
                                        </label>                
                                        <div class="col-sm-4">
                                            <input type="email" name="email" required class="form-control reset" id="first_name" value="" placeholder="First Name" style="" />                
                                        </div>												                
                                        <label for="last_name" class="col-sm-2 col-form-label">Password: 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" name="password" required class="form-control reset" id="last_name" placeholder="Last Name" value="" />                
                                        </div>
                                    </div>

                                    <div class="row mb-3">                
                                        <label for="role_id" class="col-sm-2 col-form-label">Role: 
                                            <span class="text-danger">*</span>
                                        </label>                
                                        <div class="col-sm-4">
                                            <select id="role_dropdown" name="role_id">
                                                <option val="2"></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-0 mt-4">                
                                        <div class="col-sm-8 offset-md-4 offset-2" id="team_button_holder">
                                            <button type="button" class="btn btn-primary waves-effect waves-light save_user" id="save_user">Save</button>
                                            <button type="button" class="btn btn-success waves-effect waves-light save_user" id="save_user_new">Save & New</button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light" id="save_user_cancel">Cancel</button>                
                                        </div>            
                                    </div>

                                </form>
                         
                    </div> <!-- end col -->                        
                </div><!-- end row -->					
            </div>				
        </div><!-- /.modal-content -->			
    </div>
    <!-- /.modal-dialog -->		
</div>
<!-- /.modal -->

<!-- USER PAGE MODALS - FINISH -->

<table id="user_table" class="table table-striped table-bordered d-none" style="width:100%">
    <thead>
        <th>ID</th>
        <th>Email</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Options</th>
    </thead>
    <tbody>
        <!--<tr>
            <td>1</td>
            <td>email@email.email</td>
            <td>John</td>
            <td>Doe</td>
            <td>OPTION BUTTONS HERE</td>
        </tr>-->
    </tbody>
    <tfoot>
        <th>ID</th>
        <th>Email</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Options</th>
    </tfoot>
    
    
</table>

<script>

    $(document).ready(function(){
        get_users();
    });

    $("#add_user").click(function(){
        var self = $(this);
        roles_select2();
        $("#add_user_modal").modal("show");  
    });

    function get_users(){
        var get_users_params={
            module: "user",
            exec: "get_users"
        };
        ajax(get_users_params).done(function(data){

            var table = $("#user_table");
            var tbody = table.find("tbody");
            reInitDatatable(table);
            if(data.success){

                $(data.result).each(function(index, row){
                    tbody.append(
                        `
                            <tr>
                                <td>${row.id}</td>
                                <td>${row.email}</td>
                                <td>${row.first_name}</td>
                                <td>${row.last_name}</td>
                                <td>OPTIONS</td>
                            </td>
                        `
                    );
                });

                table.DataTable();
                table.removeClass("d-none");
            }

            $("#data").html(data);
            console.log(data);
        });
    }

    function roles_select2(){

        var get_roles_params={
            module: "roles",
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