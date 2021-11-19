var current_page = '';
var base_folder = decodeURIComponent(readCookie("BASE_FOLDER"));
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