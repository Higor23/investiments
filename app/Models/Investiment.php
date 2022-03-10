<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investiment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'value',
        'investiment_date'
    ];

    public function user()
    {
        return $this->hasbelogsTo(User::class);
    }
}
