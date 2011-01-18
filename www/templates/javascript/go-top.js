var Top = new Class({

    Implements: Options,

    options:{
        topid:'gototop',
        s:300
    },

    initialize:function(options) {
        this.setOptions(options);
        new SmoothScroll({duration:500});
        $(this.options.topid).set('opacity','0').setStyle('display','block');
        this.topEvent(this.options);
    },


    topEvent:function(element) {
        window.addEvent('scroll',function(e,topid) {
        	if(Browser.Engine.trident4) {
        		$(element.topid).setStyles({
        			'position': 'absolute',
        			'bottom': window.getPosition().y + 10,
        			'width': 100
        		});
        	}
        	$(element.topid).fade((window.getScroll().y > element.s) ? 'in' : 'out')
        });
    }


});