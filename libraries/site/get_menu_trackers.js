///////////////////////// direction_parsing
function direction_parsing(value) {
    if (parseFloat(value) == 0 || parseFloat(value) == 360) {
        return value + ' N';
    } else if (parseFloat(value) > 0 && parseFloat(value) < 90) {
        return value + ' NE';
    } else if (parseFloat(value) == 90) {
        return value + ' E';
    } else if (parseFloat(value) > 90 && parseFloat(value) < 180) {
        return value + ' SE';
    } else if (parseFloat(value) == 180) {
        return value + ' S';
    } else if (parseFloat(value) > 180 && parseFloat(value) < 270) {
        return value + ' SW';
    } else if (parseFloat(value) == 270) {
        return value + ' W';
    } else if (parseFloat(value) > 270 && parseFloat(value) < 360) {
        return value + ' NW';
    }
}
;


function getCommand(type, cmdtype) {
    if (type == '1' || type == '2' || type == '3') {
        switch (cmdtype) {
            case '1':
                return '30';
                break;
            case '2':
                return '34';
                break;
            case '3':
                return '3F';
                break;
            case '4':
                return '39';
                break;
            case '5':
                return '38';
                break;
            case '6':
                return '32';
                break;
            case '7':
                return '37';
                break;
        }
    } else if (type == '4') {
        switch (cmdtype) {
            case '1':
                return '4101';
                break;
            case '2':
                return '4102';
                break;
            case '3':
                return '4105';
                break;
            case '4':
                return '4115';
                break;
            case '5':
                return '4115';
                break;
            case '6':
                return '4902';
                break;
        }
    } else if (type == '5') {
        switch (cmdtype) {
            case '1':
                return 'A10';
                break;
            case '2':
                return 'A12';
                break;
            case '3':
                return 'B07';
                break;
            case '4':
                return 'C01';
                break;
            case '5':
                return 'C01';
                break;
            case '6':
                return 'F01';
                break;
        }
    } else if (type == '6') {
        switch (cmdtype) {
            case '1':
                return '4101';
                break;
            case '2':
                return '4102';
                break;
            case '3':
                return '4105';
                break;
            case '4':
                return '4115';
                break;
            case '5':
                return '4115';
                break;
            case '6':
                return '4902';
                break;
        }
    } else if (type == '7') {
        switch (cmdtype) {
            case '1':
                return 'A10';
                break;
            case '2':
                return 'A12';
                break;
            case '3':
                return 'B07';
                break;
            case '4':
                return 'F01';
                break;
        }
    } else if (type == '8') {
        switch (cmdtype) {
            case '1':
                return 'A10';
                break;
            case '2':
                return 'A12';
                break;
            case '3':
                return 'B07';
                break;
            case '4':
                return 'C01';
                break;
            case '5':
                return 'C01';
                break;
            case '6':
                return 'F01';
                break;
        }
    }
}




function Event_parsing_type5(value) {
    switch (value) {
        case '1':
            return 'SOS Pressed';
            break;
        case '2':
            return 'Input2 active';
            break;
        case '3':
            return 'Input3 active';
            break;
        case '4':
            return 'Input4 active';
            break;
        case '5':
            return 'Input5 active';
            break;
        case '9':
            return 'SOS Released';
            break;
        case '10':
            return 'Input2 Inactive';
            break;
        case '11':
            return 'Input3 Inactive';
            break;
        case '12':
            return 'Input4 Inactive';
            break;
        case '13':
            return 'Input5 Inactive';
            break;
        case '17':
            return 'Low Battery';
            break;
        case '18':
            return 'Low External Power';
            break;
        case '19':
            return 'Speeding';
            break;
        case '20':
            return 'Enter Geo‐fence';
            break;
        case '21':
            return 'Exit Geo‐fence';
            break;
        case '22':
            return 'External Power On';
            break;
        case '23':
            return 'External Power Off';
            break;
        case '24':
            return 'No GPS Signal';
            break;
        case '25':
            return 'Get GPS Signal';
            break;
        case '26':
            return 'Enter Sleep';
            break;
        case '27':
            return 'Exit Sleep';
            break;
        case '28':
            return 'GPS Antenna Cut';
            break;
        case '29':
            return 'Device Reboot';
            break;
        case '30':
            return 'Impact';
            break;
        case '31':
            return 'Heartbeat Report';
            break;
        case '32':
            return 'Heading Change Report';
            break;
        case '33':
            return 'Distance Interval Report';
            break;
        case '34':
            return 'Current Location Report';
            break;
        case '35':
            return 'Normal';
            break;
        case '36':
            return 'Tow Alarm';
            break;
        case '37':
            return 'RFID';
            break;
        case '39':
            return 'Picture';
            break;
        case '65':
            return 'Press Input 1 (SOS) to Call';
            break;
        case '66':
            return 'Press Input 2 to Call';
            break;
        case '67':
            return 'Press Input 3 to Call';
            break;
        case '68':
            return 'Press Input 4 to Call';
            break;
        case '69':
            return 'Press Input 5 to Call';
            break;
        case '70':
            return 'Reject Incoming Call';
            break;
        case '71':
            return 'Report Location after Incoming Call';
            break;
        case '72':
            return 'Auto Answer Incoming Call';
            break;
        case '73':
            return 'Listen‐in (voice monitoring)';
            break;
    }
    ;
}

