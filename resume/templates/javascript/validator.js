/**
showErrorMethod: 0/div, 1/alert;
$('button').addEvent('click',function(){
    var objValidator = new Validator({
        showErrorMethod:0,
        errorID:'error',
        errorMsg:'<font color=red> format error!</font>'
        });
    if(!objValidator.isDate($('username'))){
        objValidator.showError('username');
    }
});
*/
var Validator = new Class({

	Implements:[Options, Events],

	options: {
	    showErrorMethod: 0,
	    errorID:'',
	    errorMsg:'Error!'
	},

	initialize: function(options){
		this.setOptions(options);
	},

	//is empty or not
	//return true if empty
	//return false if unempty
	isEmpty:function(element){
	    var isEmpty = new InputValidator('IsEmpty', {
            test: function(element){
                switch(element.type){
                    case 'select':
                    case 'select-one':
                        return !(element.selectedIndex >= 0 && (element.options[element.selectedIndex].value != '' || element.options[element.selectedIndex].value != '-1'));
                        break;
                    case 'text':
                    case 'textarea':
                    case 'hidden':
                    case 'password':
                        return ((element.get('value') == null) || (element.get('value').length == 0));
                        break;
                    case 'radio':
                    case 'checkbox':
                        var elLength = $$('[name='+element.name+']').length;
                        var cbCheckeds=true;
                        for(var i=0;i<elLength;i++){
                            if($$('[name='+element.name+']')[i].checked){
                				cbCheckeds = false;
                			}
                        }
                        return cbCheckeds;
                        break;
                }
            }
        });
        return isEmpty.test(element); //true if empty
	},

	//if the value is >= than the minLength value, element passes test
	MinLength:function(element){
    	var minLength = new InputValidator ('minLength', {
            test: function(element, props){
                return (element.value.length >= $pick(props.minLength, 0));
            }
        });
        return minLength.test(element);
    },

	//if the value is <= than the maxLength value, element passes test
	MaxLength:function(element){
    	var maxLength = new InputValidator ('maxLength', {
            test: function(element, props){
                return (element.value.length <= $pick(props.maxLength, 10000));
            }
        });
        return maxLength.test(element);
    },

    //return true if is china mobile number
    isMobile:function(element){
         var isMobile = new InputValidator ('isMobile', {
            test: function(element){
                return (/(13|15|18)\d{9}/.test(element.get('value')));
            }
        });
        return isMobile.test(element);
   },

    //return true if is a email address
    isEmail:function(element){
        var isEmail = new InputValidator ('isEmail', {
            test: function(element){
                return (/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i.test(element.get('value')));
            }
        });
        return isEmail.test(element);
    },

    //return true if is digit
    isDigit:function(element){
        var isDigit = new InputValidator ('isDigit', {
            test: function(element){
                return (/^[\d() .:\-\+#]+$/.test(element.get('value')));
            }
        });
        return isDigit.test(element);
    },

    //return true if is int
    isInt:function(element){
        var isInt = new InputValidator ('isInt', {
            test: function(element){
                return (/^\d+$/.test(element.get('value')));
            }
        });
        return isInt.test(element);
    },

    //return true if is chinese id card
    isIDNumber:function(element){
        var isIDNumber = new InputValidator ('isIDNumber', {
            test: function(element){
                var idnumberLength = element.value.length;
                return ((idnumberLength == 15 || idnumberLength == 18) && (/\d{15}/).test(element.get('value'), "i") || /\d{17}[0-9, x, X]/.test(element.get('value'), "i"));
            }
        });
        return isIDNumber.test(element);
    },

    //return true if is yyyy-mm-dd format
    isDate:function(element){
        var isDate = new InputValidator ('isDate', {
            test: function(element){
                var regex = /^(\d{4})-(\d{2})-(\d{2})$/;
                if (!regex.test(element.get('value'))) return false;
                d = new Date(element.get('value').replace(regex, '$1-$2-$3'));
				return (parseInt(RegExp.$1, 10) == d.get('year')) &&
					(parseInt(RegExp.$2, 10) == (1 + d.get('mo'))) &&
					(parseInt(RegExp.$3, 10) == d.get('date'));
            }
        });
        return isDate.test(element);
    },

	showError:function(error, errorID){
	    this.options.errorMsg = (error!='' && $type(error))?error:this.options.errorMsg;
	    this.options.errorID = (errorID!='' && $type(errorID))?errorID:this.options.errorID;
	    if(this.options.showErrorMethod == 0){
	        $(this.options.errorID).set('html', this.options.errorMsg);
	    }
	    else{
	        alert(this.options.errorMsg);
	    }
	}
});