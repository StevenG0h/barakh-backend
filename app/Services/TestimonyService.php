<?php 
    namespace App\Services;

use App\Http\Traits\TestimonyTrait;
use App\Models\Testimony;

    class TestimonyService{
        use TestimonyTrait;

        public function createTestimony(Array $data): Testimony{
            $validation =  $this->createTestimonyValidator($data)->validate();
            $testimony = Testimony::create($validation);
            return $testimony;
        }

        public function updateTestimony($id,Array $data): Testimony{
            $validation =  $this->UpdateTestimonyValidator($data)->validate();
            $testimony = Testimony::findOrFail($id);
            $testimony->update($validation);
            return $testimony;
        }

        public function deleteTestimony($id): Testimony{
            $testimony = Testimony::findOrFail($id);
            $testimony->delete();
            return $testimony;
        }
    }
?>