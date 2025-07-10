<?php
namespace App\Policies;

use App\Models\Award;
use App\Models\User;

class AwardPolicy
{
    public function delete(User $user, Award $award)
    {
        return $user->id === $award->user_id;
    }
}
