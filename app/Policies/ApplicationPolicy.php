<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    /**
     * Tenant viewing their own application.
     */
    public function view(User $user, Application $application): bool
    {
        return $user->id === $application->tenant_id
            || $user->id === $application->unit->property->owner_id;
    }

    /**
     * Owner approving/rejecting an application on their own property's unit.
     */
    public function manage(User $user, Application $application): bool
    {
        return $user->id === $application->unit->property->owner_id;
    }

    /**
     * Tenant cancelling their own pending application.
     */
    public function cancel(User $user, Application $application): bool
    {
        return $user->id === $application->tenant_id
            && $application->status === 'pending';
    }
}