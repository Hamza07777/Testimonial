<?php

namespace Modules\Testimonial\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Testimonial extends Model
{
    use HasFactory; 

    protected $fillable = ['name', 'description', 'designation', 'profile_image', 'logo' ];

    protected static function newFactory()
    {
        return \Modules\Testimonial\Database\factories\TestimonialFactory::new();
    }
    
}
