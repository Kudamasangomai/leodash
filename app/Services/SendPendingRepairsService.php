<?php

namespace App\Services;

use App\Mail\PendingRepairsAlertMail;
use App\Models\Repair;
use Illuminate\Support\Facades\Http;
use App\Models\Truck;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPendingRepairsService
{

    public function send(): void
    {

        $repairs = Repair::where('status', 'pending')
            ->with(['truck', 'user', 'fault'])
            ->orderByDesc('created_at')
            ->get();

        if ($repairs->isEmpty()) {
            Log::info('No pending repairs found, email not sent');
            return;
        }

        $today = now()->startOfDay();

        $repairs->transform(function ($repair) use ($today) {
            $repair->days_without_report = $repair->last_reported_at
                ? Carbon::parse($repair->last_reported_at)
                ->startOfDay()
                ->diffInDays($today)
                : null;

            return $repair;
        });

        $technicians = [
            'kudam775@gmail.com',
            'sendem@leozim.com',
            'sendem2@leozim.com'
        ];

        Mail::to($technicians)
            ->send(new PendingRepairsAlertMail($repairs));

        Log::info('Pending repairs alert email sent');
    }
}
