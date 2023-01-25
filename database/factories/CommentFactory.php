<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $userModel = 'App\Models\User';
    protected $adminModel = 'App\Models\Admin';
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $author = $this->assignUserOrAdmin();

        return [
            'content' => fake()->realText(200, 2),
            'ticket_id' => $this->assignTicket(),
            'commentable_id' => $author['id'],
            'commentable_type' => $author['type'],
        ];
    }

    private function assignTicket()
    {
        return Ticket::all()->random()->id;
    }

    public function assignUserOrAdmin()
    {
        $isUser = rand(0, 1);
        
        return ($isUser) 
            ? ['id' => User::all()->random()->id, 'type' => $this->userModel]
            : ['id' => Admin::latest()->first()->id, 'type' => $this->adminModel];
    }

    public function assignAdmin()
    {
        return $this->state(fn(array $attributes) => ['commentable_id' => 1, 'commentable_type' => $this->adminModel]);
    }

    public function assignUser()
    {
        return $this->state(fn (array $attributes) => ['commentable_id' => User::all()->random()->id, 'commentable_type' => $this->userModel]);
    }
}
