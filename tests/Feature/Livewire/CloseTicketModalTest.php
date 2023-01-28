<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\CloseTicketModal;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CloseTicketModalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Component is accessible
     *  
     * @test 
     * */
    public function closeTicketModal_livewire_component_accessible()
    {
        $component = Livewire::test(CloseTicketModal::class);
        $component->assertStatus(200);
    }

    /** 
     * Renders livewire component
     * 
     * @test 
     * */
    public function tickets_page_render_closeTicketModal_livewire_component()
    {
        $this->actingAs(User::factory()->create());
        $ticket = Ticket::factory()->create();

        $this->get(route('livewire.tickets'))->assertSeeLivewire('close-ticket-modal');
        $this->get(route('livewire.tickets.show', ['ticket' => $ticket]))->assertSeeLivewire('close-ticket-modal');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     * */
    function closeTicketModal_render_right_view_file()
    {
        Livewire::test(CloseTicketModal::class)
            ->call('render')
            ->assertViewIs('livewire.public.tickets.close-ticket-modal');
    }

    /** 
     * Load data into view
     * 
     * @test 
     * */
    function load_ticket_data_for_close_ticket_modal()
    {
        $this->actingAs(User::factory()->create());
        $ticket = Ticket::factory()->create();

        Livewire::test(CloseTicketModal::class)
            ->emit('closeTicket', $ticket->id)
            ->assertSee($ticket->id)
            ->assertSet('showCloseModal', 1);
    }

    /** 
     * Update 
     * 
     * @test 
     */
    function close_ticket_modal_update()
    {
        $this->actingAs(User::factory()->create());
        $ticket = Ticket::factory()->create();

        Livewire::test(CloseTicketModal::class)
            ->set('ticket', $ticket)
            ->emit('disableTicket', $ticket->id)
            ->assertSet('showCloseModal', 0)
            ->assertEmittedTo('view-ticket', 'refresh');
    }

}
