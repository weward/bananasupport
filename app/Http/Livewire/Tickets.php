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
    public $showTicketsFilter = false;

    public $status = '';
    public $sortBy = '';
    public $orderBy = '';
    private $tickets;
    

    protected $listeners = [
        'tableUpdated' => 'render',
    ];

    /** Livewire */
    protected $queryString = [];

    public $defaultFilters = [
        'status' => '',
        'sortBy' => '',
        'orderBy' => "",
    ];


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
     * Fetch request params from the URL for filtering
     * Access / Filter directly
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
     * Fetch All Tickets 
     * according to filters
     *
     * @return void
     */
    public function fetchTickets()
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

        return $filters;
    }

    public function queryParameters()
    {
        $formFilters = $this->formFilters();

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
        $this->fetchRequestParameters();
    }

}
