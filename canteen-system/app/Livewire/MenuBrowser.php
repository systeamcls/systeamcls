<?php

namespace App\Livewire;

use App\Models\MenuItem;
use Livewire\Component;
use Livewire\WithPagination;

class MenuBrowser extends Component
{
    use WithPagination;

    public $selectedCategory = 'all';
    public $searchTerm = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    public function mount()
    {
        // Initialize component
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function addToCart($menuItemId)
    {
        $this->dispatch('add-to-cart', menuItemId: $menuItemId);
    }

    public function render()
    {
        $query = MenuItem::query()
            ->with('user')
            ->available();

        if ($this->selectedCategory !== 'all') {
            $query->where('category', $this->selectedCategory);
        }

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            });
        }

        $menuItems = $query->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(12);

        $categories = MenuItem::select('category')
            ->distinct()
            ->pluck('category')
            ->toArray();

        return view('livewire.menu-browser', [
            'menuItems' => $menuItems,
            'categories' => $categories,
        ]);
    }
}