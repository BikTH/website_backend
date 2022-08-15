var isConnected = false;
$(window).ajaxComplete(function(event, xhr, settings) {
	if ( isConnected && ( xhr.responseText == "two_users" || xhr.responseText == "unauthorized" || xhr.responseText == "session_expired" ) ) {
		$.alert({ title: "", theme: "supervan", closeIcon: false, icon: "", content: "Your session has expired, you will be logged out !"});
		window.location.reload(true);
	}
});

$.ajaxSetup({ dataType: "json", type: "post"});

$.hashroute('middleware', function(e){ e.first = true; this.next(); });

function openpage(relatedTarget, link, name){
    var url = link;
    $.ajax({url: "/dashboard/open/"+url, type: "get", dataType: "html",
        beforeSend: function(){ $("title").html(name); $.isLoading(); $("div.main_app_menu > a").removeClass("active"); $("a#"+relatedTarget+", a."+relatedTarget).addClass("active");  }, 
        complete: function(){ $.isLoading("hide"); },
        success: function(xhr){
            $("#window").html(xhr);
            document.body.scrollTop = 0; document.documentElement.scrollTop = 0;
        }
    });
}

$(document).hashroute('/', function(e){ openpage("a1", "pages/request", "Devis"); });
$(document).hashroute('/request', function(e){ openpage("a1", "pages/request", "Devis"); });
$(document).hashroute('/store', function(e){ openpage("a2", "pages/store", "Boutique"); });
$(document).hashroute('/testimonial', function(e){ openpage("a3", "pages/testimonial", "Témoignage"); });
$(document).hashroute('/setting', function(e){ openpage("a4", "pages/setting", "Paramétre"); });

jconfirm.defaults = {animateFromElement: false, title: "Message"};

var Utils = {
    requiredLabel: "Required.",
    success: "Everything went smoothly.",
    cleared: "Successfuly cleared",
    invalidLabel: "Invalid",
    errorOccured: "An error has occurred, please try again later.",
    specification: "Use the specifications below",
    changesmadeinfo: "The modifications have been successfully completed.",
    support: "Help and support",
}

function _modal(options){
    var id = options.id || "tempid";
    var classname = options.classname || "";
    var callback = isFunction( options.callback ) ? options.callback() : null;
    var flash = true;
    var widget = $('<div class="modal fade" data-easein="pulse"  id="'+id+'"><div class="modal-dialog modal-dialog-scrollable modal-dialog-centered"><div class="modal-content border-0"><div class="text-center">    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>     </div></div></div></div>');
    $("body").append(widget);
    
    widget.on("shown.bs.modal", function(event){ 
        $modal = $(this); $("body").css("overflow", "hidden"); 
        if( options.remote ) { 
            widget.find(".modal-content").load(options.remote, function(){
                callback;
                $modal.find(".modal-dialog").addClass(classname);
                widget.find('input[autofocus]').trigger("focus");
            });
        }
    });

    widget.on("hidden.bs.modal", function(event){ $modal = $(this);$("body").css("overflow", "auto"); if( flash ){ $modal.remove(); }});

    var myModal = new bootstrap.Modal( widget, { escape: false, backdrop: 'static' });
    
    myModal.show(); window.modal = myModal;
}


function isFunction(functionToCheck) { return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]'; }


var MF = {
    clear: {
        quote: function(id){
            $.confirm({
                title: 'Confirmation',
                content: "You're about to delete this request! Continue?",
                buttons: {
                    cancel: { text: 'Back' },
                    confirm: {
                        text: 'Continue',
                        action: function(){
                            $.ajax({ data: {id: id}, url: "/backoffice/clear/quote", beforeSend: function(){ $.isLoading(); }, complete: function(){ $.isLoading("hide"); }, success: function(data){
                                if(data && data.status){
                                    $.alert(Utils.cleared); window.location.reload(true);
                                }
                                else{
                                    $.alert(Utils.errorOccured);
                                }
                            }});
                        }
                    }
                }
            });
        },
    },
};


