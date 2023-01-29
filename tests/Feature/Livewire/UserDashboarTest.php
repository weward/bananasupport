<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\User\Dashboard;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UserDashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Component is accessible
     *  
     * @test 
     * */
    function userDashboard_livewire_component_accessible()
    {
        $this->actingAs($user = User::factory()->create());
        $ticket = Ticket::factory()->ofUser($user->id)->create();

        $component = Livewire::test(Dashboard::class);
        $component->assertStatus(200);
    }

    /** 
     * Renders livewire component
     * 
     * @test 
     */
    function userDashboard_page_render_livewire_component()
    {
        $this->actingAs($user = User::factory()->create());
        Ticket::factory()->ofUser($user->id)->create();

        $this->get('/dashboard')->assertSeeLivewire('user.dashboard');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     */
    function userDashboardTest__render_right_view_file()
    {
        $this->actingAs($user = User::factory()->create());
        Ticket::factory()->ofUser($user->id)->create();

        Livewire::test(Dashboard::class)
            ->call('render')
            ->assertViewIs('livewire.user.dashboard');
    }

    /**
     * Test Values upon render()
     * @test
     */
    function userDashboardTest_render()
    {
        $this->actingAs($user = User::factory()->create());
        Ticket::factory()->ofUser($user->id)->create();

        Livewire::test(Dashboard::class)
            ->call('render')
            ->assertSet('totalTickets', 1)
            ->assertSet('activeTickets', 1)
            ->assertSee('1');
    }


}
