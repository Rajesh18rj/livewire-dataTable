<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DataTable extends Component
{
    use WithPagination;

    public $perPage = 7;
    public $search = "";

    public $sortByColumn = 'created_at';
    public $sortDirection = "DESC";

    // Sorting Function
    public function setSortFunctionality($columnName){
        if ($this->sortByColumn === $columnName) {
            $this->sortDirection = ($this->sortDirection == "ASC") ? "DESC" : "ASC";
            return;

        }
            $this->sortByColumn = $columnName;
            $this->sortDirection = 'ASC';
    }

    public $editUserId; // Stores the ID of the user being edited
    public $name; // Stores the name to be updated
    public $email; // Stores the email to be updated

// Load user details for editing
    public function edit($userId)
    {
        $user = User::find($userId); // Fetch user by ID
        $this->editUserId = $user->id; // Set the user ID
        $this->name = $user->name; // Set the name
        $this->email = $user->email; // Set the email
    }

// Update user details
    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->editUserId,
        ]);

        $user = User::find($this->editUserId); // Fetch the user by ID
        $user->update([
            'name' => $this->name, // Update name
            'email' => $this->email, // Update email
        ]);

        // Reset fields after update
        $this->reset(['editUserId', 'name', 'email']);

        // Optional: Emit a message or refresh the list
        session()->flash('success', 'User updated successfully!');
    }


    //Delete
    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
    }

    //render
    public function render()
    {
        return view('livewire.data-table', [
            'users'=> User::search($this->search)
                ->orderBy($this->sortByColumn,$this->sortDirection)
                ->paginate($this->perPage)
        ]);
    }
}
