<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DataTable extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $search = "";

    public $sortByColumn ="";

    public $sortDirection = "asc";

    public function setSortFunctionality($columnName){

    }
    public function render()
    {
        return view('livewire.data-table', [
            'users'=> User::search($this->search)
            ->paginate($this->perPage)
        ]);
    }
}
