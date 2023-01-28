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

    /** @test */
    public function tickets_livewire_component_accessible()
    {
        $component = Livewire::test(Tickets::class);
        $component->assertStatus(200);
    }
    
    /** @test */
    public function tickets_page_render_livewire_component()
    {
        $this->actingAs(User::factory()->create());
        $this->get('tickets')->assertSeeLivewire('tickets');
    }


    /** @test */
    function tickets_page_render_right_view_file()
    {
        $this->actingAs(User::factory()->create());
        $ticket = Ticket::factory()->count(4)->create();

        Livewire::test(Tickets::class)
            ->call('render')
            ->assertViewIs('livewire.public.tickets.tickets');
    }

    /** @test */
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

    /** @test */
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

    /** @test */
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

    /** @test */
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

    /** @test */
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

    /** @test */
    function fetchTickets_functioning_properly()
    {
        $this->actingAs(User::factory()->create());
        $tickets = Ticket::factory()->count(3)->create();

        Livewire::test(Tickets::class)
            ->call('fetchTickets')
            ->assertSee($tickets[0]->subject);
    }

    


    /** @test */
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
        // must not be set
        $a->assertSet('status', "");
        $a->assertSet('sortBy', "");
        $a->assertSet('orderBy', "");
    }
    


}
