<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    //
    protected $table = 'attendees';
    protected $fillable = ['email','full_name'];
}
