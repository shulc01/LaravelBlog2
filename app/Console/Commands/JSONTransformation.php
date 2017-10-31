<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;

class JSONTransformation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transform:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transformation JSON in DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Article::select('id', 'description', 'text', 'content')
            ->get()
            ->each(function ($item) {

                $item->content = ["description" => $item->description,
                                  "body" => $item->text];

                $item->save();
            });
    }
}