function Event_parsing_type6(value) {
    switch (value) {
        case 0:
            return 'Normal';
            break;
        case 1:
            return 'Input 1 active';
            break;
        case 2:
            return 'Input 2 active';
            break;
        case 3:
            return 'Input 3 active';
            break;
        case 4:
            return 'Input 4 active';
            break;
        case 5:
            return 'Input 5 active';
            break;
        case 10:
            return 'Low battery alarm';
            break;
        case 11:
            return 'Speeding alarm';
            break;
        case 12:
            return 'Movement alarm';
            break;
        case 13:
            return 'Alarm of tracker entering Geo-fence scope';
            break;
        case 14:
            return 'Alarm of tracker being turned on';
            break;
        case 15:
            return 'Alarm of tracker entering GPS blind area';
            break;
        case 16:
            return 'Alarm of tracker exiting GPS blind area';
            break;
        case 31:
            return 'Input 1 inactive';
            break;
        case 32:
            return 'Input 2 inactive';
            break;
        case 33:
            return 'Input 3 inactive';
            break;
        case 34:
            return 'Input 4 inactive';
            break;
        case 35:
            return 'Input 5 inactive';
            break;
        case 50:
            return 'External power cut alarm';
            break;
        case 52:
            return 'Veer report';
            break;
        case 53:
            return 'GPS antenna cut alarm ';
            break;
        case 63:
            return 'Distance report';
            break;
    }
    ;
}

function Event_parsing_typeNR008(value) {
    switch (value) {
        case 80:
            return 'Normal';
            break;
        case 81:
            return 'SOS Alarm';
            break;
        case 82:
            return 'Over Speed Alarm';
            break;
        case 83:
            return 'Geo-Fence Alarm';
            break;
        case 89:
            return 'External Power Off';
            break;
    }
    ;
}

function fuel_Percentage_Left(value) {
    return Math.round((value / ((1024 * 2) - value)) * 100 * 100) / 100;
}

function TimestampToDateTime(timestamp, TimeZone) {
    var gmdate = new Date((timestamp * 1000));
    var timez = -gmdate.getTimezoneOffset() / 60;
    var curr_date = gmdate.getDate();
    curr_date = curr_date <= 9 ? '0' + curr_date : curr_date;
    var curr_month = gmdate.getMonth() + 1;
    curr_month = curr_month <= 9 ? '0' + curr_month : curr_month;
    var curr_year = gmdate.getFullYear();
    var curr_hour = gmdate.getHours() - timez + TimeZone;
    curr_hour = curr_hour <= 9 ? '0' + curr_hour : curr_hour;
    var curr_min = gmdate.getMinutes();
    curr_min = curr_min <= 9 ? '0' + curr_min : curr_min;
    var curr_sec = gmdate.getSeconds();
    curr_sec = curr_sec <= 9 ? '0' + curr_sec : curr_sec;

    return curr_date + '/' + curr_month + '/' + curr_year + ' ' + curr_hour + ':' + curr_min + ':' + curr_sec

}

function DateTimeToTimestamp(DateTime, TimeZone) {
    var date = DateTime;

    var nowstr = new Date();
    var strtimez = -nowstr.getTimezoneOffset() / 60;
    var strday = date.split('/')[0];
    var strmonth = date.split('/')[1] - 1;
    var stryear = date.split('/')[2].split(' ')[0];
    var strhour = date.split('/')[2].split(' ')[1].split(':')[0] - strtimez + TimeZone;
    var strminute = date.split('/')[2].split(' ')[1].split(':')[1];
    var strsecond = date.split('/')[2].split(' ')[1].split(':')[2];

    return new Date(stryear, strmonth, strday, strhour, strminute, strsecond, 0);
}

