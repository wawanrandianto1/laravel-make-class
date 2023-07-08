<?php

namespace Wawan\MakeClass;

use Illuminate\Support\ServiceProvider;
use Wawan\MakeClass\Console\MakeClassCommand;
use Wawan\MakeClass\Console\MakeInterfaceCommand;

class MakeClassServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([MakeClassCommand::class]);
            $this->commands([MakeInterfaceCommand::class]);
        }
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
