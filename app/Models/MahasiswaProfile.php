<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'npm',
        'program_studi',
        'semester',
        'usia',
        'jenis_kelamin',
        'alamat',
        'no_hp',
    ];

//     public function responses()
// {
//     return $this->hasMany(FormResponse::class, 'mahasiswa_id');
// }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