function DateToTimestamp(DateTime) {
    var date = DateTime;

    var nowstr = new Date();
    var strtimez = -nowstr.getTimezoneOffset() / 60;
    var strday = date.split('/')[0];
    var strmonth = date.split('/')[1] - 1;
    var stryear = date.split('/')[2].split(' ')[0];

    return new Date(stryear, strmonth, strday, 0, 0, 0, 0);
}

function Parse_tvar(tvar, object, ope) {
    if (!tvar.gm_timestamp) {
        id = object.Unit;
        tvar.mobile = object.Mobile;
        tvar.tdrivername = object.Driver;
        tvar.tvehiclereg = object.Vehicle;
        tvar.gm_timestamp = tvar.gm_time;
        tvar.gm_time = TimestampToDateTime(tvar.gm_time, TimeZone);
        tvar.gm_inputs = object.Inputs;
        var ElemInps = tvar.gm_inputs;
        tvar.gm_overspeed = parseFloat(object.SpeedLimit);
        

        tvar.gm_address = "Can't find address.";
        tvar.gm_speed = parseFloat(tvar.gm_speed);
        //over speed
        tvar.OverSpeedAlarm = false;
        if (tvar.gm_speed > tvar.gm_overspeed) {
            tvar.OverSpeedAlarm = true;
        }


        if (tvar.gm_ori == '') {
            tvar.gm_ori = direction_parsing(0);
            tvar.gm_deg = 0;
        } else {
            tvar.gm_deg = parseFloat(tvar.gm_ori);
            tvar.gm_ori = direction_parsing(tvar.gm_ori);
        }
        ;

        if (object.Mobile) {
            tvar.caption = tvar.tvehiclereg;
        } else {
            if ($('#iconcaption').val() == '0') {
                tvar.caption = tvar.tvehiclereg;
            } else if ($('#iconcaption').val() == '1') {
                tvar.caption = tvar.tdrivername;
            }
        }
        ;
        tvar.imgid = object.TrackerImage;
        tvar.gm_mileagelimit = parseFloat(object.MileageLimit);
        tvar.gm_mileageinit = parseFloat(object.MileageInit);
        tvar.gm_mileagereset = parseFloat(object.MileageReset);
        tvar.gm_mileage = parseFloat(tvar.gm_mileage) + tvar.gm_mileageinit - tvar.gm_mileagereset;
        tvar.gm_type = object.Type;

        var ElemType = tvar.gm_type;
        if (ElemType == '1' || ElemType == '2' || ElemType == '3' || ElemType == '4') {
            var stateData = [];
            var stateStr = tvar.gm_data;
            stateData = stateStr.split(',');
            tvar.gm_input5 = 'n/a';
            tvar.gm_output2 = 'n/a';
            tvar.gm_output3 = 'n/a';
            tvar.gm_output4 = 'n/a';
            tvar.gm_output5 = 'n/a';
            tvar.gm_fuel = 'n/a';
            tvar.gm_AD2 = 'n/a';

            switch (stateData[0]) {
                case '0':
                    tvar.gm_signal = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_signal = ON_LBL;
                    break;
            }
            ;
            switch (stateData[1]) {
                case '1':
                    tvar.gm_power = NORMAL_LBL;
                    break;
                case '2':
                    tvar.gm_power = OFF_LBL;
                    break;
                case '3':
                    tvar.gm_power = LOW_LBL;
                    break;
                case '4':
                    tvar.gm_power = ERROR_LBL;
                    break;
            }
            ;
            switch (stateData[2]) {
                case '1':
                    tvar.gm_state = HIGH_LBL;
                    break;
                case '2':
                    tvar.gm_state = SHORT_LBL;
                    break;
                case '3':
                    tvar.gm_state = NORMAL_LBL;
                    break;
                case '4':
                    tvar.gm_state = ERROR_LBL;
                    break;
            }
            ;
            tvar.gm_timeInterval = stateData[3];
            tvar.gm_GPSQSignal = stateData[4];
            tvar.gm_GSMQSignal = stateData[5];

            switch (stateData[9]) {
                case '0':
                    tvar.gm_output1 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_output1 = ON_LBL;
                    break;
            }
            ;
            switch (stateData[14]) {
                case '0':
                    tvar.gm_input1 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input1 = ON_LBL;
                    break;
            }
            ;

            switch (stateData[15]) {
                case '0':
                    tvar.gm_input2 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input2 = ON_LBL;
                    break;
            }
            ;
            switch (stateData[16]) {
                case '0':
                    tvar.gm_input3 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input3 = ON_LBL;
                    break;
            }
            ;
            switch (stateData[17]) {
                case '0':
                    tvar.gm_input4 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input4 = ON_LBL;
                    break;
            }
            ;



            if (tvar.gm_timeInterval == '0') {
                tvar.gm_timeInterval = '10';
            }
            RTinterval = tvar.gm_timeInterval;

        } else if (ElemType == '5') {
            // GGPSAvailable,EventCode,GGPSSignal,GGSMQSignal,PMileage,HDOP,MSLAltitude,Runtime,BaseID,
            // out1,out2,out3,out4,out5,out6,out7,out8,in1,in2,in3,in4,in5,in6,in7,in8,ad1,ad2,ad3,ad4,ad5		
            var stateData = [];
            var stateStr = tvar.gm_data;
            stateData = stateStr.split(',');
            tvar.gm_state = Event_parsing_type5(stateData[1])
            tvar.gm_GPSQSignal = stateData[2];
            tvar.gm_GSMQSignal = stateData[3];
            tvar.gm_fuel = fuel_Percentage_Left(parseFloat(stateData[25]));
            tvar.gm_power = 'n/a';
            tvar.gm_input3 = 'n/a';
            tvar.gm_input4 = 'n/a';
            tvar.gm_input5 = 'n/a';
            tvar.gm_output2 = 'n/a';
            tvar.gm_output3 = 'n/a';
            tvar.gm_output4 = 'n/a';
            tvar.gm_output5 = 'n/a';
            tvar.gm_AD2 = 'n/a';
            tvar.gm_timeInterval = 'n/a';
            switch (stateData[0]) {
                case '0':
                    tvar.gm_signal = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_signal = ON_LBL;
                    break;
            }
            ;
            switch (stateData[17]) {
                case '0':
                    tvar.gm_input1 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input1 = ON_LBL;
                    break;
            }
            ;
            switch (stateData[18]) {
                case '0':
                    tvar.gm_input2 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input2 = ON_LBL;
                    break;
            }
            ;
            switch (stateData[9]) {
                case '1':
                    tvar.gm_output1 = OFF_LBL;
                    break;
                case '0':
                    tvar.gm_output1 = ON_LBL;
                    break;
            }
            ;

        } else if (ElemType == '6') {
            tvar.gm_unit = id;
            // GGPSAvailable,HDOP,MSLAltitude,PState,PAD,BaseID,PCSQ,PJourney			
            var stateData = [];
            var stateStr = tvar.gm_data;
            stateData = stateStr.split('|');
            tvar.gm_state = Event_parsing_type6(parseInt(stateData[8]));
            tvar.gm_GSMQSignal = parseInt(stateData[6], 16);
            tvar.gm_fuel = fuel_Percentage_Left(parseInt(stateData[4].split(',')[0], 16));
            tvar.gm_AD2 = fuel_Percentage_Left(parseInt(stateData[4].split(',')[1], 16));
            tvar.gm_power = 'n/a';
            tvar.gm_timeInterval = 'n/a';
            tvar.gm_GPSQSignal = 'n/a';
            switch (stateData[0]) {
                case '0':
                    tvar.gm_signal = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_signal = ON_LBL;
                    break;
            }
            ;
            switch (stateData[3].substr(7, 1)) {
                case '0':
                    tvar.gm_input1 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input1 = ON_LBL;
                    break;
            }
            ;
            //  check inputs
            if (ElemInps == '25') {
                switch (stateData[3].substr(6, 1)) {
                    case '0':
                        tvar.gm_input5 = ON_LBL;
                        break;
                    case '1':
                        tvar.gm_input5 = OFF_LBL;
                        break;
                }
                ;

                switch (stateData[3].substr(3, 1)) {
                    case '0':
                        tvar.gm_input2 = OFF_LBL;
                        break;
                    case '1':
                        tvar.gm_input2 = ON_LBL;
                        break;
                }
                ;
            } else {
                switch (stateData[3].substr(6, 1)) {
                    case '0':
                        tvar.gm_input2 = ON_LBL;
                        break;
                    case '1':
                        tvar.gm_input2 = OFF_LBL;
                        break;
                }
                ;

                switch (stateData[3].substr(3, 1)) {
                    case '0':
                        tvar.gm_input5 = OFF_LBL;
                        break;
                    case '1':
                        tvar.gm_input5 = ON_LBL;
                        break;
                }
                ;
            }// end check inputs

            switch (stateData[3].substr(5, 1)) {
                case '0':
                    tvar.gm_input3 = ON_LBL;
                    break;
                case '1':
                    tvar.gm_input3 = OFF_LBL;
                    break;
            }
            ;
            switch (stateData[3].substr(4, 1)) {
                case '0':
                    tvar.gm_input4 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input4 = ON_LBL;
                    break;
            }
            ;
            switch (stateData[3].substr(15, 1)) {
                case '0':
                    tvar.gm_output1 = ON_LBL;
                    break;
                case '1':
                    tvar.gm_output1 = OFF_LBL;
                    break;
            }
            ;
            switch (stateData[3].substr(14, 1)) {
                case '0':
                    tvar.gm_output2 = ON_LBL;
                    break;
                case '1':
                    tvar.gm_output2 = OFF_LBL;
                    break;
            }
            ;
            switch (stateData[3].substr(13, 1)) {
                case '0':
                    tvar.gm_output3 = ON_LBL;
                    break;
                case '1':
                    tvar.gm_output3 = OFF_LBL;
                    break;
            }
            ;
            switch (stateData[3].substr(12, 1)) {
                case '0':
                    tvar.gm_output4 = ON_LBL;
                    break;
                case '1':
                    tvar.gm_output4 = OFF_LBL;
                    break;
            }
            ;
            switch (stateData[3].substr(11, 1)) {
                case '0':
                    tvar.gm_output5 = ON_LBL;
                    break;
                case '1':
                    tvar.gm_output5 = OFF_LBL;
                    break;
            }
            ;

        } else if (ElemType == '7') {
            // GGPSAvailable,EventCode,GGPSSignal,GGSMQSignal,PMileage,HDOP,MSLAltitude,Runtime,BaseID,
            // out1,out2,out3,out4,out5,out6,out7,out8,in1,in2,in3,in4,in5,in6,in7,in8,ad1,ad2,ad3,ad4,ad5		
            var stateData = [];
            var stateStr = tvar.gm_data;
            stateData = stateStr.split(',');
            tvar.gm_state = Event_parsing_type5(stateData[1])
            tvar.gm_GPSQSignal = stateData[2];
            tvar.gm_GSMQSignal = stateData[3];
            tvar.gm_fuel = fuel_Percentage_Left(parseFloat(stateData[25]));
            tvar.gm_power = 'n/a';
            tvar.gm_input2 = 'n/a';
            tvar.gm_input3 = 'n/a';
            tvar.gm_input4 = 'n/a';
            tvar.gm_input5 = 'n/a';
            tvar.gm_output1 = 'n/a';
            tvar.gm_output2 = 'n/a';
            tvar.gm_output3 = 'n/a';
            tvar.gm_output4 = 'n/a';
            tvar.gm_output5 = 'n/a';
            tvar.gm_AD2 = 'n/a';
            tvar.gm_timeInterval = 'n/a';
            switch (stateData[0]) {
                case '0':
                    tvar.gm_signal = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_signal = ON_LBL;
                    break;
            }
            ;
            switch (stateData[17]) {
                case '0':
                    tvar.gm_input1 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input1 = ON_LBL;
                    break;
            }
            ;

        } else if (ElemType == '8') {
            // GGPSAvailable,EventCode,GGPSSignal,GGSMQSignal,PMileage,HDOP,MSLAltitude,Runtime,BaseID,
            // out1,out2,out3,out4,out5,out6,out7,out8,in1,in2,in3,in4,in5,in6,in7,in8,ad1,ad2,ad3,ad4,ad5		
            var stateData = [];
            var stateStr = tvar.gm_data;
            stateData = stateStr.split(',');
            tvar.gm_state = Event_parsing_type5(stateData[1])
            tvar.gm_GPSQSignal = stateData[2];
            tvar.gm_GSMQSignal = stateData[3];
            tvar.gm_fuel = fuel_Percentage_Left(parseFloat(stateData[25]));
            tvar.gm_power = 'n/a';
            tvar.gm_input3 = 'n/a';
            tvar.gm_input4 = 'n/a';
            tvar.gm_input5 = 'n/a';
            tvar.gm_output2 = 'n/a';
            tvar.gm_output3 = 'n/a';
            tvar.gm_output4 = 'n/a';
            tvar.gm_output5 = 'n/a';
            tvar.gm_AD2 = 'n/a';
            tvar.gm_timeInterval = 'n/a';
            switch (stateData[0]) {
                case '0':
                    tvar.gm_signal = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_signal = ON_LBL;
                    break;
            }
            ;
            switch (stateData[17]) {
                case '0':
                    tvar.gm_input1 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input1 = ON_LBL;
                    break;
            }
            ;
            //  check inputs
            if (ElemInps == '23') {
                switch (stateData[19]) {
                    case '1':
                        tvar.gm_input2 = ON_LBL;
                        break;
                    case '0':
                        tvar.gm_input2 = OFF_LBL;
                        break;
                }
                ;

                switch (stateData[18]) {
                    case '0':
                        tvar.gm_input3 = OFF_LBL;
                        break;
                    case '1':
                        tvar.gm_input3 = ON_LBL;
                        break;
                }
                ;
            } else {
                switch (stateData[18]) {
                    case '1':
                        tvar.gm_input2 = ON_LBL;
                        break;
                    case '0':
                        tvar.gm_input2 = OFF_LBL;
                        break;
                }
                ;

                switch (stateData[19]) {
                    case '0':
                        tvar.gm_input3 = OFF_LBL;
                        break;
                    case '1':
                        tvar.gm_input3 = ON_LBL;
                        break;
                }
                ;
            }// end check inputs
            switch (stateData[9]) {
                case '1':
                    tvar.gm_output1 = OFF_LBL;
                    break;
                case '0':
                    tvar.gm_output1 = ON_LBL;
                    break;
            }
            ;
            switch (stateData[8]) {
                case '1':
                    tvar.gm_output2 = OFF_LBL;
                    break;
                case '0':
                    tvar.gm_output2 = ON_LBL;
                    break;
            }
            ;
            switch (stateData[7]) {
                case '1':
                    tvar.gm_output3 = OFF_LBL;
                    break;
                case '0':
                    tvar.gm_output3 = ON_LBL;
                    break;
            }
            ;
        } else if (ElemType == '9') {
            // GGPSAvailable,EventCode,GGPSSignal,GGSMQSignal,PMileage,HDOP,MSLAltitude,Runtime,BaseID,
            // out1,out2,out3,out4,out5,out6,out7,out8,in1,in2,in3,in4,in5,in6,in7,in8,ad1,ad2,ad3,ad4,ad5		
            var stateData = [];
            var stateStr = tvar.gm_data;
            stateData = stateStr.split(',');

            if (parseFloat(stateData[2]) == '81') {
                tvar.gm_input1 = ON_LBL;
            } else {
                tvar.gm_input1 = OFF_LBL;
            }
            ;

            tvar.gm_state = Event_parsing_typeNR008(parseFloat(stateData[2]))
            tvar.gm_GPSQSignal = 'n/a';
            tvar.gm_GSMQSignal = 'n/a';
            tvar.gm_fuel = 'n/a';
            tvar.gm_power = 'n/a';
            tvar.gm_input3 = 'n/a';
            tvar.gm_input4 = 'n/a';
            tvar.gm_input5 = 'n/a';
            tvar.gm_output2 = 'n/a';
            tvar.gm_output3 = 'n/a';
            tvar.gm_output4 = 'n/a';
            tvar.gm_output5 = 'n/a';
            tvar.gm_AD2 = 'n/a';
            tvar.gm_timeInterval = 'n/a';

            if (parseFloat(tvar.gm_lat) !== 0 && parseFloat(tvar.gm_lng) !== 0) {
                tvar.gm_signal = ON_LBL;
            } else {
                tvar.gm_signal = OFF_LBL;
            }
            ;

            switch (stateData[1].substr(1, 1)) {
                case '0':
                    tvar.gm_input2 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input2 = ON_LBL;
                    break;
            }
            ;

            switch (stateData[1].substr(0, 1)) {
                case '1':
                    tvar.gm_output1 = ON_LBL;
                    break;
                case '0':
                    tvar.gm_output1 = OFF_LBL;
                    break;
            }
            ;
        } else if (ElemType == '10') {
//          GGPSAvailable + ',' + GGPSSignal + ',' + GGSMQSignal + ',' +
//          PAltitude + ',' + PIn1 + ',' + PIn2 + ',' + PIn3 + ',' + PAD1 + ',' +
//          POUT1 + ',' + POUT2 + ',' + PPDOP + ',' + PHDOP + ',' +
//          PExternalVoltage + ',' + PGPSPower + ',' + PMovement + ',' + POdmeter
//          + ',' + PGSMOperator + ',' + PSpeedOMeter + ',' + PButtonID + ',' +
//          PWorkingMode + ',' + PDeepSleep + ',' + PcellID + ',' + PAreaCode +
//          ',' + PDallasTemp		
            var stateData = [];
            var stateStr = tvar.gm_data;
            stateData = stateStr.split(',');
            tvar.gm_state = 'n/a';
            tvar.gm_GPSQSignal = stateData[1];
            tvar.gm_GSMQSignal = stateData[2];
            tvar.gm_AD1 = 'n/a';
            tvar.gm_power = 'n/a';
            tvar.gm_input4 = 'n/a';
            tvar.gm_input5 = 'n/a';
            tvar.gm_output3 = 'n/a';
            tvar.gm_output4 = 'n/a';
            tvar.gm_output5 = 'n/a';
            tvar.gm_AD2 = 'n/a';
            tvar.gm_timeInterval = 'n/a';
            switch (stateData[0]) {
                case '0':
                    tvar.gm_signal = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_signal = ON_LBL;
                    break;
            }
            ;
            switch (stateData[4]) {
                case '0':
                    tvar.gm_input1 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input1 = ON_LBL;
                    break;
            }
            
            switch (stateData[5]) {
                case '0':
                    tvar.gm_input2 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input2 = ON_LBL;
                    break;
            }
            
            switch (stateData[6]) {
                case '0':
                    tvar.gm_input3 = OFF_LBL;
                    break;
                case '1':
                    tvar.gm_input3 = ON_LBL;
                    break;
            }
            
            switch (stateData[8]) {
                case '1':
                    tvar.gm_output1 = OFF_LBL;
                    break;
                case '0':
                    tvar.gm_output1 = ON_LBL;
                    break;
            }
            ;
            switch (stateData[9]) {
                case '1':
                    tvar.gm_output2 = OFF_LBL;
                    break;
                case '0':
                    tvar.gm_output2 = ON_LBL;
                    break;
            }
        }
        ;

        if (!object.Mobile) {
            var umap = $('.map' + id).val();
            if (umap == '0') {
                tvar.map = MapClass.currMapID;
            } else {
                tvar.map = umap.split('map')[1];
            }
            ;
        } else {
            tvar.map = 0;

        }
        if (!object.Mobile) {
            if (RealTimeClass.TrackedID == id) {
                tvar.trackable = true;
            } else {
                tvar.trackable = false;
            }
        }

        if (object.Mobile) {
            if ($('#vehicles').val() == id) {
                tvar.trackable = true;
            } else {
                tvar.trackable = false;
            }
        }

        if (ope == 'realtime') {
            // check lost tracker	
            var nowstr = new Date();
            var timedateTOtimestamp = DateTimeToTimestamp(tvar.gm_time, TimeZone);
            var diff = (nowstr.getTime() - timedateTOtimestamp.getTime()) / (1000 * 60 * 60);
            if (diff > DefaultSettings.inLostMode) {
                tvar.lostAlarm = true;
            } else {
                tvar.lostAlarm = false;
            }

            // check reg expiry
            if (object.VehicleregExpiry != '') {
                var reg_Timestamp = DateToTimestamp(object.VehicleregExpiry);
                var reg_diff = (reg_Timestamp.getTime() - nowstr.getTime()) / (24 * 3600 * 1000);
                if (reg_diff < 0) {
                    tvar.regAlarm = true;
                } else {
                    tvar.regAlarm = false;
                }
            } else {
                tvar.regAlarm = false;
            }
            // check expiry
            if (object.TrackerExpiry != '') {
                var Exp_Timestamp = DateToTimestamp(object.TrackerExpiry);
                var Expdiff = (Exp_Timestamp.getTime() - nowstr.getTime()) / (24 * 3600 * 1000);
                if (Expdiff < 0) {
                    tvar.ExpAlarm = true;
                } else {
                    tvar.ExpAlarm = false;
                }
            } else {
                tvar.ExpAlarm = false;
            }
        } else {
            tvar.lostAlarm = false;
            tvar.regAlarm = false;
            tvar.ExpAlarm = false;
        }
// check mileage
        if (tvar.gm_mileage >= tvar.gm_mileagelimit) {
            tvar.MileageAlarm = true;
        } else {
            tvar.MileageAlarm = false;
        }

// check signal
        if (tvar.gm_signal == OFF_LBL) {
            tvar.SignalAlarm = true;
        } else {
            tvar.SignalAlarm = false;
        }
// check urgent
        if (tvar.gm_input1 == ON_LBL) {
            tvar.UrgentAlarm = true;
        } else {
            tvar.UrgentAlarm = false;
        }

// check acc
        if (tvar.gm_input2 == ON_LBL) {
            tvar.AccAlarm = true;
        } else {
            tvar.AccAlarm = false;
        }
        ;

        //geo fence	
        tvar.geoFAlarm = false;
        tvar.geoFArea = '';
        if (!object.Mobile /*&& (ope=='realtime')*/) {
            if (document.getElementById('gf_displaycheck').checked == true) {
                for (i in GeoFenceViewer.ID) {
                    if (document.getElementById('geofences_list').options[i].selected) {
                        if (MapClass.currMap == 'gmap') {
                            if (pointInPolygon(latlongPaths(GeoFenceViewer.Data[i]), tvar.gm_lat, tvar.gm_lng) == true) {
                                tvar.geoFAlarm = true;
                                tvar.geoFArea = tvar.geoFArea + GeoFenceViewer.Name[i];
                                tvar.geoFID = GeoFenceViewer.ID[i];
                                break;
                            } else {
                                tvar.geoFAlarm = false;
                                tvar.geoFArea = '';
                                tvar.geoFID = GeoFenceViewer.ID[i];
                            }
                        } else if (MapClass.currMap == 'omap') {
                            if (pointInPolygon(latlongPaths(GeoFenceViewer.Data[i]), tvar.gm_lat, tvar.gm_lng) == true) {
                                tvar.geoFAlarm = true;
                                tvar.geoFArea = tvar.geoFArea + GeoFenceViewer.Name[i];
                                tvar.geoFID = GeoFenceViewer.ID[i];
                                break;
                            } else {
                                tvar.geoFAlarm = false;
                                tvar.geoFArea = '';
                                tvar.geoFID = GeoFenceViewer.ID[i];
                            }
                        }
                    }
                }
            }
        }
        // end geo fence		
////////////////// parsing states Map
        if (tvar.mobile) {
            DefaultSettings.imgsrc = '../images/car/';
            DefaultSettings.alarmimgsrc = '../images/alarmsicons/';

        }

        if (tvar.lostAlarm || tvar.SignalAlarm) {
            tvar.img = DefaultSettings.imgsrc + "icon_" + tvar.imgid + "_lost.gif";
            if (tvar.SignalAlarm) {
                tvar.alarmimg = DefaultSettings.alarmimgsrc + "GPSoff.png";
            } else {
                tvar.alarmimg = "none";
            }
        } else {
            if (tvar.UrgentAlarm) {
                tvar.img = DefaultSettings.imgsrc + "icon_" + tvar.imgid + "_alarm.gif";
                tvar.alarmimg = DefaultSettings.alarmimgsrc + "emergency.png";
            } else {
                if (parseFloat(tvar.gm_speed) == 0) {
                    if (tvar.AccAlarm) {
                        tvar.img = DefaultSettings.imgsrc + "icon_" + tvar.imgid + "_idle.gif";
                        tvar.alarmimg = "none";
                    } else {
                        if (tvar.geoFAlarm) {
                            tvar.img = DefaultSettings.imgsrc + "icon_" + tvar.imgid + "_alarm.gif";
                            tvar.alarmimg = DefaultSettings.alarmimgsrc + "geo-fence.png";
                        } else {
                            tvar.img = DefaultSettings.imgsrc + "icon_" + tvar.imgid + "_stop.gif";
                            tvar.alarmimg = "none";
                        }
                    }
                } else {
                    if (tvar.AccAlarm == false) {
                        tvar.img = DefaultSettings.imgsrc + "icon_" + tvar.imgid + "_alarm.gif";
                        tvar.alarmimg = DefaultSettings.alarmimgsrc + "breakdown.png";
                    } else {
                        if (tvar.OverSpeedAlarm) {
                            tvar.img = DefaultSettings.imgsrc + "icon_" + tvar.imgid + "_alarm.gif";
                            tvar.alarmimg = DefaultSettings.alarmimgsrc + "speedLimit.png";

                        } else {
                            if (tvar.geoFAlarm) {
                                tvar.img = DefaultSettings.imgsrc + "icon_" + tvar.imgid + "_alarm.gif";
                                tvar.alarmimg = DefaultSettings.alarmimgsrc + "geo-fence.png";


                            } else {
                                tvar.img = DefaultSettings.imgsrc + "icon_" + tvar.imgid + "_driver.gif";
                                tvar.alarmimg = "none";

                            }
                        }
                    }
                }
            }
        }
    }
    return tvar;
}