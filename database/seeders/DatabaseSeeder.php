<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $service = app(\App\Services\Content::class);

        \App\Models\User::factory(100)->create();

        \App\Models\User::create([
            'first_name' => 'mahdi',
            'last_name' => 'yousefi',
            'username' => '09366441502',
            'password' => Hash::make("12344321"),
            'role' => 'admin'
        ]);

        $relations = collect([]);

        foreach (types() as $type) {
            for ($i = 0; $i < 10; $i++) {
                $files = [];
                foreach ($type['files'] as $f) {
                    $file = \App\Models\File::create([
                        "type" => $f,
                        "path" => "test.jpg",
                        "format" => "image",
                        "mime" => "image/png",
                        "size" => 10000,
                        'content_type' => \App\Models\Content::class,
                        'content_id' => null
                    ]);
                    $files[] = $file->id;
                }

                $texts = [];
                foreach ($type['label'] as $label => $key) {
                    $texts[] = [
                        "label" => $label,
                        "text" => "$label - $i",
                    ];
                }

                $content = $service->create([
                    "type" => $type['type'],
                    "stock" => rand(0, 10),
                    "status" => "publish",
                    "lang" => "fa",
                    "currency" => "TMN",
                    "files" => $files,
                    "price" => rand(1000, 100000),
                    "discount" => rand(0, 100),
                    "texts" => $texts,
                    //"relations" => $relations->toArray()
                ]);

                if($type['type'] == "category"){
                    $item = [];
                    $item[$type['type']]= $content->getId();
                    $relations->push($item);
                }
            }
        }


    }
}
