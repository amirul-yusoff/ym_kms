<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Models\notification;

use Illuminate\Support\Facades\Auth;

class notificationHelper
{
	/**
     * Save the user activities.
     *
     * @param string $sender
     * @param string $receiver
     * @param string $content
     * @param string $link
     */
    public function sendNotification($sender, $receiver, $content, $link)
    {
        notification::create([
            'sender_code' => $sender,
            'receiver_code' => $receiver,
            'content' => $content,
            'link' => $link
        ]);
    }
}
