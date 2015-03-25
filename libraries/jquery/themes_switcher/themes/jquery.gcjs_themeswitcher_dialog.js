/**
 * Themeswitcher Dialog-Tool for the jQuery UI CSS Framework
 * http://sourceforge.net/projects/gc-ui-tswitch/
 *
 * Change the css stylesheet using an ui dialogbox. Usable as well offline or 
 * from within your own webspace.
 * More information to jQuery UI:  http://jqueryui.com/
 *
 * Copyright (c) 2011 Michael Partenheimer
 * V 1.01	2011-12  
 *
 * Dual licensed under both the MIT and GPL version 2.0 licenses.
 * This means that you can choose the license that best suits your 
 * project and use it accordingly.
 *
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */


(function($) {

	// create plugin	
	$.fn.gcjs_themeswitcher_dialog = function(options) {

		$.extend($.fn.gcjs_themeswitcher_dialog.parameters, options);

  		var para = $.fn.gcjs_themeswitcher_dialog.parameters;

		// creation of DOM of dialog box 
		var  loc_table, loc_row, loc_td, loc_link, loc_tbod, loc_a, loc_img, loc_br, loc_tn, loc_cookie;

		var rowlen = para.number_pics;
		var rr = 0;
		var winwidth = (para.number_pics * para.width_piccell) + 130;
	
		loc_table = document.createElement("table");
		loc_tbod = document.createElement("tbody");

		loc_row=document.createElement("tr");

		for (i=0; i < $.fn.gcjs_themeswitcher_dialog.css_list.length ;i++){
			rr++;

			loc_img = document.createElement("img");
			loc_img.setAttribute("src", para.url_gallery + $.fn.gcjs_themeswitcher_dialog.css_list[i].pic);
			loc_img.setAttribute("style",'cursor:pointer');
loc_img.height = 90;
    loc_img.width = 85;
		//	loc_br = document.createElement("br");

			loc_a = document.createElement("a");
			loc_a.setAttribute("href", "#");

			loc_link = '"' + para.url_css + $.fn.gcjs_themeswitcher_dialog.css_list[i].file + '",';
			if (para.setcookie == true)
				loc_cookie = '"' + para.cookieDomain + '",' + para.cookieExpiry + ',"' + para.cookiePath + '"';
			else
				loc_cookie = '"' + '",' + para.cookieExpiry + ',"' + para.cookiePath + '"';
			
			loc_a.setAttribute('onclick', '$.fn.gcjs_themeswitcher_dialog.gcjs_m_loaddynamicalfile(' + loc_link + loc_cookie + ')' ); 
			loc_img.setAttribute('onclick', '$.fn.gcjs_themeswitcher_dialog.gcjs_m_loaddynamicalfile(' + loc_link + loc_cookie + ')' ); 

			loc_tn = document.createTextNode($.fn.gcjs_themeswitcher_dialog.css_list[i].theme);
			//		loc_tn.style.text-Align = "center";
			loc_a.appendChild(loc_tn);

			loc_td = document.createElement("td");
			
			loc_td.appendChild(loc_img);
			loc_row.appendChild(loc_td);
			
			loc_td = document.createElement("td");
		//	loc_td.appendChild(loc_br);
			loc_td.appendChild(loc_a);
			loc_row.appendChild(loc_td);

		//	

			if ((rr == rowlen) || ((i + 1) == $.fn.gcjs_themeswitcher_dialog.css_list.length)) {
				loc_tbod.appendChild(loc_row);
				loc_row = null;
				loc_row = document.createElement("tr");
				rr = 0;
			}
	
		}
		loc_table.appendChild(loc_tbod);

		$.fn.gcjs_themeswitcher_dialog.switcher = $("<div id='themedialog'></div>")
			.append(loc_table)
			.dialog({
				modal: $.fn.gcjs_themeswitcher_dialog.parameters.modal,
				autoOpen: false,
				 buttons: [{
					 id:"theme_close",
					 text:"Close",
					click :function () {
						$(this).dialog("close");
					}
				}],
				hide: 'fade',
       			 show: 'fade',
				closeOnEscape: true,
				dialogClass: "alert",
				width: winwidth,
				height:300,
				title: $.fn.gcjs_themeswitcher_dialog.parameters.s_title});
	

		return this.each(function() {
			$(this).click(function() {
          		$.fn.gcjs_themeswitcher_dialog.gcjs_m_open_themeswitch_dialog();  }); 
		});

	};


	// plugin variables
	$.fn.gcjs_themeswitcher_dialog.parameters = {
		version: '1.01', 
		s_title: "Select UI theme",
		modal: false,
		url_gallery: "libraries/jquery/themes_switcher/themes/theme_gallery/",   
		url_css: "libraries/jquery/themes_switcher/themes/theme_css/",         
		defaultTheme: "black/theme.php",
		width_piccell: 100,
		number_pics: 6,
		setcookie: true, 
		cookieExpiry: "365", 
		cookiePath: "/",  
		cookieDomain: "GCJS_THEME",
	};

	// empty array, to be filled on creation of plugin
	$.fn.gcjs_themeswitcher_dialog.css_list = [];

	// DOM dialog
	$.fn.gcjs_themeswitcher_dialog.switcher;


	// callback function to call dialog box
	$.fn.gcjs_themeswitcher_dialog.gcjs_m_open_themeswitch_dialog = function (){

		$.fn.gcjs_themeswitcher_dialog.switcher.dialog("open");
		if ($('#themeimg').length==0){
		$('#themedialog').parent().find('.ui-dialog-titlebar').prepend('<img id="themeimg" src="images/admin/themes.png" style="height:16px;width:16px;float:left;padding-right:3px" />');}
		
		
		
		
		
		return false;
	};


	// method to add new theme css files
	$.fn.gcjs_themeswitcher_dialog.gcjs_m_add_theme = function (themefileobject){

		this.css_list.push(themefileobject);

		return this;
	};


	// on load of page: load either saved css from cookie or use a default css
	$.fn.gcjs_themeswitcher_dialog.gcjs_m_load_initial_css = function (filename ){

		filename=$.trim(filename);
		if (!filename){
			filename =  $.cookie($.fn.gcjs_themeswitcher_dialog.parameters.cookieDomain);
			if (filename){
				filename = decodeURI(filename)};
		};

		if (!filename){
			filename =  $.fn.gcjs_themeswitcher_dialog.parameters.url_css + $.fn.gcjs_themeswitcher_dialog.parameters.defaultTheme; 
		};

	 	var fileref=document.createElement("link");
	  	fileref.setAttribute("rel", "stylesheet");
	  	fileref.setAttribute("type", "text/css");
	  	fileref.setAttribute("href", filename);

	 	if (typeof fileref!="undefined"){
	  		document.getElementsByTagName("head")[0].appendChild(fileref);
		};
	};


	// used to load dynamically the locatization support files
	$.fn.gcjs_themeswitcher_dialog.gcjs_m_loaddynamicalfile = function (filename, cookie, expire, cpath){
	
		if (filename == "?"){
			filename =  $.cookie(cookie);
			filename = decodeURI(filename);
		};

	 	var fileref=document.createElement("link");
	  	fileref.setAttribute("rel", "stylesheet");
	  	fileref.setAttribute("type", "text/css");
	  	fileref.setAttribute("href", filename);

	 	if (typeof fileref!="undefined"){
	  		document.getElementsByTagName("head")[0].appendChild(fileref);

			if (cookie != ""){
				filename = encodeURI(filename);
		  		$.cookie(cookie, filename, { expires: expire, path: cpath });
			};
		};
	};
	
}) (jQuery);


