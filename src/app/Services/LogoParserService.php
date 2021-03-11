<?php


namespace App\Services;

use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Http;
use \Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use simplehtmldom\HtmlDocument;
use Illuminate\Support\Facades\Cache;
use \GuzzleHttp\Client;

class LogoParserService
{
    const SEARCH_NODES = ['a' , 'div', 'aside'];

    /*public function __construct(HttpClientInterface $client)
    {
        $this->client =  Client();
    }*/


    public function findLogos(array $domains): array
    {
        $logos = [];

        foreach ($domains as $domain)
        {
            $logos[$domain] = $this->findLogo($domain);
        }

        return $logos;
    }



    public function findLogo($domain): array
    {
        return Cache::remember($domain.'_img', 86400, function () use ($domain)  {

            Cache::increment('parse_total');

            $imgSrc = [];
            $imgData = [];
            $isHttps = true;

            $content = $this->getContentByDomain($domain, $isHttps);

            if (!$content) {
                Cache::increment('parse_error');
                return [];
            }

            $client = new HtmlDocument();

            $htmlDom = $client-> load($this->getContentByDomain($domain));
            $imgSrc = array_merge($imgSrc, $this->findDirectLogoImages($htmlDom));
            foreach (self::SEARCH_NODES as $node) {
                $imgSrc = array_merge($imgSrc, $this->findImagesInChild($htmlDom, $node));
            }
            $imgSrc = array_values(array_unique($imgSrc));


            foreach ($imgSrc as $key => $imgUrl) {

                //add file type
                $imgData[$key]['type'] = strtolower(substr($imgUrl, strrpos($imgUrl, '.')+1, 3));
                //convert reletive urls to absolute
                if (substr($imgUrl, 0, 4) != 'http') {
                    $imgData[$key]['src'] = ($isHttps ? 'https' : 'http') . '://' . $domain . (substr($imgUrl, 0, 1) != '/' ? '/' : '' ) . $imgUrl;
                } else {
                    $imgData[$key]['src'] = $imgUrl;
                }
            }

            Cache::increment('parse_success');
            return $imgData;
        });
    }

    private function getContentByDomain($domain, &$isHttps = true): string
    {

        $client =  new Client();
        $htmlContent = '';

        try {
            //$htmlContent = Http::get('http://' . $domain)->body();
            $htmlContent = $client->request('GET', 'https://' . $domain)->getBody();
        } catch (\Exception $e){
            Log::debug('Exception: '.$e->getMessage());
        }

        if (!$htmlContent) {
            $isHttps = false;
            try {
                //$htmlContent = Http::get('https://' . $domain)->body();
                $htmlContent = $client->request('GET', 'http://' . $domain)->getBody();
            } catch (\Exception $e){
                Log::debug('Exception: '.$e->getMessage());
            }
        }

        return $htmlContent;
    }

    private function findImagesInChild(HtmlDocument $htmlDom, string $domSelector): array
    {

        $imgSrc = [];
        $elements = $htmlDom->find($domSelector);

        foreach ($elements as $element) {
            if (
                (!empty($element->class) && strpos($element->class, 'logo') !== false) ||
                (!empty($element->id) && strpos(strtolower($element->id, 'logo')) !== false))
            {
                $imgs = $element->find('img');
                foreach ($imgs as $img) {
                    $imgSrc[] = $img->src;
                }
            }
        }

        return $imgSrc;
    }

    private function findDirectLogoImages(HtmlDocument $htmlDom): array
    {
        $imgSrc = [];

        $elements = $htmlDom->find('img');
        foreach ($elements as $element) {
            if (
                (!empty($element->class) && strpos($element->class, 'logo') !== false) ||
                (!empty($element->id) && strpos(strtolower($element->id), 'logo') !== false) ||
                (!empty($element->alt) && strpos(strtolower($element->alt), 'logo') !== false) ||
                (!empty($element->title) && strpos(strtolower($element->title), 'logo') !== false)
            ) {
                $imgSrc[] = $element->src;
            }
        }

        return $imgSrc;
    }

}
