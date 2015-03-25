	function toggleLiveResizing () {
		$.each('north,south,west,east'.split(','), function (i, pane) {
			var opts = myLayout.options[ pane ];
			opts.resizeWhileDragging = !opts.resizeWhileDragging;
		});
	};
	
	function toggleStateManagement ( skipAlert ) {
		var enable = !myLayout.options.useStateCookie; // OPPOSITE of current setting
		myLayout.options.useStateCookie = enable; // toggle option

		if (!enable) { // if disabling state management...
			myLayout.deleteCookie(); // ...clear cookie so will NOT be found on next refresh
			if (!skipAlert)
				alert( 'This layout will reload as options specify \nwhen the page is refreshed.' );
		}
		else if (!skipAlert)
			alert( 'This layout will save & restore its last state \nwhen the page is refreshed.' );

		// update text on button
		/*var $Btn = $('#btnToggleState'), text = $Btn.html();
		if (enable)
			$Btn.html( text.replace(/Enable/i, "Disable") );
		else
			$Btn.html( text.replace(/Disable/i, "Enable") );*/
	};

	// set EVERY 'state' here so will undo ALL layout changes
	// used by the 'Reset State' button: myLayout.loadState( stateResetSettings )
	var stateResetSettings = {
			north__size:		200
		,	north__initClosed:	false
		,	north__initHidden:	false
		,	south__size:		50
		,	south__initClosed:	false
		,	south__initHidden:	false
	//	,	west__size:			200
	//	,	west__initClosed:	false
	//	,	west__initHidden:	false
		,	east__size:			200
		,	east__initClosed:	false
		,	east__initHidden:	false
	};

	var myLayout;

	$(document).ready(function () {


		// this layout could be created with NO OPTIONS - but showing some here just as a sample...
		// myLayout = $('body').layout(); -- syntax with No Options
		myLayout = $('body').layout({
			    fxName:     "fade"
,   speed:      100 // optional
,   north__fxSettings: { direction: "vertical" }
,   east__fxSettings:  {direction: "vertical"} // empty fxSettings is still valid!
,   south__fxSettings:  {direction: "vertical"}
		//	enable showOverflow on west-pane so CSS popups will overlap north pane
,			west__showOverflowOnHover: true

		//	reference only - these options are NOT required because 'true' is the default
		,	closable:				true	// pane can open & close
		,	resizable:				true	// when open, pane can be resized 
		,	slidable:				true	// when closed, pane can 'slide' open over other panes - closes on mouse-out

		//	some resizing/toggling settings
		,	north__size:			    80	
		,	north__slidable:		false	// OVERRIDE the pane-default of 'slidable=true'
		,	north__resizable:		false	// OVERRIDE the pane-default of 'resizable=true'
//		,	north__togglerLength_closed: '100%'	// toggle-button is full-width of resizer-bar
		,	north__spacing_closed:	5		// big resizer-bar when open (zero height)
		,	south__resizable:		true	// OVERRIDE the pane-default of 'resizable=true'
		,	south__spacing_open:	5		// no resizer-bar when open (zero height)
		,	south__spacing_closed:	5		// big resizer-bar when open (zero height)
		//	some pane-size settings
	//	,	west__size:			    250		
	//	,	west__minSize:			200
		,	east__size:				310
		,	east__minSize:			310
		,	east__maxSize:			Math.floor(screen.availWidth / 2) // 1/2 screen width
		,	center__minWidth:		100
		,	south__size:			30
		,	useStateCookie:			false
		, onresize : function () {
		$("#listtrackersdata").setGridHeight($("#trackinggrid").height()-80);
		$("#listtrackersdata").setGridWidth($("#trackinggrid").width());
        // STOP the pane from opening
        return false; // false = Cancel
    }
		});
		
		// if there is no state-cookie, then DISABLE state management initially
		var cookieExists = !$.isEmptyObject( myLayout.readCookie() );
		if (!cookieExists) toggleStateManagement( true, false );

		
 	});	
	
