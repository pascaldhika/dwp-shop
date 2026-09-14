<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Employee\Entities\Employee;

class SearchEmployee extends Component
{
    public $query;
    public $search_results;
    public $how_many;

    public function mount() {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function render() {
        return view('livewire.search-employee');
    }

    public function updatedQuery() {
        $this->search_results = Employee::where('nama', 'like', '%' . $this->query . '%')
            ->orWhere('nik', 'like', '%' . $this->query . '%')
            ->take($this->how_many)->get();
    }

    public function loadMore() {
        $this->how_many += 5;
        $this->updatedQuery();
    }

    public function resetQuery() {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function selectEmployee($employee) {
        $this->dispatch('employeeSelected', $employee);
    }
}
