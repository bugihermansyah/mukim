<?php

namespace App\Listener;

use App\Event\CreateUserEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CreateUserEvent $event): void
    {
        $n = $event->warga->full_name;
        $tl = $event->warga->dob;

        $nc = explode(' ', $n);
        $n1 = strtolower($nc[0]);

        $t = str_replace('-', '', $tl);

        $formail = $n1.$t;

        User::updateOrCreate([
            'warga_id' => $event->warga->id,
            'building_id' => $event->warga->building_id,
            'name' => $event->warga->full_name,
            'email' => $formail.'@gmail.com',
            'password' => bcrypt($formail)
        ]);

        $data = User::where('email', $formail.'@gmail.com')->first();
        $data->syncRoles('warga');
    }
}
