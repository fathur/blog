<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		Post::truncate();
		
		for ($i = 0; $i < 100; $i++)
		{
			$title = $faker->sentence(5);

			Post::create([
				'title'		=> $title,
				'slug'		=> Str::slug($title),
				'content'	=> $faker->paragraph(100)
			]);
		}
	}

}