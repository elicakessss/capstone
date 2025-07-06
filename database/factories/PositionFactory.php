<?php
namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition()
    {
        return [
            'org_id' => 1, // You may want to set this dynamically in tests
            'title' => $this->faker->jobTitle,
        ];
    }
}
