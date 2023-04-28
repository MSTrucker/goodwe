<?php

include '../src/goodwe.php';

$inv = new Goodwe\Inverter('192.168.5.40');
// $inv = new Goodwe\Inverter('192.168.6.141');

$data = $inv->getData('inverter');
// var_dump($data);
if (isset($data['data']) && $data['data'] != null)
    $invData = Goodwe\Sensors::fillSensorsData('inverter', $data['data']);

if (($invData['battery_mode']['clear_val'] ?? 0) != 0) {
    $battery = $inv->getData('battery');
    // var_dump($battery);
    if (isset($battery['data']) && $battery['data'] != null)
        $batData = Goodwe\Sensors::fillSensorsData('battery', $battery['data']);
}

$meter = $inv->getData('meter');
// var_dump($meter);
if (isset($meter['data']) && $meter['data'] != null)
    $metData = Goodwe\Sensors::fillSensorsData('meter', $meter['data']);

// echo json_encode($invData);
// echo json_encode($batData);
// echo json_encode($metData);
var_dump($invData);
var_dump($batData);
var_dump($metData);
