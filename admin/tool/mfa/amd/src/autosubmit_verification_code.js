
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
 * Module to autosubmit the verification code element when it reaches 6 characters.
 *
 * @module     tool_mfa/autosubmit_verification_code
 * @copyright  2020 Peter Burnett <peterburnett@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

export const init = () => {
    const codeInput = document.querySelector("#id_verificationcode");
    const codeForm = codeInput.closest("form");
    const submitButton = codeForm.querySelector("#id_submitbutton");

    // Event listener for code input field.
    codeInput.addEventListener('keyup', function() {
        if (this.value.length >= 6) {
            // Submits the closes form (parent).
            codeForm.submit();
        }
    });

    // Disable the submit button if the input field is disabled.
    // This occurs if there are no more attempts left for the factor.
    if (codeInput.disabled) {
        submitButton.disabled = true;
    }
};
