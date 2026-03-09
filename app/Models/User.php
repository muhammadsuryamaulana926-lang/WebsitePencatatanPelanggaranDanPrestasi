<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'guru_id',
        'username',
        'password',
        'level',
        'can_verify'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'username', 'nis');
    }

    public function orangtua()
    {
        return $this->hasMany(Orangtua::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getNameAttribute()
    {
        return $this->username;
    }

    public function isAdmin(): bool
    {
        return $this->level === 'admin';
    }
    public function isGuru(): bool
    {
        return $this->level === 'guru';
    }
    public function isBK(): bool
    {
        return $this->level === 'bk';
    }
    public function isWaliKelas(): bool
    {
        return $this->level === 'walikelas';
    }
    public function isKesiswaan(): bool
    {
        return $this->level === 'kesiswaan';
    }
    public function isKepalaSekolah(): bool
    {
        return $this->level === 'kepalasekolah';
    }
    public function isSiswa(): bool
    {
        return $this->level === 'siswa';
    }
    public function isOrtu(): bool
    {
        return $this->level === 'ortu';
    }
}
