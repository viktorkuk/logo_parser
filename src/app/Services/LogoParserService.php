<?php


namespace App\Services;

use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Http;
use \Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use simplehtmldom\HtmlDocument;
use Illuminate\Support\Facades\Cache;

class LogoParserService
{
    const SEARCH_NODES = ['a' , 'div', 'aside'];

    /*public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
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

        return Cache::remember($domain.'_img', 3600, function () use ($domain)  {

            $imgSrc = [];
            $isHttps = true;

            $content = $this->getContentByDomain($domain, $isHttps);

            if (!$content) {
                return [];
            }

            $client = new HtmlDocument();

            $htmlDom = $client-> load($this->getContentByDomain($domain));
            $imgSrc = array_merge($imgSrc, $this->findDirectLogoImages($htmlDom));
            foreach (self::SEARCH_NODES as $node) {
                $imgSrc = array_merge($imgSrc, $this->findImagesInChild($htmlDom, $node));
            }
            $imgSrc = array_unique($imgSrc);

            //fix reletive to absolute
            foreach ($imgSrc as $key => $imgUrl) {
                if (substr($imgUrl, 0, 4) != 'http') {
                    $imgSrc[$key] = ($isHttps ? 'https' : 'http') . '://' . $domain . (substr($imgUrl, 0, 1) != '/' ? '/' : '' ) . $imgUrl;
                }
            }

            return $imgSrc;
        });
    }

    private function getContentByDomain($domain, &$isHttps = true): string
    {
        $htmlContent = '';

        try {
            $htmlContent = Http::get('https://' . $domain)->body();
        }
        catch (\Exception $e){}

        if (!$htmlContent) {
            $isHttps = false;
            try {
                $htmlContent = Http::get('http://' . $domain)->body();

            }
            catch (\Exception $e){}
        }

        return $htmlContent;
    }

    private function findImagesInChild(HtmlDocument $htmlDom, string $domSelector): array
    {

        $imgSrc = [];
        $elements = $htmlDom->find($domSelector);

        foreach ($elements as $element) {
            if ((!empty($element->class) && strpos($element->class, 'logo') !== false) || (!empty($element->id) && strpos($element->id, 'logo') !== false)) {
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
            if ((!empty($element->class) && strpos($element->class, 'logo') !== false) || (!empty($element->id) && strpos($element->id, 'logo') !== false)) {
                $imgSrc[] = $element->src;
            }
        }

        return $imgSrc;
    }

}
