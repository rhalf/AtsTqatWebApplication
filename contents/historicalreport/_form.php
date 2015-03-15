<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
$TrackersResult = $session->get('trackers');
$TrackersArray = trackers_array($TrackersResult, $userid, $privilege);
?>

<div class="ui-widget-content" style="border:none">
    <form id="<?php echo $module ?>form" name="<?php echo $module ?>form" method="post">
        <table>

            <td width="145" align="center"><select name="trackerUnit" id="trackerUnit" style="width:145px">
                    <?php
                    foreach ($TrackersArray as $row) {
                        echo "<option class=\"ui-widget-content\" value = '" . $row["tunit"] . "'>" . $row["tvehiclereg"] . ' | ' . $row["tdrivername"] . "</option>";
                    }
                    ?>
                </select></td>
            <td width="17"><?php echo From ?></td>
            <td width="145"><input name="Searchdatefrom" id="Searchdatefrom" type="text" style="width:145px" class="inputstyle" ></td>
            <td width="17"><?php echo To ?></td>
            <td width="145"><input name="SearchdateTo" id="SearchdateTo" type="text" style="width:145px" class="inputstyle"></td>
            <td width="141"><button type="button" name="b" id="b" value="" onClick="setGridURL();" style="width:145px" ><?php echo Search; ?></button></td>
        </table>
        <table id="<?php echo $module ?>list">
        </table>
        <div id="<?php echo $module ?>pager"></div>
        <table>
            <tr class="ui-widget-content">
                <td><select name="<?php echo $module ?>groupby" id="<?php echo $module ?>groupby" style="width:145px">
                        <option value="gm_unit" ><?php echo Unit ?></option>
                        <option value="gm_signal"><?php echo Signal ?></option>
                        <option value="gm_state"><?php echo State ?></option>
                        <option value="gm_power"><?php echo Power ?></option>
                        <option value="gm_urgent"><?php echo Input1 ?></option>
                        <option value="gm_acc"><?php echo Input2 ?></option>
                        <option value="gm_custom1"><?php echo Input3 ?></option>
                        <option value="gm_cutoff"><?php echo Output1 ?></option>
                        <option value="gm_timeInterval"><?php echo Interval ?></option>
                        <option value="gm_overspeed"><?php echo Overspeed ?></option>
                        <option value="clear" selected="selected"><?php echo Clear ?></option>
                    </select>
                    <a id="<?php echo $module ?>groupbylbl" > <?PHP echo GroupBy; ?> </a>
                    <div style="float:left" id="<?php echo $module ?>frozendiv">
                        <input type="checkbox" id="<?php echo $module ?>frozen"/><label for="<?php echo $module ?>frozen"><?php echo FreezeColumns ?></label>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
    $().ready(function() {

        $("select#trackerUnit").selectmenu({width: 250});
        $("#b").button({icons: {primary: "ui-icon-check"}});
        $("#hr_close").button({icons: {primary: "ui-icon-close"}});

        $("#TrackingReplay").button();
        $('#Searchdatefrom').datetimepicker({
            dateFormat: 'dd/mm/yy',
            showSecond: true,
            timeFormat: 'hh:mm:ss',
        });
        $('#SearchdateTo').datetimepicker({
            dateFormat: 'dd/mm/yy',
            showSecond: true,
            timeFormat: 'hh:mm:ss'

        });

    });
