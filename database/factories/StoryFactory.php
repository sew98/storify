<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = $this->faker->randomElement(['long', 'short']);
        if( $type == 'long') {
            $body = $this->faker->paragraph();
        } else {
            $body = $this->faker->text(200);
        }
        return [
            //
            'user_id' => $this->faker->numberBetween(1, 2),
            'title' => $this->faker->unique()->lexify('??????????'),
            'body' => $body,
            'type' => $type,
            'status' => $this->faker->boolean()
        ];
    }
}
