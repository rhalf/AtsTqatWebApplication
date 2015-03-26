function hideLoadingLayer() {
    document.getElementById("loading_layer").style.visibility = "hidden";
}
;



function ResizeSouthPane(h) {
    myLayout.sizePane('south', h);
}
;




function InitSite() {
    $('#maintop').load(("main/main_top.php"));
    $('#rightdiv').load(("main/get_menu_trackers.php"));
    $('#trackinggrid').load(("main/main_buttom.php"));
}
;

$(document).ready(function() {
    // load default css
    $.fn.gcjs_themeswitcher_dialog.gcjs_m_load_initial_css("");

    //$('select option').addClass('ui-widget-content');
});


setInterval(function() {
    CheckUserOnline();
}, 300000);



function TrackerObject() {
    this.Mobile = false;
    this.Unit;
    this.Driver;
    this.Vehicle;
    this.Type;
    this.TrackerImage;
    this.Inputs;
    this.SpeedLimit;
    this.MileageLimit;
    this.MileageInit;
    this.MileageReset;
    this.Http;
    this.TrackerExpiry;
    this.VehicleregExpiry;
    this.Administrator;
}
;

function HTTPClass() {
    this.id = [];
    this.name = [];
    this.ip = [];
    this.liveport = [];
    this.cmdport = [];

    this.Clear = function() {
        this.id.length = 0;
        this.name.length = 0;
        this.ip.length = 0;
        this.liveport.length = 0;
        this.cmdport.length = 0;
    };

    this.add = function(a, b, c, d, e) {
        this.id.push(a);
        this.name.push(b);
        this.ip.push(c);
        this.liveport.push(d);
        this.cmdport.push(e);
    };
    this.getIP = function(i) {
        return this.ip[this.id.indexOf(i)];
    };
    this.getLivePort = function(i) {
        return this.liveport[this.id.indexOf(i)];
    };
    this.getCmdPort = function(i) {
        return this.cmdport[this.id.indexOf(i)];
    };
}
;
var Http = new HTTPClass();


function build_popups() {

    $(".section-popup").hide();
    $(".ui-icon-wrench").click(function() {
        $(this).next().show().position({
            my: "right centre",
            at: "left bottom",
            of: this
        });
        $(this).next().show();
    });
    $(".section-popup").bind('mouseleave', function() {
        $(this).hide();
    });
    $(".ui-icon-wrench").parent().bind('mouseleave', function() {
        $(this).find(".ui-icon-wrench").next().hide();
    });

    $(".tracker-popup").hide();
    $(".context").click(function() {
        $(this).next().show().position({
            my: "right bottom",
            at: "left bottom",
            of: this
        });
        $(this).next().show();
    });
    $(".tracker-popup").bind('mouseleave', function() {
        $(this).hide();
    });
    $(".context").parent().bind('mouseleave', function() {
        $(this).find(".context").next().hide();
    });

}


$.noty.defaultOptions = {
    layout: 'bottomLeft', // (top, topLeft, topCenter, topRight, bottom, center, bottomLeft, bottomRight)
    theme: 'noty_theme_default', // theme name (accessable with CSS)
    animateOpen: {height: 'toggle'}, // opening animation
    animateClose: {height: 'toggle'}, // closing animation
    easing: 'swing', // easing
    text: '', // notification text
    type: 'alert', // noty type (alert, success, error)
    speed: 500, // opening & closing animation speed
    timeout: 5000, // delay for closing event. Set false for sticky notifications
    closeButton: false, // enables the close button when set to true
    closeOnSelfClick: true, // close the noty on self click when set to true
    closeOnSelfHover: false, // close the noty on self mouseover when set to true
    force: false, // adds notification to the beginning of queue when set to true
    onShow: false, // callback for on show
    onClose: false, // callback for on close
    buttons: false, // an array of buttons
    modal: false, // adds modal layer when set to true
    template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
    cssPrefix: 'noty_', // this variable will be a type and layout prefix.
    custom: {
        container: null // $('.custom_container')
    }
};


function download(filename) {
    window.location = 'contents/download/_cmd.php?file=' + filename;

}
;

function ExportToExcel(fname, obj, exclude, extras) {
    var url = 'connect/_xlsx.php';
    var params = {data: JSON.stringify(obj), filename: fname, exclude: JSON.stringify(exclude), extras: JSON.stringify(extras)};
    var form = $('<form method="POST" action="' + url + '">');
    $.each(params, function(k, v) {
        form.append($('<input type=\'hidden\' name=\'' + k + '\' value=\'' + v + '\'>'));
    });
    $('body').append(form);
    form.submit().remove();
}
;

