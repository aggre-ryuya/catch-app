<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    private static $counter = 0; 
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $names = ['はこだ', 'だいち', 'ひかる', 'りゅうや', 'あゆ'];
        $roles = ['1','0'];
        $deleted_ats = ['1','0'];

        $name = $names[self::$counter];
        $role = $roles[rand(0, count($roles) - 1)];
        $deleted_at = $deleted_ats[rand(0, count($deleted_ats) - 1)];

        self::$counter++;

        if (self::$counter >= count($names)) {
            self::$counter = 0;
        }
        return [
            //
            'name' => $name,
            'email' => "test". self::$counter. "@gamil.com",
            'password' => "password". self::$counter,
            'role' => $role,
            'deleted_at' => $deleted_at,
        ];
    }
}
