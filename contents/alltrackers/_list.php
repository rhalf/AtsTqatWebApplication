<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
?>
<div class="ui-widget-content" style="border:none">
    <form id="<?php echo $module ?>form" name="<?php echo $module ?>form">
        <table id="<?php echo $module ?>list"></table>
        <div id="<?php echo $module ?>pager"></div>
        <select name="<?php echo $module ?>groupby" id="<?php echo $module ?>groupby" style="width:145px">
            <option value="company"><?php echo constant($module . "Company"); ?></option>
            <option value="Ownername"><?php echo constant($module . "Owner"); ?></option>
            <option value="Unitpassword"><?php echo constant($module . "UnitPassword"); ?></option>
            <option value="tprovider"><?php echo constant($module . "Provider"); ?></option>
            <option value="Type"><?php echo constant($module . "Type"); ?></option>
            <option value="dbHost"><?php echo constant($module . "DBHost"); ?></option>
            <option value="clear"  selected="selected"><?php echo Clear ?></option>
        </select>
        <a id="<?php echo $module ?>groupbylbl"> <?php echo GroupBy ?> </a>
        <div style="float:left" id="<?php echo $module ?>frozendiv">
            <input type="checkbox" id="<?php echo $module ?>frozen"/><label for="<?php echo $module ?>frozen"><?php echo FreezeColumns ?></label>
        </div>
    </form>
</div>
<script type="text/javascript">
    var <?php echo $module ?>loaded = false;
    var <?php echo $module ?>data,<?php echo $module ?>rowdata;
