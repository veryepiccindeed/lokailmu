<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\PendaftaranPelatihan;

class PesananPelatihanUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(PendaftaranPelatihan $order)
    {
        $this->order = $order->load(['pelatihan', 'user']);
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('pesanan-pelatihan.' . $this->order->idPelatihan),
            new PrivateChannel('user.' . $this->order->idUser),
            new PrivateChannel('mentor.' . $this->order->pelatihan->idMentor)
        ];
    }

    public function broadcastWith()
    {
        return [
            'order' => $this->order
        ];
    }

    public function broadcastAs()
    {
        return 'PesananPelatihanUpdated';
    }
}