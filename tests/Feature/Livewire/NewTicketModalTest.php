<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\NewTicketModal;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class NewTicketModalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Component is accessible
     *  
     * @test 
     * */
    public function newTicketModal_livewire_component_accessible()
    {
        $component = Livewire::test(NewTicketModal::class);
        $component->assertStatus(200);
    }

    /** 
     * Renders livewire component
     * 
     * @test 
     * */
    public function tickets_page_render_newTicketModal_livewire_component()
    {
        $this->actingAs(User::factory()->create());
        $this->get('tickets')->assertSeeLivewire('new-ticket-modal');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     * */
    function newTicketModal_render_right_view_file()
    {
        $this->actingAs(User::factory()->create());
        Ticket::factory()->create();

        Livewire::test(NewTicketModal::class)
            ->call('render')
            ->assertViewIs('livewire.public.tickets.new-ticket-modal');
    }

    /**
     * toggle Modal
     * 
     * @test
     */
    function newTicketModal_toggle_modal()
    {
        $this->actingAs(User::factory()->create());
        $ticket = Ticket::factory()->create();

        Livewire::test(NewTicketModal::class)
            ->emit('toggleTicketModal', 'New')
            ->assertSet('formData.subject', '')
            ->assertSet('formData.content', '');
    }

    /** 
     * Create New  
     * 
     * @test 
     */
    function newTicketModal_create_new()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(NewTicketModal::class)
            ->set('formData', [
                'subject' => 'New Subject',
                'content' => 'New Content',
            ])
            ->call('createNewTicket')
            ->assertSet('toggleNewModal', 0)
            // ->assertEmittedTo('tickets', 'tableUpdated');
            ->assertRedirect(route('livewire.tickets'));
    }


}
