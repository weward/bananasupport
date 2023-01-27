<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Tickets extends Component
{
    use WithPagination;
    
    public $title = "Filed Tickets";
    public $description = "";
    public $perPage = 2;
    public $isUser = false;
    public $userId = null;
    public $showTicketsFilter = false;

    public $status = '';
    public $sortBy = '';
    public $orderBy = '';

    /** Livewire */
    protected $queryString = [];

    public $defaultFilters = [
        'status' => '',
        'sortBy' => '',
        'orderBy' => "",
    ];

    public $filterForm;
     
    private $tickets;
    
    /**
     * Filter Tickets from Filter Form
     *
     * @return void
     */
    public function filterTickets()
    {
        $this->fetchTickets(1);

        // Start monitoring Changes in URL query string 
        $this->queryString = array_keys($this->defaultFilters);
    }
    
    /**
     * Listen for sortBy form element update
     * Display orderBy form element as per conditions
     *
     * @return void
     */
    public function selectSortBy()
    {
        if ($this->sortBy == '') {
            $this->orderBy = 'desc';
        }
    }

    /**
     * Fetch request params for filtering
     *
     * @return void
     */
    public function fetchRequestParameters()
    {
        if (count($_GET)) {
            $this->status = request()->get('status') ?: '';
            $this->sortBy = request()->get('sortBy') ?: '';
            $this->orderBy = request()->get('orderBy') ?: '';
        }
    }

    /**
     * Check if Auth is User or Admin
     *
     * @return void
     */
    public function isUser()
    {
        $user = auth()->guard('web')->user();
        $this->isUser = ($user && $user instanceof User);
        $this->userId = $user->id;
    }

        
    /**
     * Fetch All Tickets 
     * according to filters
     *
     * @return void
     */
    public function fetchTickets($fromForm = false)
    {
        $filters = $this->formFilters();
        return Ticket::filter($filters)
            ->when(!$this->sortBy, fn($query) => $query->latest())
            ->paginate($this->perPage)
            ->withQueryString();
            
    }

    public function formFilters()
    {
        $filters = [];
        if ($this->status != '') {
            $filters['status'] = $this->status;
        }

        if ($this->sortBy) {
            $filters['sortBy'] = $this->sortBy;
        }

        if ($this->orderBy) {
            $filters['orderBy'] = $this->orderBy;
        }

        if ($this->isUser) {
            $filters['is_user'] = $this->isUser;
        }

        return $filters;
    }

    public function queryParameters()
    {
        $formFilters = $this->formFilters();
        unset($formFilters['is_user']);

        return $formFilters;
    }

    public function render()
    {
        $this->tickets = $this->fetchTickets();

        return view('livewire.public.tickets.tickets', [
            'tickets' => $this->tickets,
        ]);
    }

    public function mount()
    {
        // Keep In order
        $this->isUser();
        $this->fetchRequestParameters();
    }

}
