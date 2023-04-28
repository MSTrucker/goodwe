<?php

namespace Goodwe;

use Goodwe;


class Sensors {

    public static function fillSensorsData($source, $data) {
        $result = [];

        if ($source == 'inverter') {
            // Current time
            $result['timestamp'] = self::getTimestamp('Timestamp', 0, $data);
            // photo-voltaic section 1
            $result['vpv1'] = self::getDecimal('PV1 Voltage', 6, 2, 10, $data, 'V');
            $result['ipv1'] = self::getDecimal('PV1 Current', 8, 2, 10, $data, 'A');
            $result['ppv1'] = self::getInteger('PV1 Power', 10, 4, $data, 'W');
            // photo-voltaic section 2
            $result['vpv2'] = self::getDecimal('PV2 Voltage', 14, 2, 10, $data, 'V');
            $result['ipv2'] = self::getDecimal('PV2 Current', 16, 2, 10, $data, 'A');
            $result['ppv2'] = self::getInteger('PV2 Power', 18, 4, $data, 'W');
            // photo-voltaic section 3
            $result['vpv3'] = self::getDecimal('PV3 Voltage', 22, 2, 10, $data, 'V');
            $result['ipv3'] = self::getDecimal('PV3 Current', 24, 2, 10, $data, 'A');
            $result['ppv3'] = self::getInteger('PV3 Power', 26, 4, $data, 'W');
            // photo-voltaic section 4
            $result['vpv4'] = self::getDecimal('PV4 Voltage', 30, 2, 10, $data, 'V');
            $result['ipv4'] = self::getDecimal('PV4 Current', 32, 2, 10, $data, 'A');
            $result['ppv4'] = self::getInteger('PV4 Power', 34, 4, $data, 'W');
            // sum of photo-voltaic power
            $result['ppv'] = self::getCustomValue('PV Power',
                                                    (
                                                        $result['ppv1']['clear_val'] +
                                                        $result['ppv2']['clear_val'] +
                                                        $result['ppv3']['clear_val'] +
                                                        $result['ppv4']['clear_val']
                                                    ),
                                                    'W');

            // photo-voltaic section modes                             
            $result['pv4_mode'] = self::getInteger('PV4 Mode code', 38, 1, $data);
            $result['pv4_mode_label'] = self::getCustomValue('PV4 Mode', Goodwe\Dictionary::$PV_MODES[$result['pv4_mode']['clear_val']]);
            $result['pv3_mode'] = self::getInteger('PV3 Mode code', 39, 1, $data);
            $result['pv3_mode_label'] = self::getCustomValue('PV3 Mode', Goodwe\Dictionary::$PV_MODES[$result['pv3_mode']['clear_val']]);
            $result['pv2_mode'] = self::getInteger('PV2 Mode code', 40, 1, $data);
            $result['pv2_mode_label'] = self::getCustomValue('PV2 Mode', Goodwe\Dictionary::$PV_MODES[$result['pv2_mode']['clear_val']]);
            $result['pv1_mode'] = self::getInteger('PV1 Mode code', 41, 1, $data);
            $result['pv1_mode_label'] = self::getCustomValue('PV1 Mode', Goodwe\Dictionary::$PV_MODES[$result['pv1_mode']['clear_val']]);
            // grid output phase 1
            $result['vgrid1'] = self::getDecimal('On-grid L1 Voltage', 42, 2, 10, $data, 'V');
            $result['igrid1'] = self::getDecimal('On-grid L1 Current', 44, 2, 10, $data, 'A');
            $result['fgrid1'] = self::getDecimal('On-grid L1 Frequency', 46, 2, 100, $data, 'Hz');
            $result['pgrid1'] = self::getInteger('On-grid L1 Power', 50, 2, $data, 'W');
            // grid output phase 2
            $result['vgrid2'] = self::getDecimal('On-grid L2 Voltage', 52, 2, 10, $data, 'V');
            $result['igrid2'] = self::getDecimal('On-grid L2 Current', 54, 2, 10, $data, 'A');
            $result['fgrid2'] = self::getDecimal('On-grid L2 Frequency', 56, 2, 100, $data, 'Hz');
            $result['pgrid2'] = self::getInteger('On-grid L2 Power', 60, 2, $data, 'W');
            // grid output phase 3
            $result['vgrid3'] = self::getDecimal('On-grid L3 Voltage', 62, 2, 10, $data, 'V');
            $result['igrid3'] = self::getDecimal('On-grid L3 Current', 64, 2, 10, $data, 'A');
            $result['fgrid3'] = self::getDecimal('On-grid L3 Frequency', 66, 2, 100, $data, 'Hz');
            $result['pgrid3'] = self::getInteger('On-grid L3 Power', 70, 2, $data, 'W');
            // grid output mode
            $result['grid_mode'] = self::getInteger('Grid Mode code', 72, 2, $data);
            $result['grid_mode_label'] = self::getCustomValue('Grid Mode', Goodwe\Dictionary::$GRID_MODES[$result['grid_mode']['clear_val']]);
            // grid power
            $result['total_inverter_power'] = self::getInteger('Total Power', 76, 2, $data, 'W');
            $result['active_power'] = self::getInteger('Active Power', 80, 2, $data, 'W');
            // grid in/out mode
            $result['grid_in_out'] = self::getCustomValue('On-grid Mode code',
                                                        (
                                                            ($result['active_power']['clear_val'] < -90) ? 2 :
                                                            (($result['active_power']['clear_val'] >= 90) ? 1 : 0)
                                                        )
                                                        );
            $result['grid_in_out_label'] = self::getCustomValue('On-grid Mode', Goodwe\Dictionary::$GRID_IN_OUT_MODES[$result['grid_in_out']['clear_val']]);

            $result['reactive_power'] = self::getInteger('Reactive Power', 84, 2, $data, 'var');
            $result['apparent_power'] = self::getInteger('Apparent Power', 88, 2, $data, 'VA');
            // backup L1
            $result['backup_v1'] = self::getDecimal('Back-up L1 Voltage', 90, 2, 10, $data, 'V');
            $result['backup_i1'] = self::getDecimal('Back-up L1 Current', 92, 2, 10, $data, 'A');
            $result['backup_f1'] = self::getDecimal('Back-up L1 Frequency', 94, 2, 100, $data, 'Hz');
            $result['load_mode1'] = self::getInteger('Load Mode L1', 96, 2, $data);
            $result['backup_p1'] = self::getInteger('Back-up L1 Power', 100, 2, $data, 'W');
            // backup L2
            $result['backup_v2'] = self::getDecimal('Back-up L2 Voltage', 102, 2, 10, $data, 'V');
            $result['backup_i2'] = self::getDecimal('Back-up L2 Current', 104, 2, 10, $data, 'A');
            $result['backup_f2'] = self::getDecimal('Back-up L2 Frequency', 106, 2, 100, $data, 'Hz');
            $result['load_mode2'] = self::getInteger('Load Mode L2', 108, 2, $data);
            $result['backup_p2'] = self::getInteger('Back-up L2 Power', 112, 2, $data, 'W');
            // backup L3
            $result['backup_v3'] = self::getDecimal('Back-up L3 Voltage', 114, 2, 10, $data, 'V');
            $result['backup_i3'] = self::getDecimal('Back-up L3 Current', 116, 2, 10, $data, 'A');
            $result['backup_f3'] = self::getDecimal('Back-up L3 Frequency', 118, 2, 100, $data, 'Hz');
            $result['load_mode3'] = self::getInteger('Load Mode L3', 120, 2, $data);
            $result['backup_p3'] = self::getInteger('Back-up L3 Power', 124, 2, $data, 'W');
            // backup loads
            $result['load_p1'] = self::getInteger('Load L1', 128, 2, $data, 'W');
            $result['load_p2'] = self::getInteger('Load L2', 132, 2, $data, 'W');
            $result['load_p3'] = self::getInteger('Load L3', 136, 2, $data, 'W');
            $result['backup_ptotal'] = self::getInteger('Back-up Load', 140, 2, $data, 'W');
            $result['load_ptotal'] = self::getInteger('Load', 144, 2, $data, 'W');
            $result['ups_load'] = self::getInteger('Ups Load', 146, 2, $data, 'W');
            // temperatures
            $result['temperature_air'] = self::getDecimal('Inverter Temperature (Air)', 148, 2, 10, $data, '°C');
            $result['temperature_module'] = self::getDecimal('Inverter Temperature (Module)', 150, 2, 10, $data, '°C');
            $result['temperature'] = self::getDecimal('Inverter Temperature (Radiator)', 152, 2, 10, $data, '°C');
            // function
            $result['function_bit'] = self::getInteger('Function Bit', 154, 2, $data);
            // bus
            $result['bus_voltage'] = self::getDecimal('Bus Voltage', 156, 2, 10, $data, 'V');
            $result['nbus_voltage'] = self::getDecimal('NBus Voltage', 158, 2, 10, $data, 'V');
            // battery
            $result['vbattery1'] = self::getDecimal('Battery Voltage', 160, 2, 10, $data, 'V');
            $result['ibattery1'] = self::getDecimal('Battery Current', 162, 2, 10, $data, 'A');
            $result['pbattery1'] = self::getCustomValue('Battery Power', round($result['vbattery1']['clear_val'] * $result['ibattery1']['clear_val']), 'W');
            $result['battery_mode'] = self::getInteger('Battery Mode code', 168, 2, $data);
            $result['battery_mode_label'] = self::getCustomValue('Battery Mode', Goodwe\Dictionary::$BATTERY_MODES[$result['battery_mode']['clear_val']]);
            // status
            $result['warning_code'] = self::getInteger('Warning code', 170, 2, $data);
            $result['safety_country'] = self::getInteger('Safety Country code', 172, 2, $data);
            $result['safety_country_label'] = self::getCustomValue('Safety Country', Goodwe\Dictionary::$SAFETY_COUNTRIES[$result['safety_country']['clear_val']]);
            $result['work_mode'] = self::getInteger('Work Mode code', 174, 2, $data);
            $result['work_mode_label'] = self::getCustomValue('Work Mode', Goodwe\Dictionary::$WORK_MODES[$result['work_mode']['clear_val']]);
            $result['operation_mode'] = self::getInteger('Operation Mode code', 176, 2, $data);
            $result['error_codes'] = self::getInteger('Error Codes', 178, 4, $data);
            $result['errors'] = self::getBitmap('Errors', $result['error_codes']['clear_val'], Goodwe\Dictionary::$ERROR_CODES);
            // totals
            $result['e_total'] = self::getDecimal('Total PV Generation', 182, 4, 10, $data, 'kWh');
            $result['e_day'] = self::getDecimal('Today\'s PV Generation', 186, 4, 10, $data, 'kWh');
            $result['e_total_exp'] = self::getDecimal('Total Energy (export)', 190, 4, 10, $data, 'kWh');
            $result['h_total'] = self::getInteger('Hours Total', 194, 4, $data, 'h');
            $result['e_day_exp'] = self::getDecimal('Today Energy (export)', 198, 2, 10, $data, 'kWh');
            $result['e_total_imp'] = self::getDecimal('Total Energy (import)', 200, 4, 10, $data, 'kWh');
            $result['e_day_imp'] = self::getDecimal('Today Energy (import)', 204, 2, 10, $data, 'kWh');
            $result['e_load_total'] = self::getDecimal('Total Load', 206, 4, 10, $data, 'kWh');
            $result['e_load_day'] = self::getDecimal('Today Load', 210, 2, 10, $data, 'kWh');
            $result['e_bat_charge_total'] = self::getDecimal('Total Battery Charge', 212, 4, 10, $data, 'kWh');
            $result['e_bat_charge_day'] = self::getDecimal('Today Battery Charge', 216, 2, 10, $data, 'kWh');
            $result['e_bat_discharge_total'] = self::getDecimal('Total Battery Discharge', 218, 4, 10, $data, 'kWh');
            $result['e_bat_discharge_day'] = self::getDecimal('Today Battery Discharge', 222, 2, 10, $data, 'kWh');
            // diagnose
            $result['diagnose_result'] = self::getInteger('Diag Status Code', 240, 4, $data);
            $result['diagnose_result_label'] = self::getBitmap('Diag Status', $result['diagnose_result']['clear_val'], Goodwe\Dictionary::$DIAG_STATUS_CODES);
            // sum
            $result['house_consumption'] = self::getCustomValue('House Consumption',
                                                    (
                                                        $result['ppv1']['clear_val'] +
                                                        $result['ppv2']['clear_val'] +
                                                        $result['ppv3']['clear_val'] +
                                                        $result['ppv4']['clear_val'] +
                                                        $result['pbattery1']['clear_val'] -
                                                        $result['active_power']['clear_val']
                                                    ),
                                                    'W');
        }

        if ($source == 'battery') {
            $result['battery_bms'] = self::getInteger('Battery BMS', 0, 2, $data);
            $result['battery_index'] = self::getInteger('Battery Index', 2, 2, $data);
            $result['battery_status'] = self::getInteger('Battery Status', 4, 2, $data);
            $result['battery_temperature'] = self::getDecimal('Battery Temperature', 6, 2, 10, $data, '°C');
            $result['battery_charge_limit'] = self::getInteger('Battery Charge Limit', 8, 2, $data, 'A');
            $result['battery_discharge_limit'] = self::getInteger('Battery Discharge Limit', 10, 2, $data, 'A');
            $result['battery_error_l'] = self::getInteger('Battery Error L', 12, 2, $data);
            $result['battery_soc'] = self::getInteger('Battery State of Charge', 14, 2, $data, '%');
            $result['battery_soh'] = self::getInteger('Battery State of Health', 16, 2, $data, '%');
            $result['battery_modules'] = self::getInteger('Battery Modules', 18, 2, $data);
            $result['battery_warning_l'] = self::getInteger('Battery Warning L', 20, 2, $data);
            $result['battery_protocol'] = self::getInteger('Battery Protocol', 22, 2, $data);
            $result['battery_error_h'] = self::getInteger('Battery Error H', 24, 2, $data);
            $result['battery_error'] = self::getBitmap('Battery Error', (($result['battery_error_h']['clear_val'] << 16) + $result['battery_error_l']['clear_val']), Goodwe\Dictionary::$BMS_ALARM_CODES);
            $result['battery_warning_h'] = self::getInteger('Battery Warning H', 28, 2, $data);
            $result['battery_warning'] = self::getBitmap('Battery Warning', (($result['battery_warning_h']['clear_val'] << 16) + $result['battery_warning_l']['clear_val']), Goodwe\Dictionary::$BMS_WARNING_CODES);
            $result['battery_sw_version'] = self::getInteger('Battery Software Version', 30, 2, $data);
            $result['battery_hw_version'] = self::getInteger('Battery Hardware Version', 32, 2, $data);
            $result['battery_max_cell_temp_id'] = self::getInteger('Battery Max Cell Temperature ID', 34, 2, $data);
            $result['battery_min_cell_temp_id'] = self::getInteger('Battery Min Cell Temperature ID', 36, 2, $data);
            $result['battery_max_cell_voltage_id'] = self::getInteger('Battery Max Cell Voltage ID', 38, 2, $data);
            $result['battery_min_cell_voltage_id'] = self::getInteger('Battery Min Cell Voltage ID', 40, 2, $data);
            $result['battery_max_cell_temp'] = self::getDecimal('Battery Max Cell Temperature', 42, 2, 10, $data, '°C');
            $result['battery_min_cell_temp'] = self::getDecimal('Battery Min Cell Temperature', 44, 2, 10, $data, '°C');
            $result['battery_max_cell_voltage'] = self::getDecimal('Battery Max Cell Voltage', 46, 2, 10, $data, 'V');
            $result['battery_min_cell_voltage'] = self::getDecimal('Battery Min Cell Voltage', 48, 2, 10, $data, 'V');
        }

        if ($source == 'meter') {
            // status
            $result['commode'] = self::getInteger('Commode', 0, 2, $data);
            $result['rssi'] = self::getInteger('RSSI', 2, 2, $data);
            $result['manufacture_code'] = self::getInteger('Manufacture Code', 4, 2, $data);
            $result['meter_test_status'] = self::getInteger('Meter Test Status', 6, 2, $data);
            $result['meter_test_status_label'] = self::getCustomValue('Meter Test', Goodwe\Dictionary::$METER_STATUS_CODES[$result['meter_test_status']['clear_val']]);
            $result['meter_comm_status'] = self::getInteger('Meter Communication Status', 8, 2, $data);
            $result['meter_comm_status_label'] = self::getCustomValue('Meter Communication', Goodwe\Dictionary::$METER_COMMUNICATION_CODES[$result['meter_comm_status']['clear_val']]);
            // active power
            $result['active_power1'] = self::getInteger('Active Power L1', 10, 2, $data, 'W');
            $result['active_power2'] = self::getInteger('Active Power L2', 12, 2, $data, 'W');
            $result['active_power3'] = self::getInteger('Active Power L3', 14, 2, $data, 'W');
            $result['active_power_total'] = self::getInteger('Active Power Total', 16, 2, $data, 'W');
            $result['reactive_power_total'] = self::getInteger('Reactive Power Total', 18, 2, $data, 'var');
            // meter power
            $result['meter_power_factor1'] = self::getDecimal('Meter Power Factor L1', 20, 2, 1000, $data, 'W');
            $result['meter_power_factor2'] = self::getDecimal('Meter Power Factor L2', 22, 2, 1000, $data, 'W');
            $result['meter_power_factor3'] = self::getDecimal('Meter Power Factor L3', 24, 2, 1000, $data, 'W');
            $result['meter_power_factor'] = self::getDecimal('Meter Power Factor', 26, 2, 1000, $data, 'W');
            $result['meter_freq'] = self::getDecimal('Meter Frequency', 28, 2, 100, $data, 'Hz');
            // meter total
            $result['meter_e_total_exp'] = self::getFloat('Meter Total Energy (export)', 30, 4, 1000, $data, 'kWh');
            $result['meter_e_total_imp'] = self::getFloat('Meter Total Energy (import)', 34, 4, 1000, $data, 'kWh');
            // meter active power
            $result['meter_active_power1'] = self::getInteger('Meter Active Power L1', 38, 4, $data, 'W');
            $result['meter_active_power2'] = self::getInteger('Meter Active Power L2', 42, 4, $data, 'W');
            $result['meter_active_power3'] = self::getInteger('Meter Active Power L3', 46, 4, $data, 'W');
            $result['meter_active_power_total'] = self::getInteger('Meter Active Power Total', 50, 4, $data, 'W');
            // meter reactive power
            $result['meter_reactive_power1'] = self::getInteger('Meter Reactive Power L1', 54, 4, $data, 'var');
            $result['meter_reactive_power2'] = self::getInteger('Meter Reactive Power L2', 58, 4, $data, 'var');
            $result['meter_reactive_power3'] = self::getInteger('Meter Reactive Power L3', 62, 4, $data, 'var');
            $result['meter_reactive_power_total'] = self::getInteger('Meter Reactive Power Total', 66, 4, $data, 'var');
            // meter apparent power
            $result['meter_apparent_power1'] = self::getInteger('Meter Apparent Power L1', 70, 4, $data, 'VA');
            $result['meter_apparent_power2'] = self::getInteger('Meter Apparent Power L2', 74, 4, $data, 'VA');
            $result['meter_apparent_power3'] = self::getInteger('Meter Apparent Power L3', 78, 4, $data, 'VA');
            $result['meter_apparent_power_total'] = self::getInteger('Meter Apparent Power Total', 82, 4, $data, 'VA');
            // meter type
            $result['meter_type'] = self::getInteger('Meter Type', 86, 2, $data);
            $result['meter_sw_version'] = self::getInteger('Meter Software Version', 88, 2, $data);
        }

        return $result;
    }

