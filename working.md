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
