<?php

namespace Brocorp\Qonto\Console;

use Brocorp\Qonto\Facades\QontoApi;
use Brocorp\Qonto\Models\QontoAccount;
use Brocorp\Qonto\Models\QontoTransaction;
use Brocorp\Qonto\Models\QontoAttachment;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class QontoInit extends Command
{
    protected $signature = 'qonto:init';
    protected $description = 'Perform a first initialization that retrieve all bank accounts and all transactions';

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
        $this->info('Syncing all transactions...');

        foreach(QontoAccount::all() as $account)
        {
            $meta =QontoApi::meta($account->slug, $account->iban);
            $countTransactions = $meta['total_count'];
            $countPages = $meta['total_pages'];

            $this->line(' -> account ' . $account->iban . ' : ' . $countTransactions . ' ' . Str::plural('transaction', $countTransactions) );
            $this->line(' -> updating database');
            $this->line('');

            $progressbarTransactions = $this->output->createProgressBar($countTransactions);
            $progressbarTransactions->start();

            for($page = 1; $page < $countPages + 1; $page++)
            {
                $getTransactions = QontoApi::transactions($account->slug, $account->iban, $page);

                foreach($getTransactions as $data)
                {
                    $transaction = QontoTransaction::sync($account->id, $data);
                    $progressbarTransactions->advance();

                    foreach($data['attachment_ids'] as $attachment)
                    {
                        QontoAttachment::sync($attachment, $transaction->id);
                    }
                }
            }

            $progressbarTransactions->finish();
        } 

        $this->line('');
        $this->line('');
        $this->info('✅ Sync done!');
        $this->line('');
        $this->info('Install performed! Happy coding!');
    }
}