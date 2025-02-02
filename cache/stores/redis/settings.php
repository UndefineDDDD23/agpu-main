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
 * Redis Cache Store - Settings
 *
 * @package   cachestore_redis
 * @copyright 2013 Adam Durana
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$settings->add(
    new admin_setting_configcheckbox(
        name: 'cachestore_redis/test_clustermode',
        visiblename: get_string('clustermode', 'cachestore_redis'),
        description: cache_helper::is_cluster_available() ?
            get_string('clustermode_help', 'cachestore_redis') :
            get_string('clustermodeunavailable', 'cachestore_redis'),
        defaultsetting: 0,
    )
);

$settings->add(
    new admin_setting_configtextarea(
        name: 'cachestore_redis/test_server',
        visiblename: get_string('test_server', 'cachestore_redis'),
        description: get_string('test_server_desc', 'cachestore_redis'),
        defaultsetting: '',
        paramtype: PARAM_TEXT,
    )
);

$settings->add(new admin_setting_configcheckbox(
        'cachestore_redis/test_encryption',
        get_string('encrypt_connection', 'cachestore_redis'),
        get_string('encrypt_connection', 'cachestore_redis'),
        false));
$settings->add(
    new admin_setting_configtext(
        'cachestore_redis/test_cafile',
        get_string('ca_file', 'cachestore_redis'),
        get_string('ca_file', 'cachestore_redis'),
        '',
        PARAM_TEXT,
        16
    )
);
$settings->add(
    new admin_setting_configpasswordunmask(
        'cachestore_redis/test_password',
        get_string('test_password', 'cachestore_redis'),
        get_string('test_password_desc', 'cachestore_redis'),
        ''
    )
);

if (class_exists('Redis')) { // Only if Redis is available.

    $options = array(Redis::SERIALIZER_PHP => get_string('serializer_php', 'cachestore_redis'));

    if (defined('Redis::SERIALIZER_IGBINARY')) {
        $options[Redis::SERIALIZER_IGBINARY] = get_string('serializer_igbinary', 'cachestore_redis');
    }

    $settings->add(new admin_setting_configselect(
            'cachestore_redis/test_serializer',
            get_string('test_serializer', 'cachestore_redis'),
            get_string('test_serializer_desc', 'cachestore_redis'),
            Redis::SERIALIZER_PHP,
            $options
        )
    );
}

$settings->add(new admin_setting_configcheckbox(
        'cachestore_redis/test_ttl',
        get_string('test_ttl', 'cachestore_redis'),
        get_string('test_ttl_desc', 'cachestore_redis'),
        false));
