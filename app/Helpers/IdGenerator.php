<?php

namespace App\Helpers;

use App\Models\User;

class IdGenerator
{
    public static function generateUserId()
    {
        do {
            $id = 'USR' . str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT);
        } while (User::where('idUser', $id)->exists());

        return $id;
    }
}