<?php

namespace App\Traits;

trait GeneralHelperTrait
{
    /**
     * @return int
     * @throws \Exception
     */
    public function generateUniqueId(): int
    {
        return now()->microsecond * random_int(1,999);
    }
}
