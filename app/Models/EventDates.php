<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDates extends Model
{
  use HasFactory;
  protected $fillable = ['event', 'event_date'];
}
