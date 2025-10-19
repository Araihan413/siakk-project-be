<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_section_id',
        'label',
        'name',
        'type',
        'options',
        'is_required',
        'default_value',
        'order_index',
        'extra_config',
    ];

    protected $casts = [
        'options' => 'array',
        'extra_config' => 'array',
        'is_required' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(FormSection::class, 'form_section_id');
    }
}
