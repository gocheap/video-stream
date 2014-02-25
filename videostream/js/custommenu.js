var winW;
var winH;

    window.onload = function() {
        
        if (document.body && document.body.offsetWidth) { 
         winW = document.body.offsetWidth;
         winH = document.body.offsetHeight;
        }
        if (document.compatMode=='CSS1Compat' &&
            document.documentElement &&
            document.documentElement.offsetWidth ) {
         winW = document.documentElement.offsetWidth;
         winH = document.documentElement.offsetHeight;
        }
        if (window.innerWidth && window.innerHeight) {
         winW = window.innerWidth;
         winH = window.innerHeight;
        }
               resize_run();
    }
    window.onresize = function() {
        if (document.body && document.body.offsetWidth) {
         winW = document.body.offsetWidth;
         winH = document.body.offsetHeight;
        }
        if (document.compatMode=='CSS1Compat' &&
            document.documentElement &&
            document.documentElement.offsetWidth ) {
         winW = document.documentElement.offsetWidth;
         winH = document.documentElement.offsetHeight;
        }
        if (window.innerWidth && window.innerHeight) {
         winW = window.innerWidth;
         winH = window.innerHeight;
        }
        resize_run();
    }
function resize_run()
{
    
     if (winW < 600) {
        jQuery.noConflict();
        jQuery("#menu_selector").addClass("noddclose");
        jQuery("#navigation").addClass("noddclose");
            (function(c){
                var g=c(window),b=window.Demopage={
                    init:function(){
                        this.themeselector=c("#menu_selector");
                        this.themebox=c("#navigation.noddclose");
                        this.themeselector.bind("click",function(){
                            b.toggleThemebox()
                            });
            c(document).bind("click",function(a){
                b.themebox.is(":visible")&&!(c(a.target).hasClass("noddclose")||c(a.target).parents(".noddclose").length==1)&&b.hideThemebox()
                });
            autosize()
                },
            hideThemebox:function(){
                this.themeselector.removeClass("active");
                this.themebox.hide();
                this.overlay.hide();
                return this
                },
            showThemebox:function(){
                this.themeselector.addClass("active");
                this.themebox.show();
                this.overlay.show();
                var a=c("#theme-lists").find(".selected:first");
                if(a.length){
                    var a=a.parent().parent().data("col"),b=parseFloat(c(this.themelistcols.get(0)).css("width"));
                    c("#columns").css("margin-left",(a==0?0:a-1)*b*-1)
                    }
                    return this
                },
            toggleThemebox:function(){
                return this[this.themebox.is(":visible")?"hideThemebox":"showThemebox"]()
                }
            };
            c(function(){
                Demopage.init();
                Demopage.selectTheme(window.$theme,window.$preset)
                })
            })(jQuery);

    }
    else{        
        jQuery("#menu_selector").removeClass("noddclose");
        jQuery("#navigation").removeClass("noddclose");
    }
}