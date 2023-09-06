<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerReview extends Model
{
    use HasFactory;
    protected $fillable=['comment','rate','worker_id' ,'client_id'] ;
}

