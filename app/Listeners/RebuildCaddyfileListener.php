<?php

namespace App\Listeners;

use App\Application;
use App\Events\RebuildCaddyfileEvent;
use App\Jobs\RestartCaddyService;

class RebuildCaddyfileListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RebuildCaddyfileEvent  $event
     * @return void
     */
    public function handle(RebuildCaddyfileEvent $event)
    {
        $_template = file_get_contents(resource_path('templates/Caddyhost'));
        $_templateNoSSL = file_get_contents(resource_path('templates/CaddyhostNoSSL'));
        $caddyfile = Application::all()->reduce(function ($carry, $application) use ($_template, $_templateNoSSL) {
            $template = $_template;
            if (!$application->enabled_https) {
                $template = $_templateNoSSL;
            }
            foreach ($application->toArray() as $key => $value) {
                $template = str_replace('[[' . $key . ']]', $value, $template);
            }
            return ($carry . "\n" . $template);
        }, file_get_contents(resource_path('templates/Caddyfile')));
        file_put_contents(base_path('share/Caddyfile'), $caddyfile);
        dispatch(new RestartCaddyService());
    }
}
