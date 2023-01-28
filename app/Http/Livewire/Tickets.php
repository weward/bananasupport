<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use App\Models\User;
use App\Traits\HasNavigation;
use Livewire\Component;
use Livewire\WithPagination;

class Tickets extends Component
{
    use WithPagination;
    use HasNavigation;
    
    public $title = "Ticket Mangement";
    public $description = "";
    public $perPage = 10;
    public $showTicketsFilter = false;

    public $search = '';
    public $status = '';
    public $sortBy = '';
    public $orderBy = '';
    private $tickets;
    

    protected $listeners = [
        'tableUpdated' => 'render',
    ];

    /** Livewire */
    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortBy' => ['except' => ''],
        'orderBy' => ['except' => ''],
    ];

    public $defaultFilters = [
        'search' => '',
        'status' => '',
        'sortBy' => '',
        'orderBy' => ''
    ];


    /**
     * Filter Tickets from Filter Form
     *
     * @return void
     */
    public function filterTickets()
    {
        // Remove ?page=
        $this->resetPage();
        $this->render();
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
     * Fetch All Tickets 
     * according to filters
     *
     * @return void
     */
    public function fetchTickets()
    {
        $filters = $this->formFilters();

        return Ticket::filter($filters)
            ->paginate($this->perPage);
            
    }

    public function formFilters()
    {
        $filters = [];
        if ($this->search != '') {
            $filters['search'] = $this->search;
        }

        if ($this->status != '') {
            $filters['status'] = $this->status;
        }

        if ($this->sortBy) {
            $filters['sortBy'] = $this->sortBy;
        }

        $filters['orderBy'] = $this->orderBy ?: "DESC";

        return $filters;
    }

    public function render()
    {
        $this->tickets = $this->fetchTickets();

        return view('livewire.public.tickets.tickets', [
            'tickets' => $this->tickets,
        ]);
    }


}
