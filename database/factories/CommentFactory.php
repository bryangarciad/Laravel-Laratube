<?php

namespace Database\Factories;

use App\Models\Comment;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;


    public function definition()
    {
        return [
            'user_id' => 'b1db4bf0-3ad0-46bc-89a2-02ba57da379b',
            'video_id' => '65741119-d4a8-4c7b-9167-d9f6bd54f317',
            'comment_id' => '699de1dc-660e-48df-b32a-b5536cc00c8d',
            'body' => $this->faker->sentence(10)
        ];
    }
}