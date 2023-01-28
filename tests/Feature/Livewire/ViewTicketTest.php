<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ViewTicket;
use App\Models\Admin;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ViewTicketTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Component is accessible
     *  
     * @test 
     * */
    public function viewTicket_livewire_component_accessible()
    {
        $this->actingAs(User::factory()->create());
        $ticket = Ticket::factory()->create();

        $component = Livewire::test(ViewTicket::class, ['ticket' => $ticket]);
        $component->assertStatus(200);
    }

    /** 
     * Renders livewire component
     * 
     * @test 
     * */
    public function tickets_page_render_ViewTicket_livewire_component()
    {
        $this->actingAs(User::factory()->create());
        $ticket = Ticket::factory()->create();

        $this->get(route('livewire.tickets.show', ['ticket' => $ticket->id]))->assertSeeLivewire('view-ticket');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     * */
    function ViewTicket_render_right_view_file()
    {
        $this->actingAs(User::factory()->create());
        $ticket = Ticket::factory()->create();

        Livewire::test(ViewTicket::class, ['ticket' => $ticket])
            ->call('render')
            ->assertViewIs('livewire.public.tickets.view-ticket');
    }

    /** 
     * Load data into view
     * 
     * @test 
     * */
    function ViewTicket_pass_data_to_view()
    {
        $this->actingAs(User::factory()->create());
        $ticket = Ticket::factory()->create();

        Livewire::test(ViewTicket::class, ['ticket' => $ticket])
            ->call('render')
            ->assertViewHas('ticket', $ticket);
    }

    /** 
     * Load data into view
     * 
     * @test 
     * */
    function ViewTicket_pass_data_to_view_with_comments_displayed()
    {
        $this->actingAs(User::factory()->create());
        Admin::factory()->create();
        $ticket = Ticket::factory()->hasComments(3)->create();

        Livewire::test(ViewTicket::class, ['ticket' => $ticket])
            ->call('render')
            ->assertViewHas('ticket', $ticket)
            ->assertSee($ticket->comments[0]?->content);
    }

}
