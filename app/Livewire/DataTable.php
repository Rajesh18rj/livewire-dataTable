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

    public $sortByColumn = 'name';
    public $sortDirection = "ASC";

    public function setSortFunctionality($columnName){
            $this->sortByColumn = $columnName;
            $this->sortDirection = 'DESC';
    }
    public function render()
    {
        return view('livewire.data-table', [
            'users'=> User::search($this->search)
                ->orderBy($this->sortByColumn,$this->sortDirection)
                ->paginate($this->perPage)
        ]);
    }
}
