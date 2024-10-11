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
 * Default block generator class.
 *
 * @package    core
 * @category   test
 * @copyright  2021 agpu Pty Ltd. (http://agpu.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Default block generator class to be used when a specific one is not supported.
 *
 * @package    core
 * @category   test
 * @copyright  2021 agpu Pty Ltd. (http://agpu.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class default_block_generator extends testing_block_generator {

    /**
     * @var string
     */
    private $blockname;

    /**
     * Constructor.
     * @param testing_data_generator $datagenerator
     * @param string $blockname
     */
    public function __construct(testing_data_generator $datagenerator, string $blockname) {
        parent::__construct($datagenerator);

        $this->blockname = $blockname;
    }

    /**
     * {@inheritdoc}
     */
    public function get_blockname() {
        return $this->blockname;
    }

}
