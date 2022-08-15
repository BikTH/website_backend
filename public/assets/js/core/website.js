var didScroll; var lastScrollTop = 0; var delta = 5; var navbarHeight = $('nav#header').outerHeight();

!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){var n=/\+/g;function o(e){return t.raw?e:encodeURIComponent(e)}function i(e){return o(t.json?JSON.stringify(e):String(e))}function r(o,i){var r=t.raw?o:function(e){0===e.indexOf('"')&&(e=e.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return e=decodeURIComponent(e.replace(n," ")),t.json?JSON.parse(e):e}catch(e){}}(o);return e.isFunction(i)?i(r):r}var t=e.cookie=function(n,c,u){if(arguments.length>1&&!e.isFunction(c)){if("number"==typeof(u=e.extend({},t.defaults,u)).expires){var s=u.expires,a=u.expires=new Date;a.setMilliseconds(a.getMilliseconds()+864e5*s)}return document.cookie=[o(n),"=",i(c),u.expires?"; expires="+u.expires.toUTCString():"",u.path?"; path="+u.path:"",u.domain?"; domain="+u.domain:"",u.secure?"; secure":""].join("")}for(var d,f=n?void 0:{},p=document.cookie?document.cookie.split("; "):[],l=0,m=p.length;l<m;l++){var x=p[l].split("="),g=(d=x.shift(),t.raw?d:decodeURIComponent(d)),v=x.join("=");if(n===g){f=r(v,c);break}n||void 0===(v=r(v))||(f[g]=v)}return f};t.defaults={},e.removeCookie=function(n,o){return e.cookie(n,"",e.extend({},o,{expires:-1})),!e.cookie(n)}});

var stickyNavTop = $('nav#header').offset().top;

$(window).scroll(function(event){ 
    didScroll = true; stickyNav();
})


setInterval(function() { if (didScroll) { hasScrolled(); didScroll = false; } }, 250);

function hasScrolled() {
    var st = $(this).scrollTop();
    if( Math.abs(lastScrollTop - st) <= delta ){ return; }
    if (st > lastScrollTop && st > navbarHeight){ $('nav#header').removeClass('nav-down').addClass('nav-up'); } else { if( st + $(window).height() < $(document).height() ) { $('nav#header').removeClass('nav-up').addClass('nav-down'); } }
    lastScrollTop = st;
}

var stickyNav = function(){
    var scrollTop = $(window).scrollTop(); if (scrollTop > stickyNavTop) { 
        $('nav#header').addClass('sticky');
    } else {
        $('nav#header').removeClass('sticky'); 
    }
};


(function(){
    cookiesPolicyBar();
    $("body").on("click", "a[href='#']", function(e){ e.preventDefault(); });
    $("body").on("submit", "form#requestquoteform", function(e){
        e.preventDefault(); var form = $(e.target);
        var name = $(form).find("input#name");
        var business = $(form).find("input#business");
        var address = $(form).find("input#address");
        var email = $(form).find("input#email");
        var phone = $(form).find("input#phone");
        var budget = $(form).find("input#budget");
        var comment = $(form).find("input#comment");
        
        if( isvalid(email) && isvalid(name) && isvalid(address) && isvalid(phone) && isvalid(budget) && isvalid(business) && isvalid(comment) ){
            $.alert("Tu es fort");
        }
    });
    
    AOS.init();
    
})();


function isvalid(el){
    var input = el.val();
    var mode = el.attr("inputmode"); var ml = parseInt(el.attr("maxlength"), 10) > 0 ? parseInt(el.attr("maxlength"), 10) : 0; var required = el.attr("required")
    switch( mode ){
        case 'email':
            return validator.isEmail(input) && ( ml === 0 || ( ml > 0 && input.length <= ml ) );
            break;
            
        case 'numeric':
            return validator.isNumeric(input) && ( ml === 0 || ( ml > 0 && input.length <= ml ) );
            break;
            
        default:
            return ml === 0 || ( ml > 0 && input.length <= ml );
            break;
    }
}


function cookiesPolicyBar(){
    if ($.cookie('cookieAlert') != "active") $('#cookiefooter').show(); 
    $("#cookiefooter a[data-action='dismiss']").on('click', function(){
        $.cookie('cookieAlert', 'active', { expires: 2, path: '/' });  $('#cookiefooter').fadeOut();
    });
}