    private static function getInteger($name, $offset, $length, $data, $unit = '', $signed = true) {
        $i = 0;
        while (!isset($data[$offset + $length - 1]) && $length > 0) {
            $length--;
        }
        if ($length == 1) {
            $i = hexdec($data[$offset]);
            if ($signed && $i > ((2 << 7) / 2)) $i = $i - (2 << 7);
        }
        if ($length == 2) {
            $i = (hexdec($data[$offset]) << 8) +
                 hexdec($data[$offset + 1]);
            if ($signed && $i > ((2 << 15) / 2)) $i = $i - (2 << 15);
        }
        if ($length == 4) {
            $i = (hexdec($data[$offset]) << 24) +
                 (hexdec($data[$offset + 1]) << 16) +
                 (hexdec($data[$offset + 2]) << 8) +
                 hexdec($data[$offset + 3]);
                 if ($signed && $i > ((2 << 31) / 2)) $i = $i - (2 << 31);
        }

        return ['name' => $name, 'clear_val' => $i, 'human_val' => $i . (($unit != '') ? ' ' . $unit  : '')];
    }

    private static function getDecimal($name, $offset, $length, $scale, $data, $unit = '') {
        $result = self::getInteger($name, $offset, $length, $data, $unit);

        return ['name' => $result['name'], 'clear_val' => ($result['clear_val'] / $scale), 'human_val' => ($result['clear_val'] / $scale) . (($unit != '') ? ' ' . $unit  : '')];
    }

    private static function getTimestamp($name, $offset, $data) {
        $date = (hexdec($data[$offset]) + 2000)
        . '-' . SubStr('0' . hexdec($data[$offset + 1]), -2)
        . '-' . SubStr('0' . hexdec($data[$offset + 2]), -2)
        . ' ' . SubStr('0' . hexdec($data[$offset + 3]), -2)
        . ':' . SubStr('0' . hexdec($data[$offset + 4]), -2)
        . ':' . SubStr('0' . hexdec($data[$offset + 5]), -2);

        return ['name' => $name, 'clear_val' => strtotime($date), 'human_val' => $date];
    }

    private static function getCustomValue($name, $value, $unit = '') {
        return ['name' => $name, 'clear_val' => $value, 'human_val' => $value . (($unit != '') ? ' ' . $unit  : '')];
    }

    private static function getBitmap($name, $value, $map) {
        $result = [];
        for ($i = 0; $i < count($map); $i++) {
            if ($value & 0x1 == 1) {
                $result[] = $map[$i];
            }
            $value = floor($value / 2);
        }

        return ['name' => $name, 'clear_val' => implode(', ', $result), 'human_val' => implode(', ', $result)];
    }

    private static function getFloat($name, $offset, $length, $scale, $data, $unit = '') {
        $i = 0;
        if ($length == 4) {
            $i = unpack('G',
                                chr(hexdec($data[$offset])) .
                                chr(hexdec($data[$offset + 1])) .
                                chr(hexdec($data[$offset + 2])) .
                                chr(hexdec($data[$offset + 3]))
                        )[1];
        }

        return ['name' => $name, 'clear_val' => ($i / $scale), 'human_val' => ($i / $scale) . (($unit != '') ? ' ' . $unit  : '')];
    }

}