function fixSearch(mod) {
    $('.opsel').find('option').addClass('ui-widget-content');
    $('.selectopts').find('option').addClass('ui-widget-content');
    $('.columns').find('select').find('option').addClass('ui-widget-content');
    if (!$('.delete-rule').hasClass('ui-button')) {
        $('.delete-rule').button();
    }
    if (!$('.add-rule').hasClass('ui-button')) {
        $('.add-rule').button();
    }
    if (!$('.input-elm').hasClass('inputstyle')) {
        $('.input-elm').addClass('inputstyle');
    }
    if (!$('.opsel').hasClass('selectmenu')) {
        $('.opsel').addClass('selectmenu');
        $('.opsel').selectmenu({width: 150});
    }
    if (!$('.selectopts').hasClass('selectmenu')) {
        $('.selectopts').addClass('selectmenu');
        $('.selectopts').selectmenu({width: 150});
    }

    $(".columns").children().each(function(index, element) {
        if ($(element).is('select')) {
            if (!$(element).hasClass('selectmenu')) {
                $(element).addClass('selectmenu');
                $(element).selectmenu({width: 150});
            }
        }
    });


    $(".data").children().each(function(index, element) {
        if ($(element).is('select')) {
            if (!$(element).hasClass('selectmenu')) {
                $(element).addClass('selectmenu');
                $(element).selectmenu({width: 75});
            }
        }
    });


    $('.delete-rule').bind("click", function() {
        fixSearch(mod);
    });
    $('.add-rule').bind("click", function() {
        fixSearch(mod);
    });
    $('#fbox_' + mod + 'list_search').bind("click", function() {
        fixSearch(mod);
    });
    $('#fbox_' + mod + 'list_reset').bind("click", function() {
        fixSearch(mod);
    });
    $('.columns').find('select').bind("change", function() {
        fixSearch(mod);
    });
}
;


fixPositionsOfFrozenDivs = function() {
    var $rows;
    if (this.grid.fbDiv !== undefined) {
        $rows = $('>div>table.ui-jqgrid-btable>tbody>tr', this.grid.bDiv);
        $('>table.ui-jqgrid-btable>tbody>tr', this.grid.fbDiv).each(function(i) {
            var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
            if ($(this).hasClass("jqgrow")) {
                $(this).height(rowHight);
                rowHightFrozen = $(this).height();
                if (rowHight !== rowHightFrozen) {
                    $(this).height(rowHight + (rowHight - rowHightFrozen));
                }
            }
        });
        $(this.grid.fbDiv).height(this.grid.bDiv.clientHeight);
        $(this.grid.fbDiv).css($(this.grid.bDiv).position());
    }
    if (this.grid.fhDiv !== undefined) {
        $rows = $('>div>table.ui-jqgrid-htable>thead>tr', this.grid.hDiv);
        $('>table.ui-jqgrid-htable>thead>tr', this.grid.fhDiv).each(function(i) {
            var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
            $(this).height(rowHight);
            rowHightFrozen = $(this).height();
            if (rowHight !== rowHightFrozen) {
                $(this).height(rowHight + (rowHight - rowHightFrozen));
            }
        });
        $(this.grid.fhDiv).height(this.grid.hDiv.clientHeight);
        $(this.grid.fhDiv).css($(this.grid.hDiv).position());
    }
};


function build_menus() {
    $(".checktoggle").button().next().button({
        text: false,
        icons: {
            primary: "ui-icon-triangle-1-s"
        }
    }).parent().buttonset().next().hide().menu();

    $(".select").click(function() {
        $(this).parent().next().show().position({
            my: "left top",
            at: "left bottom",
            of: this
        });
        $(this).parent().next().show();
    });

    $(".select").parent().parent().bind('mouseleave', function() {
        $(this).find(".select").parent().next().hide();
    });
}

var setupDialog = new dialogClass();
var LoginDialog = new dialogClass();
var MessageDialog = new dialogClass();
var ConfirmDialog = new dialogClass();

function create_login() {
    var o = {
        name: 'login',
        height: 250,
        width: 400,
        transparent: true,
        htmllink: "connect/login.php",
        imagelink: '',
        hideclose: true
    };
    LoginDialog.setParams(o);
    LoginDialog.createDialog(true);

}

function geturl(addr) {
    var r = $.ajax({
        type: 'GET',
        url: addr,
        async: false
    }).responseText;
    return r;
}

function CheckUserOnline() {
    var u = 'connect/users_online.php';
    $.ajax({
        type: 'GET',
        url: u,
        success: function(data) {
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        }
    });
}
;

// Status Message	
function ShowMessage(value) {
    if (value != '') {
        var o = {
            name: 'message',
            height: 'auto',
            width: 'auto',
            htmllink: '',
            html: value,
            imagelink: '',
            hideclose: true,
            hideheader: true,
            hasdiv: false
        };
        MessageDialog.setParams(o);
        MessageDialog.createDialog(true);
        window.setTimeout(function() {
            MessageDialog.Close();
        }, 3000);
    }
}
;
// Status Message   
function ShowMessageClose(value) {
    if (value != '') {
        var o = {
            name: 'message',
            height: 'auto',
            width: 'auto',
            htmllink: '',
            html: value,
            imagelink: '',
            hideclose: true,
            hideheader: true,
            hasdiv: true
        };
        MessageDialog.setParams(o);
    }
}
;

