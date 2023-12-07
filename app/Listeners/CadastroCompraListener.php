<?php

namespace App\Listeners;

use App\Events\CadastroCompra;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CadastroCompraListener
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
     * @param  \App\Events\CadastroCompra  $event
     * @return void
     */
    public function handle(CadastroCompra $event)
    {
        //
    }
}
