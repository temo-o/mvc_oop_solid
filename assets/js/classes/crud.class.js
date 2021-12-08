class Crud{

	constructor(module_params){
		this.module_params = module_params;
		this.ajax_params = {
			crud_type: "insert",
			crud_fields: {}
		};
		this.module_name = this.get_module_name();
		this.classes_included = [];
		console.log("Constructing crud obj");
		if(!(typeof this.module_name == "string" && this.module_name.length>0)){
			console.log("Invalid Module Name");
			this.form = false;
			return false;
		}

		this.ajax_params["module"] = this.module_name;

		this.form = $("form[data-crud_module='"+this.get_module_name()+"']");
		this.catch_form_submit_event();
		console.log("Crud obj construction finished");
	}

	get_module_name(){
		return this.module_params.module_name;
	}

	get_crud_fields(){
		if(!this.form) return false;
		this.ajax_params.crud_fields = {};
		//var form = $("form[data-crud_module='"+this.get_module_name()+"']");
		//var crud_inputs = form.find("[data-crud_params]");
		var crud_inputs = this.form.find("[data-crud_params]");
		var self = this;
		var crud_inputs = this.form.find("[data-crud_params]");
		var entry_id = this.form.find("[data-entry_id]").val();
		if(entry_id > 0){
			self.ajax_params.crud_type = "update";
			this.ajax_params["exec"] = "add_"+this.module_name;
			this.ajax_params.crud_fields["id"] = entry_id;
		}else{
			this.ajax_params["exec"] = "add_"+this.module_name;
		}
		for(var i = 0; i<crud_inputs.length; i++){
			let self = crud_inputs.eq(i);
			let crud_params = self.data("crud_params");
			let crud_field = {};
			
			let fn = window[crud_params.function];
			if(typeof(fn) === "function"){
				//crud_field[crud_params.table_column] = fn(self.val());
				this.ajax_params.crud_fields[crud_params.table_column] = fn(self.val());
			}else{
				//crud_field[crud_params.table_column] = self.val();
				this.ajax_params.crud_fields[crud_params.table_column] = self.val();
			}

			//this.ajax_params.crud_fields.push(crud_field);

		}

		//console.log(this.ajax_params);
		return this.ajax_params;
	}

	catch_form_submit_event(){
		console.log("catch_form_submit_event");
		let self = this;
		console.log(self.form);
		self.form.submit(function(e){
			e.preventDefault();
			$.LoadingOverlay("show");
			console.log("Form submittion");
			// Get fields on submit
			self.get_crud_fields();
			console.log(self.ajax_params);
			ajax(self.ajax_params).done(function(data){
				self.close_form_modal();
				toast({
					msg: data.msg,
					success: data.success
				});

				$.LoadingOverlay("hide");
			});
			console.log("Form Submitted");
		});
	}

	close_form_modal(){
		let activeElement = $(document.activeElement);
		if(activeElement != "undefined"){
			if(!(activeElement.attr("id").includes("new"))){
				this.form.closest(".modal").modal("hide");
			}
		}
	}

}