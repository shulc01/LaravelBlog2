<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;

class ParseNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:news{ParseContent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse news from sites';

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

        switch ($this->argument('ParseContent')) {

            case 'liga':
                $url = 'http://news.liga.net/sport/rss.xml';
                break;
            case 'rbc':
                $url = 'https://www.rbc.ua/static/rss/ukrnet.sport.rus.rss.xml';
                break;

        }

        $xml = simplexml_load_file($url);

        $countArticle = count($xml->channel->item);

        $xmlChannelItem = $xml->channel->item;

        for ($i = 0; $i < $countArticle; $i++) {

            $data[$i]['title'] = (string) $xmlChannelItem[$i]->title;
            $data[$i]['description'] = (string) $xmlChannelItem[$i]->description;

            if (!empty ($xml->channel->item[$i]->fulltext)) {

                $data[$i]['text'] = (string) $xmlChannelItem[$i]->fulltext;

            } else {

                $data[$i]['text'] = (string) $xmlChannelItem[$i]->link;
            }

            $data[$i]['image'] = (string) $xmlChannelItem[$i]->enclosure['url'];
            $data[$i]['updated_at'] = date_format(  date_create((string) $xmlChannelItem[$i]->pubDate), 'Y-m-d H:i:s');

        }

        foreach ($data as $article) {

            $article['category_id'] = 1;
            Article::create($article);
        }

        $this->info('Parse news Successfully!');

    }
}
