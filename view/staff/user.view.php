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
                <h4 class="modal-title" data-wenk="ADd User" data-wenk-pos="bottom">Add User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>					
            <div class="modal-body" id="add_user_modal_body">												
                <div class="row">    
                    <div class="col-lg-12">

                        <form role="form" class="parsley-examples" id="add_user_form" data-crud_module="user" style="marign-bottom: 0px;">

                            <input type="hidden" name="entry_id" data-entry_id="-2" />

                            <div class="row mb-3">                
                                <label for="first_name" class="col-sm-2 col-form-label">First Name: 
                                    <span class="text-danger">*</span>
                                </label>                
                                <div class="col-sm-4">
                                    <input 
                                        type="text"
                                        id="first_name"
                                        class="form-control reset" 
                                        name="crud[first_name]"
                                        value="" 
                                        placeholder="First Name" 
                                        data-crud_params='{"table_column": "first_name","function": "UCFirst"}' 
                                        required 
                                    />                
                                </div>												                
                                <label for="last_name" class="col-sm-2 col-form-label">Last Name: 
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-4">
                                    <input 
                                        type="text" 
                                        id="last_name" 
                                        class="form-control reset" 
                                        name="crud[last_name]"
                                        value="" 
                                        placeholder="Last Name"
                                        data-crud_params='{"table_column": "last_name","function": "UCFirst"}'
                                        required 
                                    />                
                                </div>
                            </div>

                            <div class="row mb-3">                
                                <label for="first_name" class="col-sm-2 col-form-label">Email: 
                                    <span class="text-danger">*</span>
                                </label>                
                                <div class="col-sm-4">
                                    <input 
                                        type="email" 
                                        id="first_name" 
                                        class="form-control reset" 
                                        name="crud[email]" 
                                        value="" 
                                        placeholder="Email" 
                                        data-crud_params='{"table_column": "email","function": "Validate/validateEmail"}'
                                        required 
                                    />                
                                </div>												                
                                <label for="last_name" class="col-sm-2 col-form-label">Password: 
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" name="crud[password]" class="form-control reset" id="last_name" placeholder="*****" value="" />                
                                </div>
                            </div>

                            <div class="row mb-3">                
                                <label for="role_id" class="col-sm-2 col-form-label">Role: 
                                    <span class="text-danger">*</span>
                                </label>                
                                <div class="col-sm-4">
                                    <select 
                                        id="role_dropdown" 
                                        name="crud[role_id]"
                                        data-crud_params='{"table_column": "role_id","function": "parseInt"}'
                                    >
                                        <option val="2"></option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-0 mt-4">                
                                <div class="col-sm-8 offset-md-4 offset-2" id="team_button_holder">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light save_user" id="save_user">Save</button>
                                    <button type="submit" class="btn btn-success waves-effect waves-light save_user" id="save_user_new">Save & New</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light reset_btn" data-modal="add_user_modal">Cancel</button>       
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

