<?php

namespace App\Http\Livewire;

use App\Models\Gender;
use Livewire\Component;

class EditChildModal extends Component

{
    public $child;
    public $firstname, $middlename, $lastname, $dob, $birth_cert, $gender_id, $registration_number;
    public $genders, $message;
    protected $listeners = ['childUpdated' => 'handleChildUpdated'];

    public function mount($child)
    {
        $this->child = $child;
        $c_fullname = json_decode($child->fullname, true);
        $this->firstname = $c_fullname['firstname'];
        $this->middlename = $c_fullname['middlename'];
        $this->lastname = $c_fullname['lastname'];
        $this->dob = $child->dob;
        $this->birth_cert = $child->birth_cert;
        $this->registration_number = $child->registration_number;
        $this->gender_id = $child->gender_id;
        $this->genders = Gender::all();
    }

    public function update()
    {
        try {
            $this->validate([
                'firstname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'dob' => 'required|date',
                'birth_cert' => 'required|string|max:15',
                'gender_id' => 'required|exists:gender,id',
            ]);

            // Build the fullname JSON
            $fullname = json_encode([
                'firstname' => $this->firstname,
                'middlename' => $this->middlename,
                'lastname' => $this->lastname,
            ]);

            // Only update fields that have changed
            $this->child->update(array_filter([
                'fullname' => $fullname !== $this->child->fullname ? $fullname : null,
                'dob' => $this->dob !== $this->child->dob ? $this->dob : null,
                'birth_cert' => $this->birth_cert !== $this->child->birth_cert ? $this->birth_cert : null,
                'gender_id' => $this->gender_id !== $this->child->gender_id ? $this->gender_id : null,
            ]));

            $this->message = 'Success.';
            $this->emit('childUpdated', $this->message); // Optional: Emit event if needed for child refresh
            $this->emit('closeModal');
        } catch (\Exception $e) {
            $this->message = 'Error:' . $e->getMessage();
        }
    }

    public function handleChildUpdated($message){
        $this->message=session()->flash('message', $message);
        
    }

    public function render()
    {
        return view('livewire.edit-child-modal');
    }
}
