<?php

namespace Herbsl\Asset;

use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->singleton('asset', function()
        {
            return new Asset;
        });
    }

}

?>