</script>
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
        if ($("#<?php echo $module ?>list").jqGrid('getGridParam', 'url') != '') {
            $("#<?php echo $module ?>list").setGridParam({datatype: 'json', page: 1}).trigger('reloadGrid');
        }
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


            function <?php echo $module ?>Resize() {
                $("#<?php echo $module ?>list").jqGrid("setGridWidth", $('#<?php echo $module ?>dialog').width());
                $("#<?php echo $module ?>list").jqGrid("setGridHeight", $('#<?php echo $module ?>dialog').height() - 140);
            }
            ;

            function <?php echo $module ?>Frozen() {
                $("#<?php echo $module ?>list").jqGrid('setFrozenColumns');
<?php echo $module ?>loaded = true;
            }

            function setGridURL() {
                var dfromParts, TfromParts, dfrom, dtoParts, TtoParts, dto;
                dfromParts = $('#Searchdatefrom').val().split(" ")[0].split("/");
                TfromParts = $('#Searchdatefrom').val().split(" ")[1];
                dfrom = dfromParts[1] + '/' + dfromParts[0] + '/' + dfromParts[2] + ' ' + TfromParts;

                dtoParts = $('#SearchdateTo').val().split(" ")[0].split("/");
                TtoParts = $('#SearchdateTo').val().split(" ")[1];
                dto = dtoParts[1] + '/' + dtoParts[0] + '/' + dtoParts[2] + ' ' + TtoParts;

                var un = document.getElementById('trackerUnit').options[document.getElementById('trackerUnit').selectedIndex].value;
                jQuery('#<?php echo $module ?>list').jqGrid().setGridParam({url: 'contents/historicalreport/_xml.php?id=' + un
                            + '&fdate=' + Date.parse(dfrom)
                            + '&tdate=' + Date.parse(dto)
                }).setGridParam({datatype: 'json', page: 1}).trigger('reloadGrid');
            }
            ;

            $("#<?php echo $module ?>list").jqGrid({
                //   url:"get_position.php?no=2&uin1=290588721&uin2=290588721",
                url: '',
                mtype: 'GET',
                datatype: 'local',
                colNames: ['<?php echo Time ?>', '<?php echo Lat ?>', '<?php echo Long ?>', '<?php echo Address ?>', '<?php echo Speed ?>', '<?php echo Direction ?>', '<?php echo Signal ?>', '<?php echo State ?>', '<?php echo Power ?>', '<?php echo Input1 ?>', '<?php echo Input2 ?>', '<?php echo Input3 ?>', '<?php echo Input4 ?>', '<?php echo Input5 ?>', '<?php echo Output1 ?>', '<?php echo Output2 ?>', '<?php echo Output3 ?>', '<?php echo Output4 ?>', '<?php echo Output5 ?>', '<?php echo AD1 ?>', '<?php echo AD2 ?>', '<?php echo Geofence ?>', '<?php echo Mileage ?>', '<?php echo Interval ?>', '<?php echo Overspeed ?>', '<?php echo GPSQSignal ?>', '<?php echo GSMQSignal ?>'],
                colModel: [
                    {name: 'gm_time', index: 'gm_time', width: 120, align: 'center', frozen: true},
                    {name: 'gm_lat', index: 'gm_lat', width: 100, align: 'center'},
                    {name: 'gm_lng', index: 'gm_lng', width: 100, align: 'center'},
                    {name: 'gm_address', index: 'gm_address', width: 90, align: 'center'},
                    {name: 'gm_speed', index: 'gm_speed', width: 90, align: 'center'},
                    {name: 'gm_ori', index: 'gm_ori', width: 90, align: 'center'},
                    {name: 'gm_signal', index: 'gm_signal', width: 90, align: 'center'},
                    {name: 'gm_state', index: 'gm_state', width: 90, align: 'center'},
                    {name: 'gm_power', index: 'gm_power', width: 90, align: 'center'},
                    {name: 'gm_input1', index: 'gm_input1', width: 90, align: 'center'},
                    {name: 'gm_input2', index: 'gm_input2', width: 90, align: 'center'},
                    {name: 'gm_input3', index: 'gm_input3', width: 90, align: 'center'},
                    {name: 'gm_input4', index: 'gm_input4', width: 90, align: 'center'},
                    {name: 'gm_input5', index: 'gm_input5', width: 90, align: 'center'},
                    {name: 'gm_output1', index: 'gm_output1', width: 90, align: 'center'},
                    {name: 'gm_output2', index: 'gm_output2', width: 90, align: 'center'},
                    {name: 'gm_output3', index: 'gm_output3', width: 90, align: 'center'},
                    {name: 'gm_output4', index: 'gm_output4', width: 90, align: 'center'},
                    {name: 'gm_output5', index: 'gm_output5', width: 90, align: 'center'},
                    {name: 'gm_fuel', index: 'gm_fuel', width: 90, align: 'center'},
                    {name: 'gm_AD2', index: 'gm_AD2', width: 90, align: 'center'},
                    {name: 'gm_geofence', index: 'gm_geofence', width: 90, align: 'center'},
                    {name: 'gm_mileage', index: 'gm_mileage', width: 90, align: 'center'},
                    {name: 'gm_timeInterval', index: 'gm_timeInterval', width: 90, align: 'center'},
                    {name: 'gm_overspeed', index: 'gm_overspeed', width: 90, align: 'center'},
                    {name: 'gm_GPSQSignal', index: 'gm_GPSQSignal', width: 90, align: 'center'},
                    {name: 'gm_GSMQSignal', index: 'gm_GSMQSignal', width: 90, align: 'center'}
                ],
                direction: '<?php echo text_direction ?>',
                paging: true,
                rowNum: 10,
                rowTotal: 2000,
                rowList: [10, 20, 30, 50, 100, 200],
                pager: $('#<?php echo $module ?>pager'),
                //	sortname: 'gm_unit',
                rownumbers: true,
                rownumWidth: 40,
                autowidth: true,
                gridview: true,
                autoheight: true,
                width: 'auto',
                height: '325px',
                viewrecords: true,
                /*	   	grouping:true,
                 groupingView : {
                 groupField : ['gm_unit'],
                 groupText : ['<b>{0} - {1} Message(s)</b>'],
                 groupColumnShow : [true],
                 groupCollapse : false,
                 groupOrder: ['asc'],
                 groupSummary : [false],
                 groupDataSorted : true
                 },
                 width:'600px',
                 height:'200px',
                 viewrecords: true,*/
                loadonce: true,
                shrinkToFit: false,
                toolbar: [true, "bottom"],
//	sortorder: "desc",

                loadComplete: function(data) {

                    var Grid = $("#<?php echo $module ?>list");
                    var ids = Grid.jqGrid('getDataIDs');
                    for (var i = 0; i < ids.length; i++) {
                        var rowid = ids[i];
                        var aData = Grid.jqGrid('getRowData', rowid);

                        if (aData.gm_signal == '<?php echo On; ?>') {
                            Grid.setCell(rowid, 'gm_signal', '', {color: 'green'});
                        } else if (aData.gm_signal == 'n/a') {
                            Grid.setCell(rowid, 'gm_signal', '', {color: 'gray'});
                        } else {
                            Grid.setCell(rowid, 'gm_signal', '', {color: 'red'});
                        }

                        if (aData.gm_input1 == '<?php echo On; ?>') {
                            Grid.setCell(rowid, 'gm_input1', '', {color: 'green'});
                        } else if (aData.gm_input1 == 'n/a') {
                            Grid.setCell(rowid, 'gm_input1', '', {color: 'gray'});
                        } else {
                            Grid.setCell(rowid, 'gm_input1', '', {color: 'red'});
                        }

                        if (aData.gm_input2 == '<?php echo On; ?>') {
                            Grid.setCell(rowid, 'gm_input2', '', {color: 'green'});
                        } else if (aData.gm_input2 == 'n/a') {
                            Grid.setCell(rowid, 'gm_input2', '', {color: 'gray'});
                        } else {
                            Grid.setCell(rowid, 'gm_input2', '', {color: 'red'});
                        }

                        if (aData.gm_input3 == '<?php echo On; ?>') {
                            Grid.setCell(rowid, 'gm_input3', '', {color: 'green'});
                        } else if (aData.gm_input3 == 'n/a') {
                            Grid.setCell(rowid, 'gm_input3', '', {color: 'gray'});
                        } else {
                            Grid.setCell(rowid, 'gm_input3', '', {color: 'red'});
                        }

                        if (aData.gm_input4 == '<?php echo On; ?>') {
                            Grid.setCell(rowid, 'gm_input4', '', {color: 'green'});
                        } else if (aData.gm_input4 == 'n/a') {
                            Grid.setCell(rowid, 'gm_input4', '', {color: 'gray'});
                        } else {
                            Grid.setCell(rowid, 'gm_input4', '', {color: 'red'});
                        }

                        if (aData.gm_input5 == '<?php echo On; ?>') {
                            Grid.setCell(rowid, 'gm_input5', '', {color: 'green'});
                        } else if (aData.gm_input5 == 'n/a') {
                            Grid.setCell(rowid, 'gm_input5', '', {color: 'gray'});
                        } else {
                            Grid.setCell(rowid, 'gm_input5', '', {color: 'red'});
                        }

                        if (aData.gm_output1 == '<?php echo On; ?>') {
                            Grid.setCell(rowid, 'gm_output1', '', {color: 'green'});
                        } else if (aData.gm_output1 == 'n/a') {
                            Grid.setCell(rowid, 'gm_output1', '', {color: 'gray'});
                        } else {
                            Grid.setCell(rowid, 'gm_output1', '', {color: 'red'});
                        }

                        if (aData.gm_output2 == '<?php echo On; ?>') {
                            Grid.setCell(rowid, 'gm_output2', '', {color: 'green'});
                        } else if (aData.gm_output2 == 'n/a') {
                            Grid.setCell(rowid, 'gm_output2', '', {color: 'gray'});
                        } else {
                            Grid.setCell(rowid, 'gm_output2', '', {color: 'red'});
                        }

                        if (aData.gm_output3 == '<?php echo On; ?>') {
                            Grid.setCell(rowid, 'gm_output3', '', {color: 'green'});
                        } else if (aData.gm_output3 == 'n/a') {
                            Grid.setCell(rowid, 'gm_output3', '', {color: 'gray'});
                        } else {
                            Grid.setCell(rowid, 'gm_output3', '', {color: 'red'});
                        }

                        if (aData.gm_output4 == '<?php echo On; ?>') {
                            Grid.setCell(rowid, 'gm_output4', '', {color: 'green'});
                        } else if (aData.gm_output4 == 'n/a') {
                            Grid.setCell(rowid, 'gm_output4', '', {color: 'gray'});
                        } else {
                            Grid.setCell(rowid, 'gm_output4', '', {color: 'red'});
                        }

                        if (aData.gm_output5 == '<?php echo On; ?>') {
                            Grid.setCell(rowid, 'gm_output5', '', {color: 'green'});
                        } else if (aData.gm_output5 == 'n/a') {
                            Grid.setCell(rowid, 'gm_output5', '', {color: 'gray'});
                        } else {
                            Grid.setCell(rowid, 'gm_output5', '', {color: 'red'});
                        }

                        // gps state
                        if (aData.gm_state == '<?php echo High; ?>') {
                            Grid.setCell(rowid, 'gm_state', '', {color: 'blue'});
                        } else if (aData.gm_state == '<?php echo Short; ?>') {
                            Grid.setCell(rowid, 'gm_state', '', {color: 'yellow'});
                        } else if (aData.gm_state == '<?php echo Normal; ?>') {
                            Grid.setCell(rowid, 'gm_state', '', {color: 'green'});
                        } else if (aData.gm_state == '<?php echo Error; ?>') {
                            Grid.setCell(rowid, 'gm_state', '', {color: 'red'});
                        }

                        // Power
                        if (aData.gm_power == '<?php echo Off; ?>') {
                            Grid.setCell(rowid, 'gm_power', '', {color: 'red'});
                        } else if (aData.gm_power == '<?php echo Low; ?>') {
                            Grid.setCell(rowid, 'gm_power', '', {color: 'yellow'});
                        } else if (aData.gm_power == '<?php echo Normal; ?>') {
                            Grid.setCell(rowid, 'gm_power', '', {color: 'green'});
                        } else if (aData.gm_power == '<?php echo Error; ?>') {
                            Grid.setCell(rowid, 'gm_power', '', {color: 'red'});
                        }
                    }
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

                        },
                        gridComplete: function() {
<?php echo $module ?>Resize();
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
                                if ($("#<?php echo $module ?>list").jqGrid('getGridParam', 'url') != '') {
                                    $("#<?php echo $module ?>list").jqGrid('groupingRemove', true).trigger('reloadGrid');
                                }
                                //$("#trackerslist").setGridParam({loadonce:false}).trigger('reloadGrid');
                            } else {
                                //$("#trackerslist").jqGrid('groupingRemove',true);
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



                    $('#SearchdateTo').val("<?php echo setTime(time(), $timezone) ?>");
                    $('#Searchdatefrom').val("<?php echo date('d/m/Y H:i:s', strtotime('midnight')) ?>");

<?php echo $module ?>Dialog.addButton('<?php echo $module ?>columns', '<?php echo Columns ?>', '<?php echo $module ?>Columns', 'columns');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>search', '<?php echo Search ?>', '<?php echo $module ?>Search', 'search');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>reload', '<?php echo Reload ?>', '<?php echo $module ?>Reload', 'reload');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>export', '<?php echo Export ?>', '<?php echo $module ?>Export', 'export');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>close', '<?php echo Close ?>', '<?php echo $module ?>Close', 'close');


<?php echo $module ?>Dialog.setOption('title', '<?php echo HistoricalReport ?>');
            $('#<?php echo $module ?>groupby').selectmenu();
            $('#<?php echo $module ?>frozen').button({icons: {primary: "ui-icon-locked"}});
            $('.ui-pg-selbox').selectmenu({width: 75});
            $('.ui-pg-input').css('height', '30px');
<?php echo $module ?>Resize();
</script>