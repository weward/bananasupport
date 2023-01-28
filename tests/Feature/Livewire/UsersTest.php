<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Users;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Component is accessible
     *  
     * @test 
     * */
    public function users_livewire_component_accessible()
    {
        $component = Livewire::test(Users::class);
        $component->assertStatus(200);
    }

    /** 
     * Renders livewire component
     * 
     * @test 
     * */
    public function users_page_render_livewire_component()
    {
        $this->actingAs(User::factory()->create());
        $this->get(route('admin.livewire.users'))->assertSeeLivewire('users');
    }


    /** 
     * Rendering uses right view file
     * 
     * @test 
     * */
    function users_page_render_right_view_file()
    {
        $this->actingAs(User::factory()->create());
        User::factory()->count(4)->create();

        Livewire::test(Users::class)
            ->call('render')
            ->assertViewIs('livewire.admin.users.users');
    }


    /** 
     * Filter by Search field
     * 
     * @test 
     * */
    function can_filter_users_by_search_param()
    {
        $this->actingAs(User::factory()->create());
        $users = User::factory()->count(3)->create();

        Livewire::withQueryParams([
            'page' => 1,
            'search' => $users[0]->email
        ])
        ->test(users::class)
        ->call('filterUsers')
        ->assertSee($users[0]->email);
    }

    /** 
     * Filter by status
     * 
     * @test 
     * */
    function can_filter_users_by_status()
    {
        $this->actingAs(User::factory()->create());

        $activeUsers = User::factory()->count(1)->create();
        $inactiveUsers = User::factory()->inactive()->count(2)->create();

        Livewire::withQueryParams([
            'page' => 1,
            'active' => 'inactive'
        ])
        ->test(Users::class)
        ->call('filterUsers')
        ->assertDontSee($activeUsers[0]->email)
        ->assertSee($inactiveUsers[0]->email)
        ->assertSee($inactiveUsers[1]->email);
    }

    /** 
     * Filter with orderBy
     * with sortBy as DESC by default
     * 
     * @test 
     * */
    function can_filter_users_by_orderBy_parameter()
    {
        $this->actingAs(User::factory()->create());
        
        $users = User::factory()->count(2)->create();
        $users[1]->update([
            'updated_at' => $users[1]->updated_at->copy()->addSeconds(10),
        ]);
        
        Livewire::withQueryParams([
            'orderBy' => 'updated_at'
            // sortBy is DESC by default (order by updated_at sort by DESC)
        ])
        ->test(Users::class)
        ->call('filterUsers')
        ->assertSeeInOrder([$users[1]->email, $users[0]->email]);
    }

    /** 
     * Filter by orderBy
     * with sortBy
     * 
     * @test 
     * */
    function can_filter_users_by_orderBy_with_sortBy_parameter()
    {
        $this->actingAs(User::factory()->create());

        $users = User::factory()->count(2)->create();
        $users[1]->update([
            'updated_at' => $users[1]->updated_at->copy()->addSeconds(10),
        ]);

        Livewire::withQueryParams([
            'orderBy' => 'updated_at',
            'sortBy' => 'ASC',
        ])
        ->test(Users::class)
        ->call('filterUsers')
        ->assertSeeInOrder([$users[0]->email, $users[1]->email]);
    }

    /** 
     * fetchRecords Method is functioning
     * 
     * @test 
     * */
    function fetchRecords_method_functioning_properly()
    {
        $this->actingAs(User::factory()->create());
        $users = User::factory()->count(3)->create();

        Livewire::test(Users::class)
            ->call('fetchRecords')
            ->assertSee($users[0]->email);
    }

    /** 
     * Weed-out unneeded params from $formFilters 
     * when filtering (eloquent query)
     * 
     * @test 
     * */
    function users_component_set_only_needed_formFilters_value_for_query_filters()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        $a = Livewire::withQueryParams([
            'page' => 1,
            'search' => $user->email,
        ])
        ->test(Users::class)
        ->call('fetchRecords');
        // must not be included in $formFilters when not specified
        $a->assertSet('active', "");
        $a->assertSet('orderBy', "");
        $a->assertSet('sortBy', "");
    }

    /** 
     * Pagination is working properly
     * Currently, $perPage = 10
     * 
     * @test 
     * */
    function tickets_pagination_working_properly()
    {
        $this->actingAs(User::factory()->create());
        $users = User::factory()->count(20)->create();

        Livewire::withQueryParams([
            'page' => 2,
        ])
        ->test(Users::class)
        ->call('render')
        ->assertSee($users[10]->email);
    }


}
