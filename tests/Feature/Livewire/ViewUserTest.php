<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ViewUser;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ViewUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Component is accessible
     *  
     * @test 
     * */
    public function viewUser_livewire_component_accessible()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        $component = Livewire::test(ViewUser::class, ['user' => $user]);
        $component->assertStatus(200);
    }

    /** 
     * Renders livewire component
     * 
     * @test 
     * */
    public function users_page_render_ViewUser_livewire_component()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        $this->get(route('admin.livewire.users.show', ['user' => $user->id]))->assertSeeLivewire('view-user');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     * */
    function ViewUser_render_right_view_file()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        Livewire::test(ViewUser::class, ['user' => $user])
            ->call('render')
            ->assertViewIs('livewire.admin.users.view-user');
    }

    /** 
     * Load data into view
     * 
     * @test 
     * */
    function ViewUser_pass_data_to_view()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        Livewire::test(ViewUser::class, ['user' => $user])
            ->call('render')
            ->assertViewHas('user', $user);
    }

    /** 
     * Load data into view
     * 
     * @test 
     * */
    function ViewUser_pass_data_to_view_with_latest_tickets_displayed()
    {
        $this->actingAs($user = User::factory()->create());
        // Create tickets for lone user
        Ticket::factory()->count(3)->create();

        $user->load(['tickets']);
        
        Livewire::test(ViewUser::class, ['user' => $user])
            ->call('render')
            ->assertViewHas('user', $user)
            ->assertSee($user->tickets?->first()->subject);
    }

}
