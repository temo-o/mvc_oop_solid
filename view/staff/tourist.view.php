<div class="row">
    <div class="col-12 mb-2 mt-2">
        <a class="btn btn-success cursor_pointer" id="add_tourist">Add Tourist</a>
    </div>
</div>

<!-- Tourist PAGE MODALS - START -->

<div class="modal fade" id="add_tourist_modal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-top" style="min-width: 74vw;">				
        <div class="modal-content">					
            <div class="modal-header">						
                <h4 class="modal-title">Add Tourist</h4>						
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>					
            </div>					
            <div class="modal-body" id="add_tourist_modal_body">												
                <div class="row">    
                    <div class="col-lg-12">
                        

                                <form role="form" class="parsley-examples" id="add_tourist_form" style="marign-bottom: 0px;">

                                    <input type="hidden" name="module" value="tourist" />
                                    <input type="hidden" name="exec" value="add_tourist" />
                                    <input type="hidden" name="tourist_id" value="" />

                                    <div class="row mb-3">                
                                        <label for="first_name" class="col-sm-2 col-form-label">First Name: 
                                            <span class="text-danger">*</span>
                                        </label>                
                                        <div class="col-sm-4">
                                            <input type="text" name="crud[first_name]" required class="form-control reset" id="first_name" value="" placeholder="First Name" style="" />                
                                        </div>												                
                                        <label for="last_name" class="col-sm-2 col-form-label">Last Name: 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" name="crud[last_name]" class="form-control reset" id="last_name" placeholder="Last Name" value="" />                
                                        </div>
                                    </div>

                                    <div class="row mb-3">                
                                        <label for="email" class="col-sm-2 col-form-label">Email: 
                                            <span class="text-danger">*</span>
                                        </label>                
                                        <div class="col-sm-4">
                                            <input type="email" name="crud[email]" class="form-control reset" id="email" value="" placeholder="Email" style="" />                
                                        </div>												                
                                        <label for="password" class="col-sm-2 col-form-label">Password: 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" name="crud[password]" class="form-control reset" id="password" placeholder="Password" value="" />                
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                                       
                                        <label for="mobile" class="col-sm-2 col-form-label">Mobile: 
                                            <span class="text-danger">*</span>
                                        </label>                
                                        <div class="col-sm-4">
                                            <input type="text" name="crud[mobile]" class="form-control reset" id="mobile" value="" placeholder="Mobile" style="" />                
                                        </div>	            
                                        <label for="role_id" class="col-sm-2 col-form-label">Role: 
                                            <span class="text-danger">*</span>
                                        </label>                
                                        <div class="col-sm-4">
                                            <select id="role_dropdown" name="crud[role_id]">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-0 mt-4">                
                                        <div class="col-sm-8 offset-md-4 offset-2" id="team_button_holder">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light save_tourist" id="save_tourist">Save</button>
                                            <button type="submit" class="btn btn-success waves-effect waves-light save_tourist" id="save_tourist_new">Save & New</button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light" id="save_tourist_cancel">Cancel</button>                
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

<!-- Tourist PAGE MODALS - FINISH -->

<table id="tourist_table" class="table table-striped table-bordered d-none" style="width:100%">
    <thead>
        <th>ID</th>
        <th>Email</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Options</th>
    </thead>
    <tbody>
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

    var module_name = "tourist";

    $(document).ready(function(){
        get_tourists();
    });

    $("#add_tourist").click(function(){
        var self = $(this);
        roles_select2();
        $("#add_tourist_modal").modal("show");  
    });

    $("#add_tourist_form").submit(function(e){

        e.preventDefault();

        var form = $(this);
        var fd = form.serialize();

        console.log(fd);

        ajax(fd).done(function(data){

            console.log(data);

        });

    });

    function get_tourists(){
        var get_tourists_params={
            module: module_name,
            exec: "get_tourists"
        };
        ajax(get_tourists_params).done(function(data){

            var table = $("#tourist_table");
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