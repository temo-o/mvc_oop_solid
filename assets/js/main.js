var current_page = '';

$(document).ready(function(){
    var sidebar_width = $(".sidebar").width();

    $("#content").css("margin-left", sidebar_width);
    //$("#action_panel").css("margin-left", sidebar_width);

    initialize();
});

$(".menu_item").click(function(){
    var self = $(this);
    console.log(self);
	var target_url = self.data("url");
	$(".menu_item span").css("color","#6e768e");
	$("#"+target_url+ "_item span").css("color","#00acc1");
	$(".menu_item").css("color","#000");
	self.css("color","#00acc1");
	//console.log($("#"+target_url+ "_item span"));
	/*if(breadcrumbs_array.length > 2){
		
		if(breadcrumbs_array[breadcrumbs_array.length - 1] != target_url){
			breadcrumbs_array.shift();
		
			breadcrumbs_array[2] = target_url;
		}
		
	}
	else{
		if(breadcrumbs_array[breadcrumbs_array.length - 1] != target_url){
			breadcrumbs_array.push(target_url);
		}
		
	}
	
	manage_breadcrumbs();*/
	document.title = target_url;
	window.location = "#"+target_url;
	
	return false;
	
});

window.addEventListener('popstate', function (event) {
	// Log the state data to the console
	if(current_page != get_current_page()){
		get_page_content(get_current_page());
	}
	
	//console.log(get_current_page());
	//console.log("PopStateee");
});

function initialize(){
	
	//$(".breadcrumb-item").css("display","none");
	
	//breadcrumbs_array.push(get_current_page());
	//manage_breadcrumbs();
	get_page_content(get_current_page());
	document.title = get_current_page();

}

function change_content(contents){
	
	//$("#ajax_content").html(contents);
	$("#content").html(contents);
	
}

function get_page_content(page_url){
	
	if(page_url != "view_my_calls"){
		go_date = "";
	}
	
	$.ajax({
		method: "POST",
		url: "page/"+page_url+".php",
		data: 
		{
            request_type: "ajax",
            module: "view",
            exec: "get_content",
            view: page_url

		}
	})
	.done(function(msg) {
       
		if(msg){
			change_content(msg);
			
			$(".breadcrumb-item.active").html(page_url);
			$(".breadcrumb").css("position","relative");
			$(".breadcrumb").css("top","1.4em");
			if(window.innerWidth < 641){
				$(".breadcrumb").css("top","2.4em");
			}
		}
		
	}).fail(function(a, b, c) {
		if(a.status == 404){
			//location.reload();
		}
		
	});
	
}

function get_current_page(){
	
	var url_href = window.location.href.split("#");
	
	if(url_href.length < 2 || url_href[1] == ""){
		$(".menu_item span").css("color","#6e768e");
		$("#add_team_item span").css("color","#00acc1");
		//current_page = "dashboard";
		current_page = "add_team";
		return "add_team";
		//return "dashboard";
		
	}
	$(".menu_item span").css("color","#6e768e");
	//$("#"+url_href[1]+ "_item span").css("color","#00acc1");
    $("a[data-url='"+url_href[1]+"']").css("color","#00acc1");
	current_page = url_href[1];
	return url_href[1];
}

function ajax(params){
    if (typeof params === 'string' || params instanceof String){
        params = "request_type=ajax&" + params;
    }
    return $.ajax({
        type: "POST",
        url: "index.php",
        data: params
    });
}

function reInitDatatable(elem){
	elem.DataTable().clear().destroy();
}