<table id="user_table" class="table table-striped table-bordered" style="width:100%">
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
    var datatable_instance;
    /*var crud_obj = new Crud({
        module_name: "user"
    });*/

    $(document).ready(function(){
        //crud_obj.catch_form_submit_event();
        get_users();

        //console.log(crud_obj.get_module_name());

    });

    $("#add_user_form").submit(function(e){
        e.preventDefault();
        $("#add_user_form").tcrud({
            module_name: "user",
            modal:true,
            clear_inputs:true
        }).get_crud_fields().exec();
        //$("#add_user_form").tcrud("user").exec();
    });

    $("#add_user").click(function(){
        var self = $(this);
        roles_select2();
        $("#save_user_new").css("display","inline-block");
        $("#add_user_modal").modal("show");
    });

    function get_users1(){
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
                                <td class="options_td">
                                    <a 
                                        class="edit_user option_button"
                                        data-id="${row.id}"
                                        data-wenk="Edit"
                                        data-wenk-pos="bottom"
                                    >
                                        ${base_fonts.edit}
                                    </a>
                                </td>
                            </td>
                        `
                    );
                });

                table.DataTable({
                    "bSort" : false
                });
                table.removeClass("d-none");
            }

            $("#data").html(data);
            console.log(data);
        });
    }

    function get_users(){

        var table = $("#user_table");
        //table.DataTable().clear().destroy();

        // Data into this datatable is retreived using server side processing.
        datatable_instance = table.DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "?module=user&exec=get_users_ssp",
                "type": "POST",
                "data":{
                    module: "user",
                    exec: "get_users_ssp"
                }
            },
            sDom: 'r<"H"lf><"datatable-scroll"t><"F"ip>',
            bSort : false,
            order : [],
            "searching": true,
            columns: [
                { 
                    // ID
                    "searchable": true,
                    render: function ( data, type, row ) 
                    {   
                        return row.id;
                    }
                },
                { 
                    // Email
                    "searchable": true,
                    render: function ( data, type, row ) 
                    {   
                        return row.email;
                    }
                },
                { 
                    // First Name
                    "searchable": true,
                    render: function ( data, type, row ) 
                    {   
                        return row.first_name;
                    }
                },
                { 
                    // Last Name
                    "searchable": true,
                    render: function ( data, type, row ) 
                    {   
                        return row.last_name;
                    }
                },
                { 
                    // Options
                    render: function ( data, type, row ) 
                    {   

                        var options = 
                        `<a 
                            type="button"
                            data-target="new_bank" 
                            data-head="Update Bank" 
                            class="btn btn-sm btn-img waves-light edit_bank"
                            data-id="${row.id}"
                        >
                            <img src="" />
                        </a>
                        <a 
                            type="button"
                            href="#"
                            data-target="confirm"
                            data-head="Are you sure you want to remove bank?"
                            class="btn btn-sm btn-img waves-effect waves-light open_modal"
                            data-bank_id="${row.id}"
                        >
                            <img src="" />
                        </a>`;
                        return options;
                    }
                }
                
            ]
        });

        /*datatable_instance.on( 'xhr', function () {
            var json = datatable_instance.ajax.json();
            
            if(json == undefined || json == "undefined"){
                return 0;
            }

            if(json.hasOwnProperty("data")){
                if(json.data.hasOwnProperty("length")){
            
                    var data_length = json.data.length;
                    var current_page = datatable_instance.page();
                    if(current_page > 0 && data_length == 0){
                        $("#banks-tbl").DataTable().page(0).draw("page");
                    }

                }

            }

        });*/
        
        $.LoadingOverlay("hide");

    }

    $(document).on("click", ".edit_user", function(){
        var self = $(this);
        $("#add_user_form").find("input[name='entry_id']").val(self.data("id"));
        get_user_details();
        $("#save_user_new").css("display","none");
        $("#add_user_modal").modal("show");
    });

    function get_user_details(){

        var get_user_details_params={
            id: $("#add_user_form").find("input[name='entry_id']").val(),
            module: "user",
            exec: "get_user_details"
        };
        ajax(get_user_details_params).done(function(data){

            

            var form = $("#add_user_form");

            form.find("input[name='crud[first_name]']").val(data.first_name);
            form.find("input[name='crud[last_name]']").val(data.last_name);
            form.find("input[name='crud[email]']").val(data.email);
            form.find("input[name='crud[password]']").val('');
            //form.find("select[name='crud[role_id]']").val(data.role_id).trigger("change.select2");
            roles_select2(data.role_id);
            
        });

    }

    function roles_select2(role_id = -1){

        var select2 = $("#role_dropdown");

        if (select2.hasClass("select2-hidden-accessible")) {
            // Select2 has been initialized
        }

        var get_roles_params={
            module: "roles",
            exec: "get_roles"
        };

        ajax(get_roles_params).done(function(data){

            if(data.success){

                select2.empty();
                $(data.result).each(function(index, row){
                   select2.append(`<option value="${row['id']}">${row["title"]}</option>`);
                });
                select2.select2({
                    width: "100%",
                    dropdownParent: select2.parent(),
                    placeholder: "Please Select"
                });
                select2.val(role_id).trigger("change.select2");

            }

            $("#data").html(data);
            console.log(data);
        });
    }

</script>