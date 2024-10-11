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
 * Endpoint to get the agpu version
 *
 * agpu linkchecker will check this endpoint when it cannot get the agpu version otherwise.
 *
 * @package    core
 * @copyright  2022 Victor Deniz <victor@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/filelib.php');

// Get public key.
$key = download_file_content(HUB_STATSPUBLICKEY);
// Check $key is a valid public key.
$publickey = openssl_pkey_get_public($key);
if ($publickey !== false) {
    $publickeystr = openssl_pkey_get_details($publickey)['key'];
} else {
    die('Error getting a valid public key');
}

// Encrypt data.
$message = $CFG->release;
$success = openssl_public_encrypt(\core_text::convert($message, 'ISO-8859-1', 'UTF-8'), $encrypteddata, $publickeystr);

if ($success) {
    echo base64_encode($encrypteddata);
} else {
    die ('Error encrypting the data');
}
