<?php

namespace App\Exceptions;

use Exception;

class AdministratorDeletionException extends Exception
{
    public function render(){
        return response()->json(['message'=>'Deleting the administrator account is not allowed.'], 403);
    }
}