$(function(){
    
    $("body").on("click", "[data-action='openmodal']", function(e){
		e.preventDefault();
		var func = $(e.target).data("function"); var params = $(e.target).data("param") === undefined ? "" : $(e.target).data("param"); var modalID = $(e.target).data("modal") === undefined ? "" : $(e.target).data("modal");
		var size = $(e.target).data("size") === undefined ? "md" : $(e.target).data("size");
		return _modal({ remote: '/backoffice/open/func/'+func+params, id: modalID, classname: "modal-"+size }, true);
	});

    $("body").on("click", "button#addmediatrigger", function(){ $("input#importfile").trigger("click"); });
    $("body").on("click", "button#addserviceicon", function(){ $("input#import_icon").trigger("click"); });
    
    if( !window.isMobile){ $("#app_nav").sticky({topSpacing: 80}); }
    
    $.extend( true, $.fn.dataTable.defaults, { "scrollX": true, "scrollY": "480px", "scrollCollapse": true, "searching": true, "paging": false, "ordering": true, info: false});


	$("body").on("change", "input._file", function(e){
        var file_ = null; var clearer = $(e.target).data("clearer");
        if ( ( file_ = $(e.target)[0].files[0] ) ) { 
            filename = file_.name; var allowedTypes = new RegExp("(.*?)\.(png|jpg|jpeg|pdf)$");
            if( allowedTypes.test(filename.toLowerCase()) ){
                if( file_.size <= 4194304 ){
                    if( clearer != "" && $("#" + clearer).get(0) ){ 
                        $("#" + clearer).removeClass("d-none");
                        $("#" + clearer).on("click", function(x){
                            x.preventDefault(); $(e.target).val(""); $("#" + clearer).addClass("d-none");
                        }); 
                    }
                } 
                else {
                    $(e.target).val(""); $.alert(_t("error_filesize")); 
                }
            } else {
                $(e.target).val(""); $.alert(_t("error_type_doc")); 
            }
        }
    });
});


function get_uid(){
    return Date.now().toString(36) + Math.random().toString(36).substr(2);
}


function showFile(fn){
    var upload_ = $.templates(Template.upload);
    var minSize = { width: 720, height: 376 };
    img = new Image(); filename = file_.name; var allowedTypes = new RegExp("(.*?)\.(png|jpg|jpeg|mp4)$");
    if( allowedTypes.test(filename.toLowerCase()) ){
        // var objectUrl = _URL.createObjectURL(file_);
        var FR = new FileReader(); var type = filename.split('.').pop().toLowerCase();
        
        FR.addEventListener("load", function(e) {
            var upload = upload_.render({id: get_uid(), src: e.target.result, upload: e.target.result, type: type});
            $("#mediacontainer").append(upload);
            fn();
        }); 
        FR.readAsDataURL( file_ );
    }
    else{ $.alert("Please choose a valid image file");  }
}


function showPP(){
    var upload_ = $.templates(Template.uploadPP);
    var minSize = { width: 720, height: 376 };
    img = new Image(); filename = file_.name; var allowedTypes = new RegExp("(.*?)\.(png|jpg|jpeg)$");
    if( allowedTypes.test(filename.toLowerCase()) ){
        // var objectUrl = _URL.createObjectURL(file_);
        var FR = new FileReader();
        FR.addEventListener("load", function(e) {
            var upload = upload_.render({id: get_uid(), src: e.target.result, image: e.target.result});
            $("#ppcontainer").html(upload);
        }); 
        FR.readAsDataURL( file_ );
    }
    else{ $.alert("Please choose a valid image file");  }
}


function clearupload(el){ 
    var id = el.getAttribute("data-id");
    var parent = $(el).parents("div._upload"); 
    if( parent.data('update') != '' ){
        $.confirm({
            title: 'Confirmation',
            content: 'You are about to clear this image from this saved work',
            buttons: { cancel: { text: 'Back' }, confirm: { text: 'Continu', action: function(){ parent.remove(); } } }
        });
    }
    else{
        parent.remove();
    }
}


(function(window){
	window.htmlentities = {
		encode : function(str) {
			var buf = [];
			for (var i=str.length-1;i>=0;i--) {
				buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
			}
			return buf.join('');
		},
		decode : function(str) {
			return str.replace(/&#(\d+);/g, function(match, dec) {
				return String.fromCharCode(dec);
			});
		}
	};
})(window);


(function($){
    $.fn.loading = function (action) {
        var self = $(this);
        if (action == 'start' || action === undefined) {
            if ($(self).attr("disabled") == "disabled") {
                e.preventDefault();
            }
            $('.has-spinner').attr("disabled", "disabled");
            $(self).attr('data-btn-text', htmlentities.encode( $(self).html() ) );
            $(self).html('<span class="spinner"><i class="mdi-loading mdi mdi-spin"></i> Just a moment</span>');
            $(self).addClass('active').prop("disabled", true);
        }
        if (action == 'stop') {
            $(self).html( htmlentities.decode( $(self).attr('data-btn-text') ) );
            $(self).removeClass('active');
            
            if( $(self).prop("disabled") ){
                $(self).prop("disabled", false); 
            }
            
            $(self).attr('data-btn-text', "");
            $('.has-spinner').removeAttr("disabled");
        }
    }
})(jQuery);






