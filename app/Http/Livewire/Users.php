<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Traits\HasNavigation;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    use HasNavigation;

    public $title = "User Management";
    public $description = "";
    public $perPage = 10;
    public $showUsersFilter = false;

    public $search = '';
    public $active = '';
    public $orderBy = '';
    public $sortBy = '';
    private $users;

    protected $listeners = [
        'tableUpdated' => 'render',
    ];

    /** Livewire */
    protected $queryString = [
        'search' => ['except' => ''],
        'active' => ['except' => ''],
        'orderBy' => ['except' => ''],
        'sortBy' => ['except' => ''],
    ];

    public $defaultFilters = [
        'search' => '',
        'active' => '',
        'orderBy' => "",
        'sortBy' => '',
    ];

    /**
     * Filter Tickets from Filter Form
     *
     * @return void
     */
    public function filterUsers()
    {
        // Remove ?page=
        $this->resetPage();
        $this->render();
    }

    /**
     * Fetch All Users
     * according to filters
     *
     * @return void
     */
    public function fetchRecords()
    {
        $filters = $this->formFilters();

        return User::filter($filters)
            ->paginate($this->perPage);
    }

    public function formFilters()
    {
        $filters = [];
        if ($this->search != '') {
            $filters['search'] = $this->search;
        }
        
        if ($this->active != '') {
            $filters['active'] = $this->active;
        }

        $filters['orderBy'] = $this->orderBy != '' ? $this->orderBy : 'created_at';
        
        $filters['sortBy'] = $this->sortBy ?: "DESC";
        
        return $filters;
    }

    public function render()
    {
        $this->users = $this->fetchRecords();

        return view('livewire.admin.users.users', [
            'users' => $this->users,
        ]);
    }

}
