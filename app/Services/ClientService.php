<?php 
    namespace App\Services;

use App\Http\Traits\ClientTrait;
use App\Models\Client;

    class ClientService{
        use ClientTrait;

        public function createClient(Array $data): Client{
            $validation =  $this->createClientValidator($data)->validate();
            $isCreated = Client::where('clientNum',$validation['clientNum'])->first();
            if($isCreated){
                return $this->updateClient($isCreated, $data);
            }
            $client = Client::create($validation);
            return $client;
        }

        public function updateClient(Client $client,Array $data): Client{
            $validation =  $this->UpdateClientValidator($data)->validate();
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