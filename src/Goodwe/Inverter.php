<?php

namespace Goodwe;

use Goodwe;


class Inverter {

    /** @var string */
    private $ip;
    /** @var int */
    private $port_data;

    /**
     * Create inverter class
     */
    public function __construct($ip, $port_data = 8899) {
        $this->ip = $ip;
        $this->port_data = $port_data;
    }

    public function getData($source) {
        if ($source == 'inverter') {
            $packet = chr(247).chr(3).chr(137).chr(28).chr(0).chr(125).chr(122).chr(231);
        }
        if ($source == 'battery') {
            $packet = chr(247).chr(3).chr(144).chr(136).chr(0).chr(24).chr(252).chr(124);
        }

        if ($source == 'meter') {
            $packet = chr(247).chr(3).chr(140).chr(160).chr(0).chr(45).chr(187).chr(243);
        }

        if (($packet ?? '') != '') {
            do {
                $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
                socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => 1, 'usec' => 0]);
                socket_sendto($socket, $packet, strlen($packet), 0, $this->ip, $this->port_data);
                socket_recvfrom($socket, $buffer, 32768, 0, $ip, $port);
                socket_close($socket);
            } while (is_null($buffer));

            $data = str_split(SubStr(bin2hex($buffer), 10, -2), 2);
        } else {
            return null;
        }

        return ['ip' => $ip, 'port' => $port, 'data' => $data];
    }

    public static function searchInverter($cycles = 5) {
        $packet = 'WIFIKIT-214028-READ';
        $inverters = [];

        for ($x = 0; $x < $cycles; $x++) {
            $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => 1, 'usec' => 0]);
            socket_set_option($socket, SOL_SOCKET, SO_BROADCAST, 1);
            socket_sendto($socket, $packet, strlen($packet), 0, '255.255.255.255', 48899);
            for ($i = 0; $i < $cycles; $i++) {
                socket_recvfrom($socket, $buffer, 32768, 0, $ip, $port);
                $inverters[$ip] = ['ip' => $ip, 'port' => $port, 'data' => $buffer];
            }
            socket_close($socket);
        }

        return $inverters;
    }

}
