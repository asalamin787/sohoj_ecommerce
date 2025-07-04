<?php

namespace App\Filament\Vendor\Resources\TicketResource\Pages;

use App\Filament\Vendor\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;
}
