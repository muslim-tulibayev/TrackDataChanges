<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        "sequence_number",
        "name",
        "course_id",
    ];

    public function changes()
    {
        return $this->morphMany(Change::class, 'linked');
    }
}
