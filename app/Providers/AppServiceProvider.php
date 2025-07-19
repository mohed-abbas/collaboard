<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\Project;
use App\Policies\ProjectPolicy;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Project::class => ProjectPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        if ($this->app->environment('production')) {
            VerifyEmail::createUrlUsing(function ($notifiable) {
                $expiration = Carbon::now()
                    ->addMinutes(config('auth.verification.expire', 60));

                // 1) Build the normal signed URL (absolute with http:// or https://)
                $signed = URL::temporarySignedRoute(
                    'verification.verify',
                    $expiration,
                    [
                        'id' => $notifiable->getKey(),
                        'hash' => sha1($notifiable->getEmailForVerification()),
                    ]
                );

                // 2) Strip off the protocol, leaving "//domain/path?query"
                return preg_replace('#^https?:#', '', $signed);
            });
        }
    }
}