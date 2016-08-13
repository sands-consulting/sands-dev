<?php

namespace App\Listeners;

use App\Application;
use App\Events\RebuildCaddyfileEvent;

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
        $caddyfile = Application::all()->reduce(function ($carry, $application) use ($_template) {
            $template = $_template;
            foreach ($application->toArray() as $key => $value) {
                $template = str_replace('[[' . $key . ']]', $value, $template);
            }
            return ($carry . "\n" . $template);
        }, file_get_contents(resource_path('templates/Caddyfile')));
        file_put_contents(base_path('share/Caddyfile'), $caddyfile);
    }
}
