<?php 
    namespace App\Services;

use App\Http\Traits\ClientTrait;
use App\Models\Client;

    class ClientService{
        use ClientTrait;

        public function createClient(Array $data): Client{
            $validation =  $this->createClientValidator($data)->validate();
            $client = Client::create($validation);
            return $client;
        }

        public function updateClient($id,Array $data): Client{
            $validation =  $this->UpdateClientValidator($data)->validate();
            $client = Client::findOrFail($id);
            $client->update($validation);
            return $client;
        }

        public function deleteClient($id): Client{
            $client = Client::findOrFail($id);
            $client->delete();
            return $client;
        }
    }
?>