function ConfirmationDialog() {
    var o = {
        name: 'Confirm',
        height: 'auto',
        width: 'auto',
        htmllink: 'contents/commands/_confirm.php',
        imagelink: '',
        hideclose: true,
        hasdiv: false
    };
    ConfirmDialog.setParams(o);
    ConfirmDialog.createDialog(true);
}

function getIconsOptions() {
    var poptions = '';
    for (var i = 0; i <= 18; i++) {
        poptions += "<option value = '" + i + "' data-imagesrc= " + DefaultSettings.imgsrc + "icon_" + i + '_driver.gif' + " ></option>";
    }
    return poptions;
}
;

function getMapOptions() {
    var selectOptions = '<option value="0" >' + Auto_LBL + '</option>';
    if (MapClass.tabs) {
        for (i in MapClass.tabs) {
            selectOptions += '<option value="' + MapClass.tabs[i] + '">' + MapClass.tabs[i] + '</option>';
        }
    }
    $('.section-map').html('');
    $('.section-map').html(selectOptions);
}

function removeByIndex(arrayName, arrayIndex) {
    arrayName.splice(arrayIndex, 1);
    return false;
}


function removeByValue(arr, val) {
    for (var i = 0; i < arr.length; i++) {
        if (arr[i] == val) {
            arr.splice(i, 1);
            break;
        }
    }
    return false;
}
;

function setSectionMap(section, map) {
    if (section == 0) {
        section = 'search';
    }
    var c = $('#result' + section).find('input[class^="map"]');
    for (var i = 0; i < c.length; i++) {
        if (c[i].type == 'hidden') {
            var unclass = c[i].className;
            $('.' + unclass).val(map);
        }
    }
}
;

function setTrackerMap(id, map) {
    $('.map' + id).val(map);
    $('.select' + id).val(map);
}
;

function setCheck(un, check) {
    if (check) {
        $('.' + un).prop('checked', true);
    } else {
        $('.' + un).prop('checked', false);
    }
}
;

function selectOption(id) {
    if ($('.chb' + id).is(':checked')) {
        if (RealTimeClass.TrackedID != id) {
            var old = $('.div' + RealTimeClass.TrackedID);
            if (old.is('.ui-widget-content')) {
                old.removeClass('ui-widget-content');
                old.addClass('ui-state-default');
            }
        }
        var co = $('.div' + id);
        if (co.is('.ui-widget-content')) {
            co.removeClass('ui-widget-content');
            co.addClass('ui-state-default');
            RealTimeClass.TrackedID = '';
        } else {
            co.removeClass('ui-state-default');
            co.addClass('ui-widget-content');
            RealTimeClass.TrackedID = id;
        }
    }
}
;


function spryDestroy(spry) {
    if (spry && spry.destroy) {
        spry.reset();
        spry.resetClasses();
        spry.destroy();
        spry = null;
    }
}

function search_trackers() {
    $("#resultsearch").html('');
    $('div[class*="' + $('#searchbox').val().toLowerCase() + '"][class^="tit"]').clone(true, true).appendTo('#resultsearch');
}
;


function LoadMore(id, count) {
    var u = 'connect/_loadmore.php?id=' + id + '&count=' + count;
    $.ajax({
        type: 'GET',
        url: u,
        success: function(data) {
            if (parseInt($('.count' + id).val()) <= parseInt($('.load' + id).val())) {
                $('.load' + id).attr('disabled', true).addClass('ui-state-disabled').removeClass('ui-state-hover');
            }
            $('#result' + id).append(data);
            build_popups();
            getMapOptions();
            $('.abutton').button();
            $('.mapchooser').html(MAP_LBL);
            $('.treplay').find('.ui-button-text').find('div').html(TRACKINGREPLAY_LBL);
            $('.tedit').find('.ui-button-text').find('div').html(EDIT_LBL);
            $('.tlocate').find('.ui-button-text').find('div').html(LOCATE_LBL);
            $('.tmileage').find('.ui-button-text').find('div').html(SETMILEAGE_LBL);
            $('.tlast').find('.ui-button-text').find('div').html(LASTPOSITION_LBL);
            $('.uedit').find('.ui-button-text').find('div').html(EDIT_LBL);
            $('.treplay').click(function(e) {
                var un = $(this).attr('class').split(' ')[2].split('tr')[1];
                create_trackingreplay(un);
            });

            $('.tmileage').click(function(e) {
                var un = $(this).attr('class').split(' ')[2].split('tmileage')[1];
                create_setmileage(un);
            });
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        }
    });
}
;


