<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'cover_img',
        'description',
        'price',
        'currency_id',
        'language_id',
    ];
}
