<?php

namespace App\Providers;

use App\Logging\DefaultLogger;
use DateTime;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class DataBaseQueryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        DB::listen(function ($query) {

            if (preg_match('/^select/', $query->sql)) {
                DefaultLogger::sqlSelectStatement($query);
            } else {
                DefaultLogger::sql($query);
            }
        });

        Event::listen(TransactionBeginning::class, function (TransactionBeginning $event) {
            DefaultLogger::sql('START TRANSACTION');
        });

        Event::listen(TransactionCommitted::class, function (TransactionCommitted $event) {
            DefaultLogger::sql('COMMIT');
        });

        Event::listen(TransactionRolledBack::class, function (TransactionRolledBack $event) {
            DefaultLogger::sql('ROLLBACK');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
