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
 * Backend generic code.
 *
 * @package tool_generator
 * @copyright 2013 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * Backend generic code for all tool_generator commands.
 *
 * @abstract
 * @package tool_generator
 * @copyright 2013 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class tool_generator_backend {
    /**
     * @var int Lowest (smallest) size index
     */
    const MIN_SIZE = 0;
    /**
     * @var int Highest (largest) size index
     */
    const MAX_SIZE = 5;
    /**
     * @var int Default size index
     */
    const DEFAULT_SIZE = 3;

    /**
     * @var bool True if we want a fixed dataset or false to generate random data
     */
    protected $fixeddataset;

    /**
     * @var int|bool Maximum number of bytes for file.
     */
    protected $filesizelimit;

    /**
     * @var bool True if displaying progress
     */
    protected $progress;

    /**
     * @var int Epoch time at which current step (current set of dots) started
     */
    protected $starttime;

    /**
     * @var int Size code (index in the above arrays)
     */
    protected $size;

    /**
     * @var progress_bar progressbar
     */
    protected $progressbar;

    /**
     * @var string Part of the language string.
     */
    protected $langstring;
    /**
     * @var string Module for the language string.
     */
    protected $module;
    /**
     * @var string|object|array|int Optional language string parameters.
     */
    protected $aparam;

    /**
     * Generic generator class
     *
     * @param int $size Size as numeric index
     * @param bool $fixeddataset To use fixed or random data
     * @param int|bool $filesizelimit The max number of bytes for a generated file
     * @param bool $progress True if progress information should be displayed
     * @throws coding_exception If parameters are invalid
     */
    public function __construct($size, $fixeddataset = false, $filesizelimit = false, $progress = true) {

        // Check parameter.
        if ($size < self::MIN_SIZE || $size > self::MAX_SIZE) {
            throw new coding_exception('Invalid size');
        }

        // Set parameters.
        $this->size = $size;
        $this->fixeddataset = $fixeddataset;
        $this->filesizelimit = $filesizelimit;
        $this->progress = $progress;
    }

    /**
     * Converts a size name into the numeric constant.
     *
     * @param string $sizename Size name e.g. 'L'
     * @return int Numeric version
     * @throws coding_exception If the size name is not known
     */
    public static function size_for_name($sizename) {
        for ($size = self::MIN_SIZE; $size <= self::MAX_SIZE; $size++) {
            if ($sizename == get_string('shortsize_' . $size, 'tool_generator')) {
                return $size;
            }
        }
        throw new coding_exception("Unknown size name '$sizename'");
    }

    /**
     * Displays information as part of progress.
     *
     * @param string $langstring Part of langstring (after progress_)
     * @param mixed $a Optional lang string parameters
     * @param bool $leaveopen If true, doesn't close LI tag (ready for dots)
     * @param string $module module for language string
     */
    public function log(string $langstring, $a = null, bool $leaveopen = false, string $module = 'tool_generator'): void {
        if (!$this->progress) {
            return;
        }

        $this->langstring = $langstring;
        $this->module = $module;
        $this->aparam = $a;

        $this->starttime = microtime(true);
        $this->progressbar = new progress_bar();
        $this->progressbar->create();
    }

    /**
     * Outputs dots. There is up to one dot per second. Once a minute, it
     * displays a percentage.
     *
     * @param int $number Number of completed items
     * @param int $total Total number of items to complete
     */
    public function dot(int $number, int $total): void {
        if (!$this->progress) {
            return;
        }
        $now = time();

        // Update time limit so PHP doesn't time out.
        if (!CLI_SCRIPT) {
            core_php_time_limit::raise(120);
        }
        $status = get_string('progress_' . $this->langstring, $this->module, $number);
        $this->progressbar->update($number, $total, $status);
    }

    /**
     * Ends a log string that was started using log function with $leaveopen.
     */
    public function end_log(): void {
        if (!$this->progress) {
            return;
        }
        $status = get_string('progress_' . $this->langstring, $this->module, $this->aparam);
        $done = get_string('done', 'tool_generator', round(microtime(true) - $this->starttime, 1));
        $this->progressbar->update_full(100, $status . ' - ' . $done);
    }
}
