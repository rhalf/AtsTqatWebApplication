function Label(opt_options){this.setValues(opt_options);var span=this.span_=document.createElement("span");span.style.cssText="position: absolute; left: 0%; top: -50px; "+"white-space: nowrap; border: 0px; font-family:arial; font-weight:bold;color:#00F;"+"padding: 2px;background-color: #ddd; "+"opacity: .75; "+"filter: alpha(opacity=75); "+'-ms-filter: "alpha(opacity=75)"; '+"-khtml-opacity: .75; "+"-moz-opacity: .75;";var div=this.div_=document.createElement("div");div.appendChild(span);div.style.cssText="position: absolute; display: none"}
Label.prototype=new google.maps.OverlayView;Label.prototype.onAdd=function(){var pane=this.getPanes().overlayLayer;pane.appendChild(this.div_);var me=this;this.listeners_=[google.maps.event.addListener(this,"position_changed",function(){me.draw()}),google.maps.event.addListener(this,"text_changed",function(){me.draw()})]};Label.prototype.onRemove=function(){this.div_.parentNode.removeChild(this.div_);for(var i=0,I=this.listeners_.length;i<I;++i)google.maps.event.removeListener(this.listeners_[i])};
Label.prototype.draw=function(){var projection=this.getProjection();var position=projection.fromLatLngToDivPixel(this.get("position"));var div=this.div_;div.style.left=position.x+"px";div.style.top=position.y+"px";div.style.display="block";this.span_.innerHTML=this.get("text").toString()};