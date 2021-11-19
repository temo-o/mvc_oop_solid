<div class="row">
    <div class="col-12 mb-2 mt-2">
        <a class="btn btn-success cursor_pointer" id="add_restaurant">Add Restaurant</a>
    </div>
</div>

<!-- Restaurant PAGE MODALS - START -->

<div class="modal fade" id="add_restaurant_modal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-top" style="min-width: 74vw;">				
        <div class="modal-content">					
            <div class="modal-header">						
                <h4 class="modal-title">Add Restaurant</h4>						
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>					
            </div>					
            <div class="modal-body" id="add_restaurant_modal_body">												
                <div class="row">    
                    <div class="col-lg-12">
                        

                                <form role="form" class="parsley-examples" id="add_restaurant_form" style="marign-bottom: 0px;">

                                    <input type="hidden" name="module" value="restaurant" />
                                    <input type="hidden" name="exec" value="add_restaurant" />
                                    <input type="hidden" name="restaurant_id" value="" />

                                    <div class="row mb-3">                
                                        <label for="first_name" class="col-sm-2 col-form-label">Title:
                                            <span class="text-danger">*</span>
                                        </label>                
                                        <div class="col-sm-4">
                                            <input type="text" name="crud[title]" required class="form-control reset" value="" placeholder="Title" style="" />                
                                        </div>												                
                                    </div>

                                    <div class="row mb-0 mt-4">                
                                        <div class="col-sm-8 offset-md-4 offset-2">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                            <button type="submit" class="btn btn-success waves-effect waves-light">Save & New</button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light" >Cancel</button>                
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

<!-- Restaurant PAGE MODALS - FINISH -->

<table id="restaurant_table" class="table table-striped table-bordered d-none" style="width:100%">
    <thead>
        <th>ID</th>
        <th>Title</th>
        <th>restaurant_type_id</th>
        <th>bid</th>
        <th>Visits</th>
        <th>Options</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <th>ID</th>
        <th>Title</th>
        <th>restaurant_type_id</th>
        <th>bid</th>
        <th>Visits</th>
        <th>Options</th>
    </tfoot>
    
    
</table>

<script>

    var module_name = "restaurant";

    $(document).ready(function(){
        get_restaurants();
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

    function get_restaurants(){
        var get_restaurants_params={
            module: module_name,
            exec: ("get_"+module_name)
        };
        ajax(get_restaurants_params).done(function(data){

            var table = $("#"+module_name+"_table");
            var tbody = table.find("tbody");
            reInitDatatable(table);
            if(data.success){

                $(data.result).each(function(index, row){
                    tbody.append(
                        `
                            <tr>
                                <td>${row.id}</td>
                                <td>${row.title}</td>
                                <td>${row.restaurant_type_id}</td>
                                <td>${row.bid}</td>
                                <td>${row.visit_cnt}</td>
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