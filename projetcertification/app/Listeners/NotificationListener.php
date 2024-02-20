<?php

namespace App\Listeners;

use App\Events\NotificationEvents;
use App\Notifications\NotifProduit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationEvents $notificationEvents)
    {

        $produit=$notificationEvents->produit;

        if($produit->quantite < 10 ){
            $produit->notify(new NotifProduit($produit));
        }

    }
}
