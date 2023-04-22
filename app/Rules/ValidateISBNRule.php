<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateISBNRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $numberOfDigits = preg_match_all("/[0-9]/", $value);

        return $numberOfDigits == 10 || $numberOfDigits == 13;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'ISBN should be either 10 or 13 digits.';
    }
}
