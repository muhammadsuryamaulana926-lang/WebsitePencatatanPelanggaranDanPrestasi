<?php

namespace App\Policies;

use App\Models\Guru;
use App\Models\User;

class GuruPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isKesiswaan() || $user->isGuru() || $user->isBK() || $user->isWaliKelas() || $user->isKepalaSekolah();
    }

    public function view(User $user, Guru $guru): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Guru $guru): bool
    {
        return $user->isAdmin() || ($user->guru_id === $guru->id);
    }

    public function delete(User $user, Guru $guru): bool
    {
        return $user->isAdmin();
    }
}
