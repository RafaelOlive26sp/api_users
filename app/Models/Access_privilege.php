<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access_privilege extends Model
{
    use HasFactory;
    protected $table = 'access_privileges';
    protected $fillable = ['id','privileges'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
