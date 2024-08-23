<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index() {
        Return TicketResource::collection(Ticket::all());
    }

    public function open() {
        return TicketResource::collection(Ticket::where('status', false)->paginate());
    }

    public function closed() {
        return TicketResource::collection(Ticket::where('status', true)->paginate());
    }
}
