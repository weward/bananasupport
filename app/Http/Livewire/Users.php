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
    public $sortBy = '';
    public $orderBy = '';
    private $users;

    protected $listeners = [
        'tableUpdated' => 'render',
    ];

    /** Livewire */
    protected $queryString = [];

    public $defaultFilters = [
        'search' => '',
        'active' => '',
        'sortBy' => '',
        'orderBy' => "",
    ];

    /**
     * Filter Tickets from Filter Form
     *
     * @return void
     */
    public function filterUsers()
    {
        $this->fetchRecords();
        // Start monitoring Changes in URL query string 
        $this->queryString = array_keys($this->defaultFilters);
    }

    /**
     * Fetch request params from the URL for filtering
     * Access / Filter directly
     *
     * @return void
     */
    public function fetchRequestParameters()
    {
        if (count($_GET)) {
            $this->search = request()->get('search') ?: '';
            $this->active = request()->get('active') ?: '';
            $this->sortBy = request()->get('sortBy') ?: '';
            $this->orderBy = request()->get('orderBy') ?: '';
        }
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
            ->paginate($this->perPage)
            ->withQueryString();
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

        $filters['sortBy'] = $this->sortBy != '' ? $this->sortBy : 'created_at';
        
        $filters['orderBy'] = $this->orderBy ?: "DESC";
        
        return $filters;
    }

    public function render()
    {
        $this->users = $this->fetchRecords();

        return view('livewire.admin.users.users', [
            'users' => $this->users,
        ]);
    }

    public function mount()
    {
        $this->fetchRequestParameters();
    }
}
