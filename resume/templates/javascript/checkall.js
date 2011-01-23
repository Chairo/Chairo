var CheckAll = new Class({

    Implements: Options,

    //Options
    options:{
        selectedAll: 'select-all',
        selectedChildren: 'select-one',
        elements: 'table.list-table',
        cssEven: 'even',
        cssOdd: 'odd',
        cssHighlight: 'highlight',
        cssMouseEnter: 'mo'
    },

    //initialization
    initialize:function(options){
        //set options
        this.setOptions(options);
        //get all child elements
        this.select_children = $$('[name='+this.options.selectedChildren+']');
        //get select all element
        this.select_all = $(this.options.selectedAll);
        //
        this.render();
        //Zebra Table
        this.zebraTables = new ZebraTable({
            elements: this.options.elements,
            cssEven: this.options.cssEven,
            cssOdd: this.options.cssOdd,
            cssHighlight: this.options.cssHighlight,
            cssMouseEnter: this.options.cssMouseEnter
        });
    },

    //a method that does whatever you want
    render:function(){
        this.select_all.addEvent("click", this.selectAllEvent.bindWithEvent(this));
        this.select_children.each(function(element) {
            element.addEvent("click", this.selectChildrenEvent.bindWithEvent(this, element));
        }, this);
    },

    //when selectall checkbox clicked
    selectAllEvent:function(){
        this.select_children.each(function(el) {
                el.checked = this.select_all.checked;
                this.zebraTables.highlight(el.getParent('tr'), this.select_all.checked, 'all');
        }, this);
    },

    //when children checkbox clicked
    selectChildrenEvent:function(e, element){
        var selected_status = element.checked;
        var selected_num = 0;
        //highlight or unhighlight child checkbox
        this.zebraTables.highlight(element.getParent('tr'), selected_status, 'single');

        this.select_children.each(function(el) {
            if (el.checked == selected_status) ++selected_num;
        }, this);

        if (selected_num == this.select_children.length) {
             this.select_all.checked = selected_status;
        } else {
             this.select_all.checked = false;
        }
    }
});