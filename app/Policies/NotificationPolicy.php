<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DatabaseNotification $databaseNotification): bool
    {
        return $user->id === $databaseNotification->notifiable_id;
    }
}
