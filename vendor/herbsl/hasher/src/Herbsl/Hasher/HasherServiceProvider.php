<?php

namespace Herbsl\Hasher;

use Illuminate\Support\ServiceProvider;

class HasherServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->singleton('hasher', function()
        {
            return new Hasher;
        });
    }

}

?>
