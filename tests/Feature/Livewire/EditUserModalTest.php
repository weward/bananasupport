<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\EditUserModal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EditUserModalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Component is accessible
     *  
     * @test 
     * */
    public function editUserModal_livewire_component_accessible()
    {
        $component = Livewire::test(EditUserModal::class);
        $component->assertStatus(200);
    }

    /** 
     * Renders livewire component
     * 
     * @test 
     * */
    public function tickets_page_render_editUserModal_livewire_component()
    {
        $this->actingAs(User::factory()->create());
        $this->get(route('admin.livewire.users'))->assertSeeLivewire('edit-user-modal');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     * */
    function editUserModal_render_right_view_file()
    {
        $this->actingAs(User::factory()->create());
        User::factory()->create();

        Livewire::test(EditUserModal::class)
            ->call('render')
            ->assertViewIs('livewire.admin.users.edit-user-modal');
    }

    /**
     * fetch form data
     * 
     * @test
     */
    function editUserModal_fetch_form_data()
    {
        $this->actingAs(User::factory()->create());
        $ticket = User::factory()->create();

        Livewire::test(EditUserModal::class)
            ->emit('editUser', $ticket->id)
            ->assertSet('formData.name', $ticket->name)
            ->assertSet('formData.email', $ticket->email)
            ->assertSet('formData.active', $ticket->active);
    }

    /**
     * Pass data into the form
     * 
     * @test
     */
    function editUserModal_loads_data_to_form()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        Livewire::test(EditUserModal::class)
            ->emit('editUser', $user->id)
            ->assertSee('user')
            ->assertSee('formData')
            ->assertViewHas('formData', [
                'name' => $user->name,
                'email' => $user->email,
                'active' => $user->active,
            ])
            ->assertViewHas('user', $user);
    }

    /** 
     * Update 
     * 
     * @test 
     */
    function editUserModal_update()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        Livewire::test(EditUserModal::class)
            ->set('user', $user)
            ->set('formData', [
                'name' => $user->name,
                'email' => $user->email,
                'active' => $user->active,
            ])
            ->call('updateUser')
            ->assertSet('toggleEditUserModal', 0)
            ->assertEmitted('tableUpdated')
            ->assertEmittedTo('view-user', 'refresh');
    }

}
