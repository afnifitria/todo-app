<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TaskList;

class Task extends Model
{
    // Menentukan atribut yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'name',         // Nama tugas
        'description',  // Deskripsi tugas
        'is_completed', // Status apakah tugas sudah selesai atau belum
        'priority',     // Prioritas tugas (low, medium, high)
        'list_id'       // ID dari daftar tugas terkait
    ];

    // Menentukan atribut yang tidak boleh diisi secara massal (mass assignment)
    protected $guarded = [
        'id',         // ID tugas (tidak boleh diubah oleh mass assignment)
        'created_at', // Timestamp saat tugas dibuat
        'updated_at'  // Timestamp saat tugas diperbarui
    ];

    // Konstanta yang menyimpan daftar prioritas yang tersedia
    const PRIORITIES = [
        'low',
        'medium',
        'high'
    ];

    /**
     * Method accessor untuk mendapatkan kelas CSS berdasarkan prioritas tugas.
     * Digunakan untuk styling di tampilan frontend.
     */
    public function getPriorityClassAttribute() {
        return match($this->attributes['priority']) {
            'low' => 'success',   // Jika prioritas rendah, gunakan kelas 'success' (hijau)
            'medium' => 'warning', // Jika prioritas sedang, gunakan kelas 'warning' (kuning)
            'high' => 'danger',   // Jika prioritas tinggi, gunakan kelas 'danger' (merah)
            default => 'secondary' // Jika tidak ada prioritas yang cocok, gunakan kelas default 'secondary' (abu-abu)
        };
    }

    /**
     * Relasi ke model TaskList (Setiap tugas milik satu daftar tugas).
     */
    public function list() {
        return $this->belongsTo(TaskList::class, 'list_id');
    }
}
