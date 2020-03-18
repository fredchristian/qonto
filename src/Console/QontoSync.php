<?php

namespace Brocorp\Qonto\Console;

use Brocorp\Qonto\Facades\QontoApi;
use Brocorp\Qonto\Models\QontoAccount;
use Brocorp\Qonto\Models\QontoTransaction;
use Brocorp\Qonto\Models\QontoAttachment;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class QontoSync extends Command
{
    protected $signature = 'qonto:sync';
    protected $description = 'Retrieve data from Qonto API and store it into your database';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {   
        $this->info('Connecting to Qonto API...');

        $getAccounts =QontoApi::accounts();
        $countAccounts = count($getAccounts);
        
        $this->line('');
        $this->info('Syncing ' . Str::plural('bank account', $countAccounts));
        $this->line(' -> ' . $countAccounts . ' ' . Str::plural('bank account', $countAccounts) . ' found');
        $this->line(' -> updating database');
        $this->line('');

        $progressbarAccounts = $this->output->createProgressBar($countAccounts);
        $progressbarAccounts->start();

        foreach($getAccounts as $data)
        {
            QontoAccount::sync($data);
            $progressbarAccounts->advance();
        }

        $progressbarAccounts->finish();

        $this->line('');
        $this->line('');
        $this->info('Syncing 100 latest transactions...');

        foreach(QontoAccount::all() as $account)
        {
            $getTransactions = QontoApi::transactions($account->slug, $account->iban);
            $countTransactions = count($getTransactions);

            $this->line(' -> account ' . $account->iban);
            $this->line(' -> updating database');
            $this->line('');

            $progressbarTransactions = $this->output->createProgressBar($countTransactions);
            $progressbarTransactions->start();

            foreach($getTransactions as $data)
            {
                $transaction = QontoTransaction::sync($account->id, $data);
                $progressbarTransactions->advance();

                foreach($data['attachment_ids'] as $attachment)
                {
                    QontoAttachment::sync($attachment, $transaction->id);
                }
            }

            $progressbarTransactions->finish();
        }

        $this->line('');
        $this->info('✅ Sync done!');
    }
}