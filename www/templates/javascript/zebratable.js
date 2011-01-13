var ZebraTable = new Class({
	//implements
	Implements: [Options,Events],

	//options
	options: {
		elements: '',
		cssEven: '',
		cssOdd: '',
		cssHighlight: '',
		cssMouseEnter: ''
	},

	//initialization
	initialize: function(options) {
		//set options
		this.setOptions(options);
		//zebra-ize!
		$$(this.options.elements).each(function(table) {
			this.zebraize(table);
		},this);
	},

	//a method that does whatever you want
	zebraize: function(table) {
		//for every row in this table...
		table.getElements('tr').each(function(tr,i) {
			//check to see if the row has th's
			//if so, leave it alone
			//if not, move on
			if(tr.getFirst().get('tag') != 'th') {
				//set the class for this based on odd/even
				var options = this.options, klass = i % 2 ? options.cssEven : options.cssOdd;
				//start the events!
				tr.addClass(klass).addEvents({
					//mouseenter
					mouseenter: function () {
						if(!tr.hasClass(options.cssHighlight)) tr.addClass(options.cssMouseEnter).removeClass(klass);
					},
					//mouseleave
					mouseleave: function () {
						if(!tr.hasClass(options.cssHighlight)) tr.removeClass(options.cssMouseEnter).addClass(klass);
					}
				});
			}
		},this);
	},

	//highlight
	highlight: function(tr, status, click){
	    var options = this.options
	    if(status == true)
	    {
	        tr.hasClass(options.cssEven)?tr.removeClass(options.cssEven):void(0);
	        tr.hasClass(options.cssOdd)?tr.removeClass(options.cssOdd):void(0);
	        tr.removeClass(options.cssMouseEnter).addClass(options.cssHighlight);
	    }
	    else
	    {
	        tr.removeClass(options.cssHighlight);
	        if(click == 'all')
	        {
	            $$(this.options.elements).each(function(table) {
                       this.zebraize(table);
		      },this);
	        }
	    }
	}
});