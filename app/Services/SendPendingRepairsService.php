<?php

namespace App\Services;

use App\Mail\PendingRepairsAlertMail;
use App\Models\Repair;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPendingRepairsService
{

    public function send(): void
    {

        $technicians = User::whereNotNull('work_email')
            ->pluck('work_email')
            ->filter()
            ->toArray();
            
        $repairs = Repair::where('status', 'pending')
            ->with(['truck', 'user', 'fault'])
            ->orderByDesc('created_at')
            ->get();

        if ($repairs->isEmpty()) {
            Log::info('No pending repairs found, email not sent');
            return;
        }


        Mail::to($technicians)->send(new PendingRepairsAlertMail($repairs));

        Log::info('Pending repairs alert email sent');
    }
}
