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
 * Constraint that checks a simple object with an isEqual constrain, allowing for exceptions to be made for some fields.
 *
 * @package    core
 * @category   phpunit
 * @copyright  2015 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Constraint that checks a simple object with an isEqual constrain, allowing for exceptions to be made for some fields.
 *
 * @package    core
 * @category   phpunit
 * @copyright  2015 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class phpunit_constraint_object_is_equal_with_exceptions extends PHPUnit\Framework\Constraint\Constraint {

    /**
     * @var array $keys The list of exceptions.
     */
    protected $keys = array();

    /**
     * @var mixed $value Need to keep it here because it became private for PHPUnit 7.x and up
     */
    protected $capturedvalue;

    /**
     * @var \PHPUnit\Framework\Constraint\IsEqual $isequal original constraint to be used internally.
     */
    protected $isequal;

    /**
     * Override constructor to capture value
     */
    public function __construct($value, float $delta = 0.0, int $maxDepth = 10, bool $canonicalize = false,
                                bool $ignoreCase = false) {
        $this->isequal = new \PHPUnit\Framework\Constraint\IsEqual($value, $delta, $maxDepth, $canonicalize, $ignoreCase);
        $this->capturedvalue = $value;
    }

    /**
     * Add an exception for the named key to use a different comparison
     * method. Any assertion provided by PHPUnit\Framework\Assert is
     * acceptable.
     *
     * @param string $key The key to except.
     * @param string $comparator The assertion to use.
     */
    public function add_exception($key, $comparator) {
        $this->keys[$key] = $comparator;
    }

    /**
     * Evaluates the constraint for parameter $other
     *
     * If $shouldreturnesult is set to false (the default), an exception is thrown
     * in case of a failure. null is returned otherwise.
     *
     * If $shouldreturnesult is true, the result of the evaluation is returned as
     * a boolean value instead: true in case of success, false in case of a
     * failure.
     *
     * @param  mixed    $other              Value or object to evaluate.
     * @param  string   $description        Additional information about the test
     * @param  bool     $shouldreturnesult  Whether to return a result or throw an exception
     * @return mixed
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public function evaluate($other, string $description = '', bool $shouldreturnesult = false): ?bool {
        foreach ($this->keys as $key => $comparison) {
            if (isset($other->$key) || isset($this->capturedvalue->$key)) {
                // One of the keys is present, therefore run the comparison.
                PHPUnit\Framework\Assert::$comparison($this->capturedvalue->$key, $other->$key);

                // Unset the keys, otherwise the standard evaluation will take place.
                unset($other->$key);
                unset($this->capturedvalue->$key);
            }
        }

        // Run the IsEqual evaluation.
        return $this->isequal->evaluate($other, $description, $shouldreturnesult);
    }

    // \PHPUnit\Framework\Constraint\IsEqual wrapping.
    public function toString(): string {
        return $this->isequal->toString();
    }

}
