<?php

namespace Brocorp\Qonto;

use Illuminate\Support\Facades\Http;
use Illuminate\Config\Repository;

class QontoApi
{
    private $client;

    public function __construct()
    {
        $this->client = Http::withHeaders([ 'Authorization' => config('qonto.api.login') . ':' . config('qonto.api.secret') ]);
    }

    public function accounts()
    {
        $url = config('qonto.api.url') . '/organizations/' . config('qonto.api.login');

        return data_get($this->client->get($url), 'organization.bank_accounts');
    }

    public function transactions($slug, $iban, $current_page = null)
    {
        $url = config('qonto.api.url') . '/transactions?slug=' . $slug . '&iban=' . $iban;
        
        if(isset($current_page)) 
        {
            $url .= '&per_page=100&current_page=' . $current_page; 
        }

        return data_get($this->client->get($url), 'transactions');
    }

    public function attachment($id)
    {
        $url = config('qonto.api.url') . '/attachments/' . $id;

        return data_get($this->client->get($url), 'attachment');
    }

    public function meta($slug, $iban)
    {
        $url = config('qonto.api.url') . '/transactions?slug=' . $slug . '&iban=' . $iban;
        
        return data_get($this->client->get($url), 'meta');
    }
}