<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Usuario::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_usuario'=>$this->faker->unique()->name,
            'nombres'=>$this->faker->name,
            'apellidos'=>$this->faker->name,
            'direccion'=>$this->faker->text,
            'mail'=>$this->faker->unique()->name,
            'pass'=>$this->faker->name,
            'ult_login'=>now()
        ];
    }
}
