<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Job\Payment as PaymentController;

class payment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:comission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executa o módulo de pagamento de comissões';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jobExec = new PaymentController;
        $jobExec->paymentJob();
        return 0;
    }
}
