<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

trait EncryptTrait
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->encryptable) && !is_null($value)) {
            $value = Crypt::decrypt($value);
        }

        return $value;
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable) && !is_null($value)) {
            $value = Crypt::encrypt($value);
        }

        parent::setAttribute($key, $value);
    }
}