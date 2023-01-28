<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\UserStatusModal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UserStatusModalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Component is accessible
     *  
     * @test 
     * */
    public function userStatusModal_livewire_component_accessible()
    {
        $component = Livewire::test(UserStatusModal::class);
        $component->assertStatus(200);
    }

    /** 
     * Renders livewire component
     * 
     * @test 
     * */
    public function users_page_render_userStatusModal_livewire_component()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();
        
        $this->get(route('admin.livewire.users'))->assertSeeLivewire('user-status-modal');
        $this->get(route('admin.livewire.users.show', ['user' => $user]))->assertSeeLivewire('user-status-modal');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     * */
    function userStatusModal_render_right_view_file()
    {
        Livewire::test(UserStatusModal::class)
            ->call('render')
            ->assertViewIs('livewire.admin.users.user-status-modal');
    }

    /** 
     * Load data into view
     * 
     * @test 
     * */
    function userStatusModal_pass_data_to_view()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        Livewire::test(UserStatusModal::class)
            ->emit('loadUserStatus', $user->id)
            ->assertSee('user');
    }

    /** 
     * Update 
     * 
     * @test 
     */
    function userStatusModal_update()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        Livewire::test(UserStatusModal::class)
            ->set('user', $user)
            ->emit('updateStatus', $user->id)
            ->assertSet('toggleUserStatusModal', 0)
            ->assertEmittedTo('view-user', 'refresh')
            ->assertEmittedTo('users', 'tableUpdated');
    }


}
