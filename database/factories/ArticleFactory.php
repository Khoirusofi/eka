<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraph(5),
            'excerpt' => $this->faker->paragraph(2),
            'status' => $this->faker->randomElement(['published', 'draft']),
            'photo' => $this->faker->image('public/media/articles', 640, 480, null, false),
            'category_id' => Category::inRandomOrder()->first()->id, // Ensure articles have a valid category
        ];
    }
}
