<?php

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data['title'] = 'Шарапова стала победительницей турнира WTA в Тяньцзине';
        $data['image'] = 'm_7333951509102196.jpg';
        $data['content'] = [
            "description" => 'Мария Шарапова вышла в финал впервые после турнира в Риме - 2015.',
            "body" => 'Россиянка Мария Шарапова (WC) завоевала первый титул после дисквалификации, одержав непростую победу над белоруской Ариной Соболенко в финале турнира категории WTA International в Тяньцзине (Китай) — 7:5, 7:6 (10:8). 
                     В обоих сетах Шараповой пришлось отыгрываться — с 1:4 в первом и с 1:5 во втором. При этом сетбол у Соболенко был только один — при 5:4 в её пользу во второй партии. Поединок продолжался 2 часа 4 минут. 
                     Шарапова сделала 7 эйсов, допустила 3 двойные ошибки и использовала 6 брейк-пойнтов из 16. На счету Соболенко 1 эйс, 5 двойных и 5 реализованных брейк-пойнта из 10.'
        ];
        $data['category_id'] = '4';

        Article::create($data);

        $data['title']  = str_random(10);
        $data['image'] = 'm_4184081508846936.jpg';
        $data['content'] = [
            "description" => str_random(10),
            "body" => str_random(10)
        ];
        $data['category_id'] = '25';

        Article::create($data);
    }
}
