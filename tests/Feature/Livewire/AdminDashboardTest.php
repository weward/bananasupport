<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Admin\Dashboard;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Component is accessible
     *  
     * @test 
     * */
    function adminDashboard_livewire_component_accessible()
    {
        $this->actingAs($user = User::factory()->create());
        Ticket::factory()->ofUser($user->id)->create();

        $component = Livewire::test(Dashboard::class);
        $component->assertStatus(200);
    }

    /** 
     * Renders livewire component
     * 
     * @test 
     */
    function adminDashboard_page_render_livewire_component()
    {
        $this->actingAs($user = User::factory()->create());
        Ticket::factory()->ofUser($user->id)->create();

        $this->get(route('admin.dashboard'))->assertSeeLivewire('admin.dashboard');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     */
    function adminDashboardTest__render_right_view_file()
    {
        $this->actingAs($user = User::factory()->create());
        Ticket::factory()->ofUser($user->id)->create();

        Livewire::test(Dashboard::class)
            ->call('render')
            ->assertViewIs('livewire.admin.dashboard');
    }

    /**
     * Test Values upon render()
     * @test
     */
    function adminDashboardTest_render()
    {
        $this->actingAs($user = User::factory()->create());
        User::factory()->count(9)->create(); 
        Ticket::factory()->ofUser($user->id)->open()->count(3)->create();
        Ticket::factory()->ofUser($user->id)->closed()->count(1)->create();

        Livewire::test(Dashboard::class)
            ->call('render')
            ->assertSet('totalTickets', 4)
            ->assertSet('activeTickets', 3)
            ->assertSet('totalUsers', 10);
    }
}
