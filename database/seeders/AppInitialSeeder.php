<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppInitialSeeder extends Seeder
{
    /**
     * There are 2 options to generate data:
     * 1 - Through factories
     * 2 - Through batch insertion (more optimized = faster!)
     * 
     */
    protected $faker;
    protected $adminId;

    /**
     * The total number of users
     */
    protected $userQty = 2000;

    /**
     * Min / Max range of random Qty of 
     * tickets per user
     */
    protected $minTicketQty = 0;
    protected $maxTicketQty = 10;

    /**
     * Min / Max range of random Qty of 
     * comments per ticket
     */
    protected $minCommentQty = 0;
    protected $maxCommentQty = 10;


    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Artisan::call('cache:clear');

        // Seed Admin table with default admin if not yet
        $isAdminExisting = Admin::first();

        if (! $isAdminExisting) {
            \Artisan::call('db:seed', ['class' => 'AdminTableSeeder']);
        }

        // Get Admin
        $admin = Admin::first();
        $this->adminId = $admin?->id;

        // GEnerate using factories
        // $this->useFactoryMethod();

        // Generate using custom + INSERT BATCH
        $this->useCustomFaker();

    }

    /**
     * 
     */
    public function useCustomFaker()
    {
        $userQty = $this->userQty;
        $users = [];
        for ($i = 0; $i < $userQty; $i++) {
            $users[] = [
                'name' => $this->faker->name(),
                'email' => $this->faker->unique()->safeEmail(),
                'email_verified_at' => now()->format('Y-m-d H:i:s'),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'active' => rand(1, 0),
                'remember_token' => \Str::random(10),
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ];
        }

        try {
            User::insert($users);
        } catch (\Throwable $th) {
            // Regen when there is a conflict (ie, duplicate entry)
            // $this->useCustomFaker();
            echo "Bananas! Faker has encountered duplicate value that is already existing in the database.";
            exit;
        }

        User::select('id')
            ->orderBy('id', 'DESC')
            ->chunk(500, function($users) {
                foreach ($users as $user) {

                    $ticketIds = $this->generateTickets($user->id);

                    $this->generateComments($user->id, $ticketIds);

                }
            });

    }

    public function generateTickets($userId)
    {
        $tickets = [];
        $min = $this->minTicketQty;
        $max = $this->maxTicketQty;

        $qty = rand($min, $max);

        if ($qty) {

            for ($i = 0; $i < $qty; $i++) {
                $tickets[] = [
                    'subject' => $this->faker->realText(50, 1),
                    'content' => $this->faker->realText(200, 2),
                    'status' => rand(1, 0),
                    'user_id' => $userId,
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s'),
                ];
            }
    
            if (count($tickets)) {
                Ticket::insert($tickets);
            }
    
            return Ticket::where('user_id', $userId)->get()->pluck('id')->toArray();
        }

        return [];
    }

    public function generateComments($userId, $ticketIds = [])
    {
        if (count($ticketIds)) {
            $comments = [];

            $min = $this->minCommentQty;
            $max = $this->maxCommentQty;

            $qty = rand($min, $max);
            
            foreach($ticketIds as $ticketId) {
                // Generate Comments 
                for ($i = 0; $i < $qty; $i++) {
                    $fromUser = rand(0, 1);
                    $authorId = ($fromUser) ? $userId : $this->adminId;
                    $authorType = ($fromUser) ? User::class : Admin::class;

                    $comments[] = [
                        'ticket_id' => $ticketId,
                        'content' => $this->faker->realText(200, 2),
                        'commentable_id' => $authorId,
                        'commentable_type' => $authorType,
                        'created_at' => now()->format('Y-m-d H:i:s'),
                        'updated_at' => now()->format('Y-m-d H:i:s'),
                    ];
                }
            }
    
            if (count($comments)) {
                Comment::insert($comments);
            }
        }
    }

    public function useFactoryMethod()
    {
        /**
         * Users - 500
         * Tickets - 500 x 5 (max) -> 2500
         * Comments - 2500 x 5 (max) -> 12500
         */
        User::factory()->count(500)->create();

        User::select('id')
            ->orderBy('id', 'DESC')
            ->chunk(500, function ($users) {
                foreach ($users as $user) {

                    // $ticketQty = rand(0, 2);
                    $ticketQty = rand(0, 5);
                    $commentsPerTicket = rand(0, 10);

                    Ticket::factory()
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
                                ->count($commentsPerTicket) // comment count
                        )
                        ->state(function (array $attributes) use ($user) {
                            return [
                                'user_id' => $user->id,
                            ];
                        })
                        ->count($ticketQty)
                        ->create();
                }
            });
    }
}
