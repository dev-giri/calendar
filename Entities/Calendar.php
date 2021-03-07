<?php

namespace Modules\Calendar\Entities;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calendar extends Model
{
    //use HasFactory;

    protected $fillable = [
        'host_id', 'title', 'start', 'end', 'lable', 'description', 'url', 'address'
        ];
    
    // protected static function newFactory()
    // {
    //     return \Modules\Calendar\Database\factories\CalendarFactory::new();
    // }
}
