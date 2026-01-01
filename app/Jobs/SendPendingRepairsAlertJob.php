<?php

namespace App\Jobs;

use App\Mail\PendingRepairsAlertMail;
use App\Models\Repair;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPendingRepairsAlertJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {



        $repairs = Repair::where('status', 'pending')
            ->with(['truck', 'user', 'fault'])
            ->orderByRaw("(status = 'pending') DESC")
            ->orderBy('created_at', 'DESC')
            ->get();

        $repairs->transform(function ($repair) {
            $repair->days_without_report = $repair->last_reported_at
                ? Carbon::parse($repair->last_reported_at)
                ->startOfDay()
                ->diffInDays(now()->startOfDay())
                : null;
            return $repair;
        });

        if ($repairs->isEmpty()) {
            return;
        }

        $technicians = ['kudam775@gmail.com','sendem@leozim', 'sendem2@leozim'
    ];


        try {
            Mail::to($technicians)
                ->send(new PendingRepairsAlertMail($repairs));

            Log::info('Pending repairs alert email sent successfully');
        } catch (\Throwable $e) {
            Log::error('Failed to send pending repairs email', [
                'error' => $e->getMessage(),
            ]);


            throw $e;
        }
    }
}
