<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait SettingsActions
{
    // Update User's Notification Preference
    public function updateNotificationPreference(Request $request)
    {
        $validated = $request->validate([
            'notification_preference' => 'required',
        ]);

        $user = Auth::user();

        try {
            if ($validated['notification_preference'] === "mail") {
                $user->update(["notification_preference" => 'mail']);
            } elseif ($validated['notification_preference'] === 'database') {
                $user->update(["notification_preference" => 'database']);
            } elseif ($validated['notification_preference'] === 'both') {
                $user->update(["notification_preference" => 'database, mail']);
            }
        } catch (\Throwable $th) {
            Log::error('Error Updating Notification Preference: ' . $th->getMessage());
            return redirect()->back()->with('flash_message_error', 'Notification Preference Failed to Update!');
        }

        return redirect()->back()->with('flash_message', 'Notification Preference Updated Successfully!');
    }
}
