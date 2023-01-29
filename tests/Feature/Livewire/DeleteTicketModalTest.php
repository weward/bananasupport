<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\DeleteTicketModal;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTicketModalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Component is accessible
     *  
     * @test 
     * */
    public function deleteTicketModal_livewire_component_accessible()
    {
        $component = Livewire::test(DeleteTicketModal::class);
        $component->assertStatus(200);
    }

    /** 
     * Renders livewire component
     * 
     * @test 
     * */
    public function tickets_page_render_deleteTicketModal_livewire_component()
    {
        $this->actingAs($user = User::factory()->create());
        Ticket::factory()->ofUser($user->id)->create();

        $this->get(route('livewire.tickets'))->assertSeeLivewire('delete-ticket-modal');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     * */
    function deleteTicketModal_render_right_view_file()
    {
        Livewire::test(DeleteTicketModal::class)
            ->call('render')
            ->assertViewIs('livewire.public.tickets.delete-ticket-modal');
    }

    /** 
     * Load data into view
     * 
     * @test 
     * */
    function load_ticket_data_for_close_ticket_modal()
    {
        $this->actingAs($user = User::factory()->create());
        $ticket = Ticket::factory()->ofUser($user->id)->create();

        Livewire::test(DeleteTicketModal::class)
            ->emit('deleteTicket', $ticket->id)
            ->assertSee($ticket->id)
            ->assertSet('showDeleteModal', 1);
    }

    /** 
     * Update 
     * 
     * @test 
     */
    function close_ticket_modal_update()
    {
        $this->actingAs($user = User::factory()->create());
        $ticket = Ticket::factory()->ofUser($user->id)->create();

        Livewire::test(DeleteTicketModal::class)
            ->set('ticket', $ticket)
            ->emit('destroyTicket', $ticket->id)
            ->assertSet('showDeleteModal', 0)
            ->assertEmittedTo('tickets', 'tableUpdated');
    }

}
