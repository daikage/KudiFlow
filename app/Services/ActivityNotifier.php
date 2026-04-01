<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\ActivityNotification;

class ActivityNotifier
{
    public static function notifyTenantAdmins(int $tenantId, string $title, string $message, array $data = []): void
    {
        User::query()
            ->where('tenant_id', $tenantId)
            ->where('super_admin', false)
            ->whereIn('role', ['admin','manager'])
            ->chunk(100, function ($chunk) use ($title, $message, $data) {
                foreach ($chunk as $user) {
                    $user->notify(new ActivityNotification($title, $message, array_merge($data, [
                        'scope' => 'tenant',
                    ])));
                }
            });
    }

    public static function notifySuperAdmins(string $title, string $message, array $data = []): void
    {
        User::query()
            ->where('super_admin', true)
            ->chunk(100, function ($chunk) use ($title, $message, $data) {
                foreach ($chunk as $user) {
                    $user->notify(new ActivityNotification($title, $message, array_merge($data, [
                        'scope' => 'platform',
                    ])));
                }
            });
    }
}
