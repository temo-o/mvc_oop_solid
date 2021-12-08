var current_page = '';
var base_folder = decodeURIComponent(readCookie("BASE_FOLDER"));
var base_fonts = {
    edit: `<svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="currentColor" d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" /></svg>`
}
$(document).ready(function() {
    var sidebar_width = $(".sidebar").outerWidth();
    var header_height = $("#header_wrapper").outerHeight();
    $("#content").css("margin-left", sidebar_width);
    $("#content").css("margin-top", header_height);
    $("#content").css("width", $(window).width() - sidebar_width - 30 );
    initialize();
});

//$(".menu_item").click(function() {
$(document).on("click", ".menu_item", function(){
    var self = $(this);
    //console.log(self);
    var target_url = self.data("url");
    //current_page = get_current_page();
    
    if (target_url != current_page) {

        console.log(current_page, get_current_page());
        document.title = target_url;
        base_folder = decodeURIComponent(readCookie("BASE_FOLDER"));
        //console.log(typeof(base_folder));
        if(base_folder === null || base_folder === "null"){
            base_folder = "";
        }
        
        //console.log(base_folder+"/"+target_url);
        history.pushState(base_folder+"/"+target_url, target_url, base_folder+"/"+target_url);
        get_page_content(target_url);
        current_page = target_url;
        menu_item_color();
    }

    return false;
});

window.addEventListener('popstate', function(event) {
    // Log the state data to the console
    if (current_page != get_current_page()) {
        get_page_content(get_current_page());
        menu_item_color();
    }
});

window.addEventListener('pushstate', function(event) {
    // Log the state data to the console
    if (current_page != get_current_page()) {
        get_page_content(get_current_page());
        menu_item_color();
    }
});

function initialize() {

    //$(".breadcrumb-item").css("display","none");

    //breadcrumbs_array.push(get_current_page());
    //manage_breadcrumbs();
    current_page = get_current_page();
    get_page_content(current_page);
    document.title = current_page;
    construct_menu();

    //$(".menu_item span").css("color", "#6e768e");
    //$("#" + current_page + "_item span").css("color", "#00acc1");
    //console.log({current_page});
    //$(".menu_item").css("color", "#000");
    //$("#" + current_page + "_item").css("color", "#00acc1");
    //$(".menu_item[data-url='"+current_page+"']").css("color", "#00acc1");
    //self.css("color", "#00acc1");

    loadingOverlay(); // Set up loadingoverlay default settings

}

function change_content(contents) {
    $("#content").html(contents);
}

function get_page_content(page_url) {

    $.ajax({
        method: "POST",
        url: "page/" + page_url + ".php",
        data: {
            request_type: "ajax",
            module: "view",
            exec: "get_content",
            view: page_url

        }
    })
    .done(function(msg) {

        if (msg) {
            change_content(msg);

        }

    }).fail(function(a, b, c) {
        if (a.status == 404) {
            //location.reload();
        }

    });

}

/*function get_current_page() {

    //var url_href = window.location.href.split("#");
    var url_href = window.location.href.split("/");
    console.log(url_href);
    if (url_href.length < 2 || url_href[1] == "") {
        $(".menu_item span").css("color", "#6e768e");
        $("#add_team_item span").css("color", "#00acc1");
        current_page = "home";
        return current_page;
    }
    $(".menu_item span").css("color", "#6e768e");
    $("a[data-url='" + url_href[1] + "']").css("color", "#00acc1");
    current_page = url_href[1];
    return url_href[1];
}*/

function get_current_page(){

    url_parsed = new URL(window.location.href);
    url_path = url_parsed.pathname;
    url_path = url_path.replace("/[a-zA-Z0-9.]+.php(?!\\\)$/", "");
    base_folder = decodeURIComponent(readCookie("BASE_FOLDER"));
    if(base_folder !== "/"){
        url_path = url_path.replace(base_folder, "" );
    }
    url_path_exploded = url_path.split("/");
    //console.log(url_path_exploded);
    if(url_path_exploded[1] === "" || url_path_exploded[1] === "/"){
        return "home";
    }
    return url_path_exploded[1];
    
}

function ajax(params) {
    if (typeof params === 'string' || params instanceof String) {
        params = "request_type=ajax&" + params;
    }
    return $.ajax({
        type: "POST",
        url: "index.php",
        data: params
    });
}

function reInitDatatable(elem) {
    elem.DataTable().clear().destroy();
}

function menu_item_color(){

    $(".menu_item").css("color", "#000");
    $(".menu_item[data-url='"+current_page+"']").css("color", "#004eff");

}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function construct_menu(){

    $.ajax({
        method: "POST",
        data: {
            request_type: "ajax",
            module: "menu",
            exec: "get_menu"
        }
    })
    .done(function(msg) {

        if(msg) {
            if(msg.result){

                let sidebar_elem = $(".sidebar:eq(0)");
                sidebar_elem.append(`<ul></ul>`);
                let sidebar_ul = $(".sidebar:eq(0) ul:eq(0)");
                let menu_array = msg.result;

                menu_array.map(function(item, i){
                    sidebar_ul.append(
                        ` 
                            <li>
                                <a 
                                    class="nav-link menu_item" 
                                    href="#" 
                                    data-url="${item.module_name}">
                                        ${item.title}
                                </a>
                            </li>
                            ${i==menu_array.length-1?`<li><button class="nav-link" id="logout">Logout </button></li>`:``}
                        `
                    );
                });

                menu_item_color();


            }
            else{
                console.log("Error while getting menu items");
                return 0;
            }
        }

    }).fail(function(a, b, c) {
        if (a.status == 404) {
            //location.reload();
        }

    });

}

function UCFirst(str){
    if (!(typeof str === 'string' || str instanceof String)) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function toast(toast_params){
    var type = "success";
    if(toast_params.success === false) type = "error";
    $.Toast
    (
        //toast_params.title,
        UCFirst(type),
        toast_params.msg, 
        type, // Success/Error/Warning 
        {
            has_icon:true,
            has_close_btn:true,
            stack: true,
            fullscreen:false,
            timeout:5000,
            sticky:false,
            has_progress:true,
            rtl:false,
            position_class: 'toast-top-right'
        }
    );
}

function loadingOverlay(){
    $.LoadingOverlaySetup({
        background      : "rgba(255, 255, 255, 0.97)",
        image           : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><circle r="80" cx="500" cy="90"/><circle r="80" cx="500" cy="910"/><circle r="80" cx="90" cy="500"/><circle r="80" cx="910" cy="500"/><circle r="80" cx="212" cy="212"/><circle r="80" cx="788" cy="212"/><circle r="80" cx="212" cy="788"/><circle r="80" cx="788" cy="788"/></svg>'
    });
}

$(document).on('click', '.reset_btn', function(evt) {
    var modal = $("#" + $(this).data('modal'));
    modal.modal('hide');
});


/*$.fn.tcrud = {
    "get_crud_params": function(){
        console.log("From test1"); return this
    },
    "test1": function(){console.log("From test1"); return this},
    "test2": function(){console.log("From test2"); return this},
    "get_type": function(){
        return this.nodeName;
    }
};*/
$.fn.tcrud = (function(tcurd_params = {}){
    console.log(tcurd_params);
    if(!tcurd_params.hasOwnProperty("module_name"))  throw 'Module name is missing';
    this.modal = false;
    if(tcurd_params.hasOwnProperty("modal") && tcurd_params.modal == true) this.modal = true;
    if(tcurd_params.hasOwnProperty("clear_inputs") && tcurd_params.clear_inputs == true) this.clear_inputs = true;
    this.form = $(this[0]);
    this.module_name = tcurd_params.module_name;
    function init(self){
        console.log(self.prop("tagName"));
    }
    this.get_crud_fields = function(){
        if(this.prop("tagName").toLowerCase() != "form") throw 'Parameter is not a form element!';

        var crud_inputs = this.find("[data-crud_params]");
        var self = this;
        var crud_inputs = this.find("[data-crud_params]");
        var entry_id = this.find("[data-entry_id]").val();
        this.ajax_params = {};
        this.ajax_params["module"] = this.module_name;
        this.ajax_params.crud_fields = {};
        if(entry_id > 0){
            this.ajax_params.crud_type = "update";
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
                this.ajax_params.crud_fields[crud_params.table_column] = fn(self.val());
            }else{
                this.ajax_params.crud_fields[crud_params.table_column] = self.val();
            }

        }

        return this;
    }
    this.exec = function(){
        if(!this.hasOwnProperty("ajax_params")){
            this.get_crud_fields();
        }
        $.LoadingOverlay("show");

        var self = this;
        ajax(self.ajax_params).done(function(data){
            console.log(self.modal);
            self.modal?self.close_form_modal():'';
            self.clear_inputs?self.clear_inputs():'';

            toast({
                msg: data.msg,
                success: data.success
            });

            $.LoadingOverlay("hide");
        });
        console.log("Form Submitted");
    }
    this.close_form_modal = function () {

        let activeElement = $(document.activeElement);
        if(activeElement != "undefined"){
            if(!(activeElement.attr("id").includes("new"))){
                $(this[0].closest("div.modal")).modal("hide");
            }
        }
        
    }
    this.clear_inputs = function(){
        this.form.find("input").each(function(){
            let elem = $(this);
            elem.val('');
        });
        this.form.find("select").each(function(){
            let elem = $(this);
            if ($(elem).hasClass('select2-hidden-accessible')){
                $(elem).val(-1).trigger("change.select2");
            }else{
                elem.val(-1);
            }
        });
        let form_inputs = [];
        form_inputs.push(this.form.find("input"));
        console.log(this.form.find("input"));
        let inputs = this.form.find("input");
        let selects = this.form.find("select");
        let textareas = this.form.find("textarea");
        console.log(form_inputs);
        $(form_inputs).each(function () {
            console.log(this);
        });
    }

    return this;
});