<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pythonSnippets = [
            "print('Hello, world!')",
            "for i in range(5):\n    print(i)",
            "def add(a, b):\n    return a + b\n\nresult = add(3, 4)\nprint(result)",
            "import math\nprint(math.sqrt(16))",
            "class MyClass:\n    def __init__(self):\n        self.message = 'Hello'\n\n    def greet(self):\n        print(self.message)\n\nobj = MyClass()\nobj.greet()"
        ];
        return [
            'user_id'=>User::factory(),
            'title'=>fake()->title,
            'content' => $pythonSnippets[array_rand($pythonSnippets)],
            'language'=>fake()->languageCode
        ];
    }
}
