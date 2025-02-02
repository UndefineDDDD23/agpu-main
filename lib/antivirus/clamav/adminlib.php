<?php
// This file is part of agpu - http://agpu.org/
//
// agpu is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// agpu is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with agpu.  If not, see <http://www.gnu.org/licenses/>.

/**
 * ClamAV antivirus adminlib.
 *
 * @package    antivirus_clamav
 * @copyright  2015 Ruslan Kabalin, Lancaster University.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * Admin setting for running, adds verification.
 *
 * @package    antivirus_clamav
 * @copyright  2015 Ruslan Kabalin, Lancaster University.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class antivirus_clamav_runningmethod_setting extends admin_setting_configselect {
    /**
     * Save a setting
     *
     * @param string $data
     * @return string empty or error string
     */
    public function write_setting($data) {
        $validated = $this->validate($data);
        if ($validated !== true) {
            return $validated;
        }
        return parent::write_setting($data);
    }

    /**
     * Validate data.
     *
     * This ensures that the selected socket transport is supported by this system.
     *
     * @param string $data
     * @return mixed True on success, else error message.
     */
    public function validate($data) {
        $supportedtransports = stream_get_transports();
        if ($data === 'unixsocket') {
            if (array_search('unix', $supportedtransports) === false) {
                return get_string('errornounixsocketssupported', 'antivirus_clamav');
            }
        } else if ($data === 'tcpsocket') {
            if (array_search('tcp', $supportedtransports) === false) {
                return get_string('errornotcpsocketssupported', 'antivirus_clamav');
            }
        }
        return true;
    }
}


/**
 * Abstract socket checking class
 *
 * @package    antivirus_clamav
 * @copyright  2015 Ruslan Kabalin, Lancaster University.
 * @copyright  2019 Didier Raboud, Liip AG.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class antivirus_clamav_socket_setting extends admin_setting_configtext {
    /**
     * Ping ClamAV socket.
     *
     * This ensures that a socket setting is correct and that ClamAV is running.
     *
     * @param string $socketaddress Address to the socket to connect to (for stream_socket_client)
     * @return mixed True on success, else error message.
     */
    protected function validate_clamav_socket($socketaddress) {
        $socket = stream_socket_client($socketaddress, $errno, $errstr, ANTIVIRUS_CLAMAV_SOCKET_TIMEOUT);
        if (!$socket) {
            return get_string('errorcantopensocket', 'antivirus_clamav', "$errstr ($errno)");
        } else {
            // Send PING query to ClamAV socket to check its running state.
            fwrite($socket, "nPING\n");
            $response = stream_get_line($socket, 4);
            fclose($socket);
            if ($response !== 'PONG') {
                return get_string('errorclamavnoresponse', 'antivirus_clamav');
            }
        }
        return true;
    }
}
/**
 * Admin setting for unix socket path, adds verification.
 *
 * @package    antivirus_clamav
 * @copyright  2015 Ruslan Kabalin, Lancaster University.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class antivirus_clamav_pathtounixsocket_setting extends antivirus_clamav_socket_setting {
    /**
     * Validate data.
     *
     * This ensures that unix socket setting is correct and ClamAV is running.
     *
     * @param string $data
     * @return mixed True on success, else error message.
     */
    public function validate($data) {
        $result = parent::validate($data);
        if ($result !== true) {
            return $result;
        }
        $runningmethod = get_config('antivirus_clamav', 'runningmethod');
        if ($runningmethod === 'unixsocket') {
            return $this->validate_clamav_socket('unix://' . $data);
        }
        return true;
    }
}

/**
 * Admin setting for Internet domain socket host, adds verification.
 *
 * @package    antivirus_clamav
 * @copyright  2019 Didier Raboud, Liip AG.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class antivirus_clamav_tcpsockethost_setting extends antivirus_clamav_socket_setting {
    /**
     * Validate data.
     *
     * This ensures that Internet domain socket setting is correct and ClamAV is running.
     *
     * @param string $data
     * @return mixed True on success, else error message.
     */
    public function validate($data) {
        $result = parent::validate($data);
        if ($result !== true) {
            return $result;
        }
        $runningmethod = get_config('antivirus_clamav', 'runningmethod');
        $tcpport = get_config('antivirus_clamav', 'tcpsocketport');
        if ($tcpport === false) {
            $tcpport = 3310;
        }
        if ($runningmethod === 'tcpsocket') {
            return $this->validate_clamav_socket('tcp://' . $data . ':' . $tcpport);
        }
        return true;
    }
}