</script>
<script type="text/javascript">
    function <?php echo $module ?>Export() {
        var exclude = new Array();
        var model = $("#<?php echo $module ?>list").getGridParam('colModel');
        $.each(model, function(i) {
            if (this.hidden == true || this.name == 'act' || this.hidedlg == true || this.name == 'rn') {
                exclude.push(i);
            }
        });
        var extras = {};
        ExportToExcel('<?php echo $module ?>',<?php echo $module ?>data, exclude, extras);
        return false;
    }
    ;


    function <?php echo $module ?>Reload() {
        $("#<?php echo $module ?>list").setGridParam({datatype: 'json', page: 1}).trigger('reloadGrid');
    }

    function <?php echo $module ?>Search() {
        $("#<?php echo $module ?>list").jqGrid('searchGrid', {modal: true, closeOnEscape: true, sopt: ['cn', 'bw', 'eq', 'ne', 'ew'], multipleSearch: true, overlay: false});
        var searchDialog = $("#searchmodfbox_" + "<?php echo $module ?>list");
        searchDialog.css({position: "relative", "z-index": $('#<?php echo $module ?>dialog').parent().css('z-index') + 1});
        $('#searchmodfbox_<?php echo $module ?>list').css('top', ($('body').height() / 2) - ($('#searchmodfbox_<?php echo $module ?>list').height() / 2));
        $('#searchmodfbox_<?php echo $module ?>list').css('left', ($('body').width() / 2) - ($('#searchmodfbox_<?php echo $module ?>list').width() / 2));

        if ($('#fbox_<?php echo $module ?>list_cancel').length == 0) {

            $('#fbox_<?php echo $module ?>list_search').parent().append('<a href="javascript:void(0)" id="fbox_<?php echo $module ?>list_cancel" class="fm-button ui-state-default ui-corner-all fm-button-icon-left ui-reset"><span class="ui-icon ui-icon-close"></span><?php echo Close ?></a>')
        }
        $('#fbox_<?php echo $module ?>list_reset').prependTo($('#fbox_<?php echo $module ?>list_search').parent());
        $('#fbox_<?php echo $module ?>list_search').removeClass('fm-button-icon-right').addClass('fm-button-icon-left');

        $("#fbox_<?php echo $module ?>list_cancel").hover(
                function() {
                    $(this).addClass('ui-state-hover');
                },
                function() {
                    $(this).removeClass('ui-state-hover');
                }
        );
        $("#fbox_<?php echo $module ?>list_cancel").click(function(e) {
            $("#searchmodfbox_" + "<?php echo $module ?>list").find("a.ui-jqdialog-titlebar-close").trigger('click');
        });

        $("#<?php echo $module ?>list").jqGrid('searchGrid', {afterShowSearch: function() {
                fixSearch();
            }});
        $("#<?php echo $module ?>list").jqGrid('searchGrid', {beforeShowSearch: function() {
                fixSearch();
            }});
        $('.delete-rule').bind("click", function() {
            fixSearch();
        });
        $('.add-rule').bind("click", function() {
            fixSearch();
        });
        $('#fbox_<?php echo $module ?>list_search').bind("click", function() {
            fixSearch();
        });
        $('#fbox_<?php echo $module ?>list_reset').bind("click", function() {
            fixSearch();
        });


    }
    ;

    function <?php echo $module ?>Columns() {
        $("#<?php echo $module ?>list").jqGrid('columnChooser', {modal: true});
        $('#colchooser_<?php echo $module ?>list').parent().find('.ui-dialog-buttonpane').find('.ui-dialog-buttonset').find('.ui-button').first().button({icons: {primary: "ui-icon-check"}}).next().button({icons: {primary: "ui-icon-circle-close"}});
        $("#<?php echo $module ?>list").jqGrid('columnChooser', {
            done: function(perm) {
                if (perm) {
                    // "OK"
                    this.jqGrid("remapColumns", perm, true);
                    var gwdth = $("#t_<?php echo $module ?>list").jqGrid("getGridParam", "width");
                    $("#t_<?php echo $module ?>list").jqGrid("setGridWidth", gwdth);
                } else {
                    // "Cancel"
                }
            }
        });
    }
    ;

    function <?php echo $module ?>Close() {
        $('#alertmod_<?php echo $module ?>list').remove();
        $('#<?php echo $module ?>groupby').selectmenu('destroy');
        $('#<?php echo $module ?>pager').find('.ui-pg-selbox').selectmenu('destroy');
        $("#<?php echo $module ?>list").jqGrid('GridDestroy');
<?php echo $module ?>Dialog.Close();
    }

    function <?php echo $module ?>Add() {
        create_<?php echo $module_add ?>();
        return false;
    }

    function <?php echo $module ?>Edit(id) {
        create_<?php echo $module_edit ?>(id, '');
        return false;
    }

    function <?php echo $module ?>Resize() {
        $("#<?php echo $module ?>list").jqGrid("setGridWidth", $('#<?php echo $module ?>dialog').width());
        $("#<?php echo $module ?>list").jqGrid("setGridHeight", $('#<?php echo $module ?>dialog').height() - 110);
    }
    ;

    function <?php echo $module ?>Frozen() {
        $("#<?php echo $module ?>list").jqGrid('setFrozenColumns');
<?php echo $module ?>loaded = true;
    }

    $().ready(function() {

        $("#<?php echo $module ?>list").jqGrid({
            url: 'contents/alltrackers/_xml.php',
            mtype: 'GET',
            datatype: 'json',
            colNames: ['', 'id', '<?php echo constant($module . "Company"); ?>', '<?php echo constant($module . "VehicleReg"); ?>', '<?php echo constant($module . "DriverName"); ?>', '<?php echo constant($module . "Owner"); ?>', '<?php echo constant($module . "Model"); ?>', '<?php echo constant($module . "Unit"); ?>', '<?php echo constant($module . "SimNo"); ?>', '<?php echo constant($module . "UnitPassword"); ?>', '<?php echo constant($module . "Provider"); ?>', '<?php echo constant($module . "Type"); ?>', '<?php echo constant($module . "DBHost"); ?>', '<?php echo constant($module . "CreateDate"); ?>', '<?php echo constant($module . "DBName"); ?>', '<?php echo constant($module . "Inputs"); ?>', '<?php echo constant($module . "SpeedLimit"); ?>', '<?php echo constant($module . "MileageLimit"); ?>', '<?php echo constant($module . "VehicleRegExpiry"); ?>', '<?php echo constant($module . "TrackerExpiry"); ?>', '<?php echo constant($module . "MileageInit"); ?>', '<?php echo constant($module . "IdlingTime"); ?>', '<?php echo constant($module . "Note"); ?>'],
            colModel: [
                {name: 'act', index: 'act', width: 75, sortable: false, search: false, align: 'center', stype: 'none', frozen: true, hidedlg: true},
                {name: 'id', index: 'id', width: 90, align: 'center', sortable: true, search: true, stype: 'text', frozen: true, hidden: true, hidedlg: true},
                {name: 'company', index: 'company', width: 90, align: 'center', sortable: true, search: true, stype: 'text', frozen: true},
                {name: 'VehicleReg', index: 'VehicleReg', width: 90, align: 'center', sortable: true, search: true, stype: 'text', frozen: true},
                {name: 'Drivername', index: 'Drivername', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'Ownername', index: 'Ownername', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'vehiclemodel', index: 'vehiclemodel', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'UnitID', index: 'UnitID', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'SimNo', index: 'SimNo', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'Unitpassword', index: 'Unitpassword', width: 120, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'tprovider', index: 'tprovider', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'Type', index: 'Type', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'dbHost', index: 'dbHost', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'createdate', index: 'createdate', width: 110, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'tdbs', index: 'tdbs', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'tinputs', index: 'tinputs', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'tspeedlimit', index: 'tspeedlimit', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'tmileagelimit', index: 'tmileagelimit', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'tvehicleregexpiry', index: 'tvehicleregexpiry', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'ttrackerexpiry', index: 'ttrackerexpiry', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'tmileageInit', index: 'tmileageInit', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'tidlingtime', index: 'tidlingtime', width: 80, align: 'center', sortable: true, search: true, stype: 'text'},
                {name: 'tnote', index: 'tnote', width: 80, align: 'center', sortable: true, search: true, stype: 'text'}
            ],
            direction: '<?php echo text_direction ?>',
            paging: true,
            rowNum: 10,
            rowTotal: 2000,
            rowList: [10, 20, 30, 50, 100, 200],
            pager: '#<?php echo $module ?>pager',
            rownumbers: true,
            rownumWidth: 40,
            sortname: 'VehicleReg',
            sortorder: 'asc',
            autowidth: true,
            gridview: true,
            autoheight: true,
            width: 'auto',
            height: '325px',
            viewrecords: true,
            toolbar: [true, "bottom"],
            loadonce: true,
            shrinkToFit: false,
            gridComplete: function() {
                var ids = $("#<?php echo $module ?>list").jqGrid('getDataIDs');
                for (var i = 0; i < ids.length; i++) {
                    var cl = ids[i];
                    var ret = $("#<?php echo $module ?>list").jqGrid('getRowData', ids[i]);
                    be = "<a  href=\"#\" onclick=\"javascript:<?php echo $module ?>Edit('" + ret.UnitID + "');\"><font color=\"#0066CC\" size=\"2px\"><?php echo Edit ?></font></a>";
                    $("#<?php echo $module ?>list").jqGrid('setRowData', ids[i], {act: be});
                }
<?php echo $module ?>Resize();

            },
            loadComplete: function(data) {
                if ($("#<?php echo $module ?>list").jqGrid('getGridParam', 'url') != '') {
                    if (data.cols) {
<?php echo $module ?>rowdata = data;
                    } else {
                        for (i in data.rows) {
                            data.rows[i].act = '';
                        }
                        ;
                        data['cols'] =<?php echo $module ?>rowdata.cols;
                        for (i in data.rows) {
                            if (("cell" in data.rows[i])) {
                                delete	data.rows[i]["cell"];
                            }
                            for (j in data.rows[i]) {
                                if (!("cell" in data.rows[i])) {
                                    data.rows[i]["cell"] = [];
                                }
                                if (j != "_id_") {
                                    data.rows[i]["cell"].push(data.rows[i][j]);
                                }
                            }
                        }


                    }
<?php echo $module ?>data = data;
                    fixPositionsOfFrozenDivs.call(this);
                }
            }
        });
        $('#<?php echo $module ?>dialog').bind("dialogresize", function(event, ui) {
<?php echo $module ?>Resize();
        });

        $("#<?php echo $module ?>list").jqGrid('navGrid', '#<?php echo $module ?>pager', {add: false, edit: false, del: false, search: false, refresh: false});

        $("#t_<?php echo $module ?>list").css('height', '32px');
        $("#<?php echo $module ?>pager").css('height', '32px');

        $('.ui-pg-selbox option').addClass('ui-widget-content');
        $('.ui-pg-input').css('width', '70px');
        $('.ui-pg-input').addClass('inputstyle');

        $("#t_<?php echo $module ?>list").append($("#<?php echo $module ?>frozendiv"));

        $("#<?php echo $module ?>frozen").click(function() {
            var lbl = $("label[for='" + $(this).attr('id') + "']")
            if (lbl.attr('aria-pressed') == 'true') {
                $("#<?php echo $module ?>list").jqGrid('setFrozenColumns');
                $('.jspDrag').addClass('ui-widget-header');
                $('.jspDrag').css('border', 'none');
<?php echo $module ?>Reload();
            } else {
                $("#<?php echo $module ?>list").jqGrid('destroyFrozenColumns');
                $('#gview_<?php echo $module ?>list').find('.frozen-bdiv').remove();
                $('#gview_<?php echo $module ?>list').find('.frozen-div').remove();
            }
        })


        $("#t_<?php echo $module ?>list").append($("#<?php echo $module ?>groupbylbl"));
        $("#t_<?php echo $module ?>list").append($("#<?php echo $module ?>groupby"));
        $("#<?php echo $module ?>groupby").change(function() {

            var vl = $(this).val();
            if (vl) {
                if (vl == "clear") {
                    $("#<?php echo $module ?>list").jqGrid('groupingRemove', true).trigger('reloadGrid');
                } else {
                    $("#<?php echo $module ?>list").jqGrid('groupingRemove', true).trigger('reloadGrid');
                    var GroupOption = new Object();
                    var groupField = [];
                    groupField.push(vl);
                    GroupOption.groupField = groupField;
                    GroupOption.groupColumnShow = true;
                    GroupOption.groupCollapse = false;
                    GroupOption.groupText = ['<b>{0} - {1} <?php echo TrackerCount ?></b>'];
                    //GroupOption.groupDataSorted= true;
                    $("#<?php echo $module ?>list").setGridParam({groupingView: GroupOption});
                    //$("#trackerslist").setGridParam({datatype:'json', page:1});
                    //$("#trackerslist").setGridParam({rownumbers:false});
                    $("#<?php echo $module ?>list").setGridParam({grouping: true}).trigger('reloadGrid');
                    //$("#trackerslist").setGridParam({loadonce:false}).trigger('reloadGrid');
                    groupField.length = 0;
                    GroupOption.length = 0;
                    //$("#trackerslist").jqGrid('groupingGroupBy',vl).trigger('reloadGrid');
                }
            }
        });

//jQuery("#trackerslist").jqGrid('setFrozenColumns');

    });

<?php echo $module ?>Dialog.addButton('<?php echo $module ?>add', '<?php echo Add ?>', '<?php echo $module ?>Add', 'add');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>columns', '<?php echo Columns ?>', '<?php echo $module ?>Columns', 'columns');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>search', '<?php echo Search ?>', '<?php echo $module ?>Search', 'search');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>reload', '<?php echo Reload ?>', '<?php echo $module ?>Reload', 'reload');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>export', '<?php echo Export ?>', '<?php echo $module ?>Export', 'export');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>close', '<?php echo Close ?>', '<?php echo $module ?>Close', 'close');

<?php echo $module ?>Dialog.setOption('title', '<?php echo AllTrackers ?>');

    $('#<?php echo $module ?>groupby').selectmenu();
    $('#<?php echo $module ?>frozen').button({icons: {primary: "ui-icon-locked"}});
    $('.ui-pg-selbox').selectmenu({width: 75});
    $('.ui-pg-input').css('height', '30px');

</script>