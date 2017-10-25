<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ParseXMLController extends Controller
{
    public function index() {

    	$url = 'http://news.liga.net/sport/rss.xml';
		//$url2 = 'https://www.sport-express.ru/services/materials/news/football/se/';

    	$xml = simplexml_load_file($url);

    	$countArticle = count($xml->channel->item);

    	for ($i = 0; $i < $countArticle; $i++) {

    		$data[$i]['title'] = (string) $xml->channel->item[$i]->title;
    		$data[$i]['description'] = (string) $xml->channel->item[$i]->description;
    		$data[$i]['text'] = (string) $value->item[$i]->link;
    		$data[$i]['image'] = (string) $value->item[$i]->enclosure['url'];
    		$data[$i]['created_at'] = date_format(  date_create((string)$value->item[$i]->pubDate), 'Y-m-d H:i:s');

    	}

    	foreach ($data as $article) {

    		$article['category_id'] = 1;
    		$r = Article::create($article);
    		
    	}

dd($xml);


 
    }
}
