<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class ExpireOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Order::where('status', 'pending_payment')
            ->where('expires_at', '<', now())
            ->update([
            'status' => 'cancelled'
        ]);

        $this->info('Expired unpaid orders cancelled.');
    }
}
