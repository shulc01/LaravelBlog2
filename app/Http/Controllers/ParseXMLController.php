<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ParseXMLController extends Controller
{
    public static function index($idParseContent = false) {


    	switch ($idParseContent) {

    		case 1:
    			$url = 'http://news.liga.net/sport/rss.xml';
    			break;
    		case 2:
    			$url = 'https://www.rbc.ua/static/rss/ukrnet.sport.rus.rss.xml';
    			break;

    	}
        $url = 'http://news.liga.net/sport/rss.xml';

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
    		$r = Article::create($article);
    		
    	}

    	return redirect('admin');
    }
}
