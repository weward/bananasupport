<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subject' => fake()->realText(50, 1),
            'content' => fake()->realText(200, 2),
            'user_id' => User::factory(),
            // 'user_id' => $this->assignUser(),
        ];
    }

    public function randomState()
    {
        $likeliness = rand(0, 100);

        if ($likeliness > 65) {
            return $this->open();
        }

        return $this->closed();
    }

    public function closed()
    {
        return $this->state(fn(array $attributes) => ['status' => 0]);
    }

    public function open()
    {
        return $this->state(fn (array $attributes) => ['status' => 1]);
    }

    public function assignUser()
    {
        return User::all()->random()->id;
    }

}
