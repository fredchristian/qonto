<?php

namespace Brocorp\Qonto;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class QontoServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        /* Accounts Blade Directives */
        Blade::directive('iban', function($slug) { 
            return "<?php echo \Brocorp\Qonto\Models\QontoAccount::where('slug', $slug)->first()->iban; ?>";
        });

        Blade::directive('bic', function($slug) { 
            return "<?php echo \Brocorp\Qonto\Models\QontoAccount::where('slug', $slug)->first()->bic; ?>";
        });

        Blade::directive('balance', function($slug) { 
            return "<?php echo \Brocorp\Qonto\Models\QontoAccount::where('slug', $slug)->first()->balance; ?>";
        });

        Blade::directive('currency', function($slug) { 
            return "<?php echo \Brocorp\Qonto\Models\QontoAccount::where('slug', $slug)->first()->currency; ?>";
        });
    }
}