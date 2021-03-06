(function(a) {
    a.widget("ui.selectmenu", {
        options: {
            appendTo: "body", typeAhead: 1000, style: "dropdown", positionOptions: null, width: null, menuWidth: null, handleWidth: 26, maxHeight: null, icons: null, format: null, escapeHtml: false, bgImage: function() {}
        }
        ,
        _create:function() {
            var b=this, e=this.options;
            var d=this.element.uniqueId().attr("id");
            this.ids=[d, d+"-button", d+"-menu"];
            this._safemouseup=true;
            this.isOpen=false;
            this.newelement=a("<a />", {
                "class": "ui-selectmenu ui-widget ui-state-default ui-corner-all", id: this.ids[1], role: "button", href: "#nogo", tabindex: this.element.attr("disabled")?1: 0, "aria-haspopup": true, "aria-owns": this.ids[2]
            }
            );
            this.newelementWrap=a("<span />").append(this.newelement).insertAfter(this.element);
            var c=this.element.attr("tabindex");
            if(c) {
                this.newelement.attr("tabindex", c)
            }
            this.newelement.data("selectelement",
            this.element);
            this.selectmenuIcon=a('<span class="ui-selectmenu-icon ui-icon"></span>').prependTo(this.newelement);
            this.newelement.prepend('<span class="ui-selectmenu-status" />');
            this.element.bind( {
                "click.selectmenu": function(f) {
                    b.newelement.focus();
                    f.preventDefault()
                }
            }
            );
            this.newelement.bind("mousedown.selectmenu",
            function(f) {
                b._toggle(f, true);
                if(e.style=="popup") {
                    b._safemouseup=false;
                    setTimeout(function() {
                        b._safemouseup=true
                    }
                    ,
                    300)
                }
                f.preventDefault()
            }
            ).bind("click.selectmenu",
            function(f) {
                f.preventDefault()
            }
            ).bind("keydown.selectmenu",
            function(g) {
                var f=false;
                switch(g.keyCode) {
                    case a.ui.keyCode.ENTER: f=true;
                    break;
                    case a.ui.keyCode.SPACE: b._toggle(g);
                    break;
                    case a.ui.keyCode.UP: if(g.altKey) {
                        b.open(g)
                    }
                    else {
                        b._moveSelection(-1)
                    }
                    break;
                    case a.ui.keyCode.DOWN:if(g.altKey) {
                        b.open(g)
                    }
                    else {
                        b._moveSelection(1)
                    }
                    break;
                    case a.ui.keyCode.LEFT:b._moveSelection(-1);
                    break;
                    case a.ui.keyCode.RIGHT:b._moveSelection(1);
                    break;
                    case a.ui.keyCode.TAB:f=true;
                    break;
                    case a.ui.keyCode.PAGE_UP:case a.ui.keyCode.HOME:b.index(0);
                    break;
                    case a.ui.keyCode.PAGE_DOWN:case a.ui.keyCode.END:b.index(b._optionLis.length);
                    break;
                    default:f=true
                }
                return f
            }
            ).bind("keypress.selectmenu",
            function(f) {
                if(f.which>0) {
                    b._typeAhead(f.which, "mouseup")
                }
                return true
            }
            ).bind("mouseover.selectmenu",
            function() {
                if(!e.disabled) {
                    a(this).addClass("ui-state-hover")
                }
            }
            ).bind("mouseout.selectmenu",
            function() {
                if(!e.disabled) {
                    a(this).removeClass("ui-state-hover")
                }
            }
            ).bind("focus.selectmenu",
            function() {
                if(!e.disabled) {
                    a(this).addClass("ui-state-focus")
                }
            }
            ).bind("blur.selectmenu",
            function() {
                if(!e.disabled) {
                    a(this).removeClass("ui-state-focus")
                }
            }
            );
            a(document).bind("mousedown.selectmenu-"+this.ids[0],
            function(f) {
                if(b.isOpen&&!a(f.target).closest("#"+b.ids[1]).length) {
                    b.close(f)
                }
            }
            );
            this.element.bind("click.selectmenu",
            function() {
                b._refreshValue()
            }
            ).bind("focus.selectmenu",
            function() {
                if(b.newelement) {
                    b.newelement[0].focus()
                }
            }
            );
            if(!e.width) {
                e.width=this.element.outerWidth()
            }
            this.newelement.width(e.width);
            this.element.hide();
            this.list=a("<ul />",
            {
                "class": "ui-widget ui-widget-content", "aria-hidden": true, role: "listbox", "aria-labelledby": this.ids[1], id: this.ids[2]
            }
            );
            this.listWrap=a("<div />",
            {
                "class": "ui-selectmenu-menu"
            }
            ).append(this.list).appendTo(e.appendTo);
            this.list.bind("keydown.selectmenu",
            function(g) {
                var f=false;
                switch(g.keyCode) {
                    case a.ui.keyCode.UP: if(g.altKey) {
                        b.close(g, true)
                    }
                    else {
                        b._moveFocus(-1)
                    }
                    break;
                    case a.ui.keyCode.DOWN:if(g.altKey) {
                        b.close(g, true)
                    }
                    else {
                        b._moveFocus(1)
                    }
                    break;
                    case a.ui.keyCode.LEFT:b._moveFocus(-1);
                    break;
                    case a.ui.keyCode.RIGHT:b._moveFocus(1);
                    break;
                    case a.ui.keyCode.HOME:b._moveFocus(":first");
                    break;
                    case a.ui.keyCode.PAGE_UP:b._scrollPage("up");
                    break;
                    case a.ui.keyCode.PAGE_DOWN:b._scrollPage("down");
                    break;
                    case a.ui.keyCode.END:b._moveFocus(":last");
                    break;
                    case a.ui.keyCode.ENTER:case a.ui.keyCode.SPACE:b.close(g,
                    true);
                    a(g.target).parents("li:eq(0)").trigger("mouseup");
                    break;
                    case a.ui.keyCode.TAB:f=true;
                    b.close(g,
                    true);
                    a(g.target).parents("li:eq(0)").trigger("mouseup");
                    break;
                    case a.ui.keyCode.ESCAPE:b.close(g,
                    true);
                    break;
                    default:f=true
                }
                return f
            }
            ).bind("keypress.selectmenu",
            function(f) {
                if(f.which>0) {
                    b._typeAhead(f.which, "focus")
                }
                return true
            }
            ).bind("mousedown.selectmenu mouseup.selectmenu",
            function() {
                return false
            }
            );
            a(window).bind("resize.selectmenu-"+this.ids[0],
            a.proxy(b.close,
            this))
        }
        ,
        _init:function() {
            var s=this, e=this.options;
            var b=[];
            this.element.find("option").each(function() {
                var i=a(this);
                b.push( {
                    value: i.attr("value"), text: s._formatText(i.text(), i), selected: i.attr("selected"), disabled: i.attr("disabled"), classes: i.attr("class"), typeahead: i.attr("typeahead"), parentOptGroup: i.parent("optgroup"), bgImage: e.bgImage.call(i)
                }
                )
            }
            );
            var m=(s.options.style=="popup")?" ui-state-active":"";
            this.list.html("");
            if(b.length) {
                for(var k=0;
                k<b.length;
                k++) {
                    var f= {
                        role: "presentation"
                    }
                    ;
                    if(b[k].disabled) {
                        f["class"]="ui-state-disabled"
                    }
                    var t= {
                        html: b[k].text||"&nbsp;", href: "#nogo", tabindex: -1, role: "option", "aria-selected": false
                    }
                    ;
                    if(b[k].disabled) {
                        t["aria-disabled"]=true
                    }
                    if(b[k].typeahead) {
                        t.typeahead=b[k].typeahead
                    }
                    var r=a("<a/>",
                    t).bind("focus.selectmenu",
                    function() {
                        a(this).parent().mouseover()
                    }
                    ).bind("blur.selectmenu",
                    function() {
                        a(this).parent().mouseout()
                    }
                    );
                    var d=a("<li/>",
                    f).append(r).data("index",
                    k).addClass(b[k].classes).data("optionClasses",
                    b[k].classes||"").bind("mouseup.selectmenu",
                    function(i) {
                        if(s._safemouseup&&!s._disabled(i.currentTarget)&&!s._disabled(a(i.currentTarget).parents("ul > li.ui-selectmenu-group "))) {
                            s.index(a(this).data("index"));
                            s.select(i);
                            s.close(i, true)
                        }
                        return false
                    }
                    ).bind("click.selectmenu",
                    function() {
                        return false
                    }
                    ).bind("mouseover.selectmenu",
                    function(i) {
                        if(!a(this).hasClass("ui-state-disabled")&&!a(this).parent("ul").parent("li").hasClass("ui-state-disabled")) {
                            i.optionValue=s.element[0].options[a(this).data("index")].value;
                            s._trigger("hover", i, s._uiHash());
                            s._selectedOptionLi().addClass(m);
                            s._focusedOptionLi().removeClass("ui-selectmenu-item-focus ui-state-hover");
                            a(this).removeClass("ui-state-active").addClass("ui-selectmenu-item-focus ui-state-hover")
                        }
                    }
                    ).bind("mouseout.selectmenu",
                    function(i) {
                        if(a(this).is(s._selectedOptionLi())) {
                            a(this).addClass(m)
                        }
                        i.optionValue=s.element[0].options[a(this).data("index")].value;
                        s._trigger("blur",
                        i,
                        s._uiHash());
                        a(this).removeClass("ui-selectmenu-item-focus ui-state-hover")
                    }
                    );
                    if(b[k].parentOptGroup.length) {
                        var l="ui-selectmenu-group-"+this.element.find("optgroup").index(b[k].parentOptGroup);
                        if(this.list.find("li."+l).length) {
                            this.list.find("li."+l+":last ul").append(d)
                        }
                        else {
                            a('<li role="presentation" class="ui-selectmenu-group '+l+(b[k].parentOptGroup.attr("disabled")?' ui-state-disabled" aria-disabled="true"': '"')+'><span class="ui-selectmenu-group-label">'+b[k].parentOptGroup.attr("label")+"</span><ul></ul></li>").appendTo(this.list).find("ul").append(d)
                        }
                    }
                    else {
                        d.appendTo(this.list)
                    }
                    if(e.icons) {
                        for(var h in e.icons) {
                            if(d.is(e.icons[h].find)) {
                                d.data("optionClasses", b[k].classes+" ui-selectmenu-hasIcon").addClass("ui-selectmenu-hasIcon");
                                var p=e.icons[h].icon||"";
                                d.find("a:eq(0)").prepend('<span class="ui-selectmenu-item-icon ui-icon '+p+'"></span>');
                                if(b[k].bgImage) {
                                    d.find("span").css("background-image", b[k].bgImage)
                                }
                            }
                        }
                    }
                }
            }
            else {
                a('<li role="presentation"><a href="#nogo" tabindex="-1" role="option"></a></li>').appendTo(this.list)
            }
            var c=(e.style=="dropdown");
            this.newelement.toggleClass("ui-selectmenu-dropdown",
            c).toggleClass("ui-selectmenu-popup",
            !c);
            this.list.toggleClass("ui-selectmenu-menu-dropdown ui-corner-bottom",
            c).toggleClass("ui-selectmenu-menu-popup ui-corner-all",
            !c).find("li:first").toggleClass("ui-corner-top",
            !c).end().find("li:last").addClass("ui-corner-bottom");
            this.selectmenuIcon.toggleClass("ui-icon-triangle-1-s",
            c).toggleClass("ui-icon-triangle-2-n-s",
            !c);
            if(e.style=="dropdown") {
                this.list.width(e.menuWidth?e.menuWidth: e.width)
            }
            else {
                this.list.width(e.menuWidth?e.menuWidth: e.width-e.handleWidth)
            }
            this.list.css("height",
            "auto");
            var n=this.listWrap.height();
            var g=a(window).height();
            var q=e.maxHeight?Math.min(e.maxHeight,
            g):g/3;
            if(n>q) {
                this.list.height(q)
            }
            this._optionLis=this.list.find("li:not(.ui-selectmenu-group)");
            if(this.element.attr("disabled")) {
                this.disable()
            }
            else {
                this.enable()
            }
            this._refreshValue();
            this._selectedOptionLi().addClass("ui-selectmenu-item-focus");
            clearTimeout(this.refreshTimeout);
            this.refreshTimeout=window.setTimeout(function() {
                s._refreshPosition()
            }
            ,
            200)
        }
        ,
        destroy:function() {
            this.element.removeData(this.widgetName).removeClass("ui-selectmenu-disabled ui-state-disabled").removeAttr("aria-disabled").unbind(".selectmenu");
            a(window).unbind(".selectmenu-"+this.ids[0]);
            a(document).unbind(".selectmenu-"+this.ids[0]);
            this.newelementWrap.remove();
            this.listWrap.remove();
            this.element.unbind(".selectmenu").show();
            a.Widget.prototype.destroy.apply(this, arguments)
        }
        ,
        _typeAhead:function(e,
        f) {
            var l=this, k=String.fromCharCode(e).toLowerCase(), d=null, j=null;
            if(l._typeAhead_timer) {
                window.clearTimeout(l._typeAhead_timer);
                l._typeAhead_timer=undefined
            }
            l._typeAhead_chars=(l._typeAhead_chars===undefined?"":l._typeAhead_chars).concat(k);
            if(l._typeAhead_chars.length<2||(l._typeAhead_chars.substr(-2,
            1)===k&&l._typeAhead_cycling)) {
                l._typeAhead_cycling=true;
                d=k
            }
            else {
                l._typeAhead_cycling=false;
                d=l._typeAhead_chars
            }
            var g=(f!=="focus"?this._selectedOptionLi().data("index"):this._focusedOptionLi().data("index"))||0;
            for(var h=0;
            h<this._optionLis.length;
            h++) {
                var b=this._optionLis.eq(h).text().substr(0, d.length).toLowerCase();
                if(b===d) {
                    if(l._typeAhead_cycling) {
                        if(j===null) {
                            j=h
                        }
                        if(h>g) {
                            j=h;
                            break
                        }
                    }
                    else {
                        j=h
                    }
                }
            }
            if(j!==null) {
                this._optionLis.eq(j).find("a").trigger(f)
            }
            l._typeAhead_timer=window.setTimeout(function() {
                l._typeAhead_timer=undefined;
                l._typeAhead_chars=undefined;
                l._typeAhead_cycling=undefined
            }
            ,
            l.options.typeAhead)
        }
        ,
        _uiHash:function() {
            var b=this.index();
            return {
                index: b, option: a("option", this.element).get(b), value: this.element[0].value
            }
        }
        ,
        open:function(e) {
            if(this.newelement.attr("aria-disabled")!="true") {
                var b=this, f=this.options, c=this._selectedOptionLi(), d=c.find("a");
                b._closeOthers(e);
                b.newelement.addClass("ui-state-active");
                b.list.attr("aria-hidden", false);
                b.listWrap.addClass("ui-selectmenu-open");
                if(f.style=="dropdown") {
                    b.newelement.removeClass("ui-corner-all").addClass("ui-corner-top")
                }
                else {
                    this.list.css("left", -5000).scrollTop(this.list.scrollTop()+c.position().top-this.list.outerHeight()/2+c.outerHeight()/2).css("left", "auto")
                }
                b._refreshPosition();
                if(d.length) {
                    d[0].focus()
                }
                b.isOpen=true;
                b._trigger("open",
                e,
                b._uiHash())
            }
        }
        ,
        close:function(c,
        b) {
            if(this.newelement.is(".ui-state-active")) {
                this.newelement.removeClass("ui-state-active");
                this.listWrap.removeClass("ui-selectmenu-open");
                this.list.attr("aria-hidden", true);
                if(this.options.style=="dropdown") {
                    this.newelement.removeClass("ui-corner-top").addClass("ui-corner-all")
                }
                if(b) {
                    this.newelement.focus()
                }
                this.isOpen=false;
                this._trigger("close",
                c,
                this._uiHash())
            }
        }
        ,
        change:function(b) {
            this.element.trigger("change");
            this._trigger("change", b, this._uiHash())
        }
        ,
        select:function(b) {
            if(this._disabled(b.currentTarget)) {
                return false
            }
            this._trigger("select",
            b,
            this._uiHash())
        }
        ,
        widget:function() {
            return this.listWrap.add(this.newelementWrap)
        }
        ,
        _closeOthers:function(b) {
            a(".ui-selectmenu.ui-state-active").not(this.newelement).each(function() {
                a(this).data("selectelement").selectmenu("close", b)
            }
            );
            a(".ui-selectmenu.ui-state-hover").trigger("mouseout")
        }
        ,
        _toggle:function(c,
        b) {
            if(this.isOpen) {
                this.close(c, b)
            }
            else {
                this.open(c)
            }
        }
        ,
        _formatText:function(c,
        b) {
            if(this.options.format) {
                c=this.options.format(c, b)
            }
            else {
                if(this.options.escapeHtml) {
                    c=a("<div />").text(c).html()
                }
            }
            return c
        }
        ,
        _selectedIndex:function() {
            return this.element[0].selectedIndex
        }
        ,
        _selectedOptionLi:function() {
            return this._optionLis.eq(this._selectedIndex())
        }
        ,
        _focusedOptionLi:function() {
            return this.list.find(".ui-selectmenu-item-focus")
        }
        ,
        _moveSelection:function(e,
        b) {
            if(!this.options.disabled) {
                var d=parseInt(this._selectedOptionLi().data("index")||0, 10);
                var c=d+e;
                if(c<0) {
                    c=0
                }
                if(c>this._optionLis.size()-1) {
                    c=this._optionLis.size()-1
                }
                if(c===b) {
                    return false
                }
                if(this._optionLis.eq(c).hasClass("ui-state-disabled")) {
                    (e>0)?++e: --e;
                    this._moveSelection(e, c)
                }
                else {
                    this._optionLis.eq(c).trigger("mouseover").trigger("mouseup")
                }
            }
        }
        ,
        _moveFocus:function(f,
        b) {
            if(!isNaN(f)) {
                var e=parseInt(this._focusedOptionLi().data("index")||0, 10);
                var d=e+f
            }
            else {
                var d=parseInt(this._optionLis.filter(f).data("index"), 10)
            }
            if(d<0) {
                d=0
            }
            if(d>this._optionLis.size()-1) {
                d=this._optionLis.size()-1
            }
            if(d===b) {
                return false
            }
            var c="ui-selectmenu-item-"+Math.round(Math.random()*1000);
            this._focusedOptionLi().find("a:eq(0)").attr("id",
            "");
            if(this._optionLis.eq(d).hasClass("ui-state-disabled")) {
                (f>0)?++f: --f;
                this._moveFocus(f, d)
            }
            else {
                this._optionLis.eq(d).find("a:eq(0)").attr("id", c).focus()
            }
            this.list.attr("aria-activedescendant",
            c)
        }
        ,
        _scrollPage:function(c) {
            var b=Math.floor(this.list.outerHeight()/this._optionLis.first().outerHeight());
            b=(c=="up"?-b: b);
            this._moveFocus(b)
        }
        ,
        _setOption:function(b,
        c) {
            this.options[b]=c;
            if(b=="disabled") {
                if(c) {
                    this.close()
                }
                this.element.add(this.newelement).add(this.list)[c?"addClass":"removeClass"]("ui-selectmenu-disabled ui-state-disabled").attr("aria-disabled",
                c).attr("tabindex",
                c?1:0)
            }
        }
        ,
        disable:function(b,
        c) {
            if(typeof(b)=="undefined") {
                this._setOption("disabled", true)
            }
            else {
                this._toggleEnabled((c||"option"), b, false)
            }
        }
        ,
        enable:function(b,
        c) {
            if(typeof(b)=="undefined") {
                this._setOption("disabled", false)
            }
            else {
                this._toggleEnabled((c||"option"), b, true)
            }
        }
        ,
        _disabled:function(b) {
            return a(b).hasClass("ui-state-disabled")
        }
        ,
        _toggleEnabled:function(e,
        c,
        b) {
            var d=this.element.find(e).eq(c), f=(e==="optgroup")?this.list.find("li.ui-selectmenu-group-"+c): this._optionLis.eq(c);
            if(f) {
                f.toggleClass("ui-state-disabled", !b).attr("aria-disabled", !b);
                if(b) {
                    d.removeAttr("disabled")
                }
                else {
                    d.attr("disabled", "disabled")
                }
            }
        }
        ,
        index:function(b) {
            if(arguments.length) {
                if(!this._disabled(a(this._optionLis[b]))&&b!=this._selectedIndex()) {
                    this.element[0].selectedIndex=b;
                    this._refreshValue();
                    this.change()
                }
                else {
                    return false
                }
            }
            else {
                return this._selectedIndex()
            }
        }
        ,
        value:function(b) {
            if(arguments.length&&b!=this.element[0].value) {
                this.element[0].value=b;
                this._refreshValue();
                this.change()
            }
            else {
                return this.element[0].value
            }
        }
        ,
        _refreshValue:function() {
            var d=(this.options.style=="popup")?" ui-state-active": "";
            var c="ui-selectmenu-item-"+Math.round(Math.random()*1000);
            this.list.find(".ui-selectmenu-item-selected").removeClass("ui-selectmenu-item-selected"+d).find("a").attr("aria-selected", "false").attr("id", "");
            this._selectedOptionLi().addClass("ui-selectmenu-item-selected"+d).find("a").attr("aria-selected", "true").attr("id", c);
            var b=(this.newelement.data("optionClasses")?this.newelement.data("optionClasses"): "");
            var e=(this._selectedOptionLi().data("optionClasses")?this._selectedOptionLi().data("optionClasses"): "");
            this.newelement.removeClass(b).data("optionClasses", e).addClass(e).find(".ui-selectmenu-status").html(this._selectedOptionLi().find("a:eq(0)").html());
            this.list.attr("aria-activedescendant", c)
        }
        ,
        _refreshPosition:function() {
            var d=this.options, c= {
                of: this.newelement, my: "left top", at: "left bottom", collision: "flip"
            }
            ;
            if(d.style=="popup") {
                var b=this._selectedOptionLi();
                c.my="left top"+(this.list.offset().top-b.offset().top-(this.newelement.outerHeight()+b.outerHeight())/2);
                c.collision="fit"
            }
            this.listWrap.removeAttr("style").zIndex(this.element.zIndex()+2).position(a.extend(c,
            d.positionOptions))
        }
    }
    )
}
)(jQuery);