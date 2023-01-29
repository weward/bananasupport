<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ViewTicket;
use App\Models\Admin;
use App\Models\Comment;
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
        $this->actingAs($user = User::factory()->create());
        $ticket = Ticket::factory()->ofUser($user->id)->create();

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
        $this->actingAs($user = User::factory()->create());
        $ticket = Ticket::factory()->ofUser($user->id)->create();

        $this->get(route('livewire.tickets.show', ['ticket' => $ticket->id]))->assertSeeLivewire('view-ticket');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     * */
    function ViewTicket_render_right_view_file()
    {
        $this->actingAs($user = User::factory()->create());
        $ticket = Ticket::factory()->ofUser($user->id)->create();

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
        $this->actingAs($user = User::factory()->create());
        $ticket = Ticket::factory()->ofUser($user->id)->create();

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
        $this->actingAs($user = User::factory()->create());
        Admin::factory()->create();
     
        $ticket = Ticket::factory()
            ->has(
                Comment::factory()
                    ->state(function (array $attributes, Ticket $ticket) {
                        $isUser = rand(0, 100);
                        $isUser = ($isUser % 2 == 0); // user = even 
                        if ($isUser) {
                            return [
                                'ticket_id' => $ticket->id,
                                'commentable_id' => $ticket->user_id,
                                'commentable_type' => User::class,
                            ];
                        }
                        $admin = Admin::first();
                        return [
                            'ticket_id' => $ticket->id,
                            'commentable_id' => $admin->id,
                            'commentable_type' => Admin::class,
                        ];
                    })
                    ->count(3) // comment count
            )
            ->ofUser($user->id)
            ->create();

        Livewire::test(ViewTicket::class, ['ticket' => $ticket])
            ->call('render')
            ->assertViewHas('ticket', $ticket)
            ->assertSee($ticket->comments[0]?->content);
    }

}
