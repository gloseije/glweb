<?php

namespace App\Providers;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        /*TextColumn::configureUsing(function (TextColumn $column) {
            $column->formatStateUsing(function ($state) {
                if (strtotime($state)) {
                    Carbon::parse($state)->translatedFormat("'Le' j F y 'à' G\hi");
                } else {
                    $state =$state;
                }
            }            
            );
        });*/
    }
}
