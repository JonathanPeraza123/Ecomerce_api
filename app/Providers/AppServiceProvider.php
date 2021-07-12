<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('applyFilters', function () {
            foreach (request('filter', []) as $filter => $value) {
                if (!$this->hasNamedScope($filter)) {
                    abort(400, "The filter '{$filter}'is not allowed ");
                }
                $this->{$filter}($value);
            }

            return $this;
        });
    }
}
