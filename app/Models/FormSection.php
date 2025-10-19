<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'title',
        'description',
        'order_index',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function fields()
    {
        return $this->hasMany(FormField::class);
    }
}
