<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\EditTicketModal;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EditTicketModalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Component is accessible
     *  
     * @test 
     * */
    public function editTicketModal_livewire_component_accessible()
    {
        $component = Livewire::test(EditTicketModal::class);
        $component->assertStatus(200);
    }

    /** 
     * Renders livewire component
     * 
     * @test 
     * */
    public function tickets_page_render_editTicketModal_livewire_component()
    {
        $this->actingAs(User::factory()->create());
        $this->get('tickets')->assertSeeLivewire('edit-ticket-modal');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     * */
    function editTicketModal_render_right_view_file()
    {
        $this->actingAs($user = User::factory()->create());
        Ticket::factory()->ofUser($user->id)->create();

        Livewire::test(EditTicketModal::class)
            ->call('render')
            ->assertViewIs('livewire.public.tickets.edit-ticket-modal');
    }

    /**
     * fetch form data
     * 
     * @test
     */
    function editTicketModal_fetch_form_data()
    {
        $this->actingAs($user = User::factory()->create());
        $ticket = Ticket::factory()->ofUser($user->id)->create();

        Livewire::test(EditTicketModal::class)
            ->emit('editTicket', $ticket->id)
            ->assertSet('formData.subject', $ticket->subject)
            ->assertSet('formData.content', $ticket->content);
    }

    /**
     * Pass data into the form
     * 
     * @test
     */
    function editTicketModal_loads_data_to_form()
    {
        $this->actingAs($user = User::factory()->create());
        $ticket = Ticket::factory()->ofUser($user->id)->create();

        Livewire::test(EditTicketModal::class)
            ->emit('editTicket', $ticket->id)
            ->assertSee('ticket')
            ->assertSee('formData')
            ->assertViewHas('formData', [
                'subject' => $ticket->subject,
                'content' => $ticket->content,
            ])
            ->assertViewHas('ticket', $ticket);
    }

    /** 
     * Update 
     * 
     * @test 
     */    
    function editTicketModal_update()
    {
        $this->actingAs($user = User::factory()->create());
        $ticket = Ticket::factory()->ofUser($user->id)->create();

        Livewire::test(EditTicketModal::class)
            ->set('ticket', $ticket)
            ->set('formData', [
                'subject' => $ticket->subject,
                'content' => $ticket->content,
            ])
            ->call('updateTicket')
            ->assertSet('toggleEditModal', 0)
            ->assertEmitted('tableUpdated');
    }




}
