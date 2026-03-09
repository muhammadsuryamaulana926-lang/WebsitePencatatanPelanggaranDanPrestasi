<?php

namespace App\Policies;

use App\Models\VerifikasiData;
use App\Models\User;

class VerifikasiDataPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isKesiswaan();
    }

    public function view(User $user, VerifikasiData $verifikasiData): bool
    {
        return $user->isAdmin() || $user->isKesiswaan();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isKesiswaan();
    }

    public function update(User $user, VerifikasiData $verifikasiData): bool
    {
        return $user->isAdmin() || $user->isKesiswaan();
    }

    public function delete(User $user, VerifikasiData $verifikasiData): bool
    {
        return $user->isAdmin();
    }
}
