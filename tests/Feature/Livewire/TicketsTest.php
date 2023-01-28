<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Tickets;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TicketsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Component is accessible
     *  
     * @test 
     * */
    public function tickets_livewire_component_accessible()
    {
        $component = Livewire::test(Tickets::class);
        $component->assertStatus(200);
    }
    
    /** 
     * Renders livewire component
     * 
     * @test 
     * */
    public function tickets_page_render_livewire_component()
    {
        $this->actingAs(User::factory()->create());
        $this->get('tickets')->assertSeeLivewire('tickets');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     * */
    function tickets_page_render_right_view_file()
    {
        $this->actingAs(User::factory()->create());
        $ticket = Ticket::factory()->count(4)->create();

        Livewire::test(Tickets::class)
            ->call('render')
            ->assertViewIs('livewire.public.tickets.tickets');
    }

    /** 
     * Filter by ticket number
     * 
     * @test 
     * */
    function can_filter_tickets_by_ticket_number()
    {
        $this->actingAs(User::factory()->create());
        $tickets = Ticket::factory()->count(3)->create();

        Livewire::withQueryParams([
            'page' => 1,
            'search' => $tickets[0]->id_label
        ])
        ->test(Tickets::class)
        ->call('filterTickets')
        ->assertSee($tickets[0]->id_label);
    }

    /** 
     * Filter by status
     * 
     * @test 
     * */
    function can_filter_tickets_by_status()
    {
        $this->actingAs(User::factory()->create());

        $openTickets = Ticket::factory()->open()->count(1)->create();
        $closedTickets = Ticket::factory()->closed()->count(2)->create();

        Livewire::withQueryParams([
            'page' => 1,
            'status' => 'open'
        ])
        ->test(Tickets::class)
        ->call('filterTickets')
        ->assertSee($openTickets[0]->id_label)
        ->assertDontSee($closedTickets[0]->id_label);
    }

    /** 
     * Filter with orderBy
     * 
     * @test 
     * */
    function can_filter_tickets_by_orderBy_parameter()
    {
        $this->actingAs(User::factory()->create());

        $ticket = Ticket::factory()->create();

        Livewire::withQueryParams([
            'page' => 100,
            'orderBy' => 'created_at'
        ])
        ->test(Tickets::class)
        ->call('filterTickets')
        ->assertSee($ticket->id_label);
    }

    /** 
     * Filter with orderBy and sortBy
     * 
     * @test 
     * */
    function can_filter_tickets_by_orderBy_with_sortBy_parameter()
    {
        $this->actingAs(User::factory()->create());

        $tickets = Ticket::factory()->count(5)->create();
        // force adjust updated_at
        $tickets[4]->update([
            'subject' => 'New Subject',
            'updated_at' => $tickets[4]->updated_at->copy()->addSeconds(10),
        ]);

        Livewire::withQueryParams([
            'orderBy' => 'updated_at',
            'sortBy'=> 'DESC',
        ])
        ->test(Tickets::class)
        ->call('filterTickets')
        ->assertSeeInOrder([$tickets[4]->id_label, $tickets[0]->id_label]);
    }

    /** 
     * Filter by search param (ticket ID)
     * 
     * @test 
     * */
    function can_filter_tickets_by_search_parameter()
    {
        $this->actingAs(User::factory()->create());
        $ticket = Ticket::factory()->create();

        Livewire::withQueryParams([
            'page' => 1,
            'search' => $ticket->id_label
        ])
            ->test(Tickets::class)
            ->call('filterTickets')
            ->assertSet('search', $ticket->id_label);
    }

    /** 
     * fetchTckets Method is functioning
     * 
     * @test 
     * */
    function fetchTickets_functioning_properly()
    {
        $this->actingAs(User::factory()->create());
        $tickets = Ticket::factory()->count(3)->create();

        Livewire::test(Tickets::class)
            ->call('fetchTickets')
            ->assertSee($tickets[0]->subject);
    }

    
    /** 
     * Weed-out unneeded params from $formFilters 
     * when filtering (eloquent query)
     * 
     * @test 
     * */
    function set_only_needed_formFilters_value_for_query_filters()
    {
        $this->actingAs(User::factory()->create());
        $ticket = Ticket::factory()->create();

        $a = Livewire::withQueryParams([
            'page' => 1, 
            'search' => $ticket->id_label
        ])
        ->test(Tickets::class)
        ->call('fetchTickets');
        // must not be included in $formFilters when not specified
        $a->assertSet('status', "");
        $a->assertSet('sortBy', "");
        $a->assertSet('orderBy', "");
    }
    
    /** 
     * Pagination is working properly
     * Currently: $perPage = 10
     * 
     * @test */
    function tickets_pagination_working_properly()
    {
        $this->actingAs(User::factory()->create());
        $tickets = Ticket::factory()->count(20)->create();

        Livewire::withQueryParams([
            'page' => 2,
        ])
        ->test(Tickets::class)
        ->call('render')
        ->assertSee($tickets[10]->subject);
    }


}
