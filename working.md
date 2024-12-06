first pagination oru page la 5 datas than venum naa.. 

    public function render()
    {
        return view('livewire.data-table', [
            'users'=> User::paginate(5)
        ]);
    }

intha mari kuduthutu, then itha class kulla kudukanum

use WithPagination;  #after itha import um panniranum..     

than namaku page num pagination la venum nu nenacha .. pagination yentha yedathula show aaganum nu nenaikiramo anga 

{{$users->links()}}       itha kudukanum

then antha per page ah work panna vaikanum.. 

firstuh per page oda container kulla poi .. 

select tag la intha mari wire model kuduthukanum.. <select wire:model.live='perPage'

then class file la ,

public $perPage = 5;   #intha mari define pannitu itha render la pass pannanum.. 

        return view('livewire.data-table', [
            'users'=> User::paginate($this->perPage)

goto browser , try it -> it works.

then search ah work panna vaikurathu epdinu pakalam.. 

first search oda container poitu, athoda input field la 

    <input wire:model.live.debounce.300ms="search"

intha mari kuduthukalam.. now antha search ku function yeluthalam.. 

in model file 

    // For Search
    public function scopeSearch($query, $value){
        $query->where('name', 'LIKE', "%$value%")->orwhere('email', 'LIKE', "%$value%");
    }

in render function

    public function render()
    {
        return view('livewire.data-table', [
            'users'=> User::search($this->search)
            ->paginate($this->perPage)
        ]);
    }

Next Name ah vachu epdi sorting panrathunu paakalam.. 

name oda table header la .. itha add pannitu
    wire:click="setSortFunctionality('name')"

ipo ithuku function yeluthalam.. 

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

then render la sollanum itha 

    public function render()
    {
        return view('livewire.data-table', [
            'users'=> User::search($this->search)
                ->orderBy($this->sortByColumn,$this->sortDirection)
                ->paginate($this->perPage)
        ]);
    }

then antha name ndra column header la oru arrow mark vachu atha click panrathu moolama , asc - desc aagura mari panlam.. 

firstu #Heroicons la icon choose panikalam.. 

                            {{--Name--}}
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500" wire:click="setSortFunctionality('name')">
                                <button class="flex items-center ml-1">
                                    Name
                                    @if($sortByColumn != 'name')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    @elseif($sortDirection == 'ASC')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    @endif
                                </button>
                            </th>

ithey mari namaku email ku sorting venum nalum ithey method la kuduthukalam.. 

then delete button epdi work panna vaikurathunaa... 

delete oda tag la itha kuduthukalam.. wire:click="deleteUser({{$user->id}})"

then ithuku function yeluthalam.. 

        //Delete
    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
    }

that's it .. 

edit update create laaam future la pakalam.. 
