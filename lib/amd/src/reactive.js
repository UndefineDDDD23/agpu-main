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
 * Generic reactive module used in the course editor.
 *
 * @module     core/reactive
 * @copyright  2021 Ferran Recio <ferran@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import BaseComponent from 'core/local/reactive/basecomponent';
import Reactive from 'core/local/reactive/reactive';
import DragDrop from 'core/local/reactive/dragdrop';
import {initDebug} from 'core/local/reactive/debug';

// Register a debug module if we are in debug mode.
let debug;
if (M.cfg.developerdebug && M.reactive === undefined) {
    const debugOBject = initDebug();
    M.reactive = debugOBject.debuggers;
    debug = debugOBject.debug;
}

export {Reactive, BaseComponent, DragDrop, debug};
