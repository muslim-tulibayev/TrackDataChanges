<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Change extends Model
{
    protected $fillable = [
        'changeable_id',
        'changeable_type',
        'change_description',
        'data_key',
        'linkedable_id',
        'linkedable_type'
    ];

    // public function changer()
    // {
    //     return $this->morphTo('changeable');
    // }

    public function changeable(): MorphTo
    {
        return $this->morphTo();
    }

    public function linkedable(): MorphTo
    {
        return $this->morphTo();
    }
}
