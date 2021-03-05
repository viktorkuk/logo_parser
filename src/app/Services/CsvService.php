<?php


namespace App\Services;

use \Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class CsvService
{

    public function upload()
    {
        /*$path = Storage::putFileAs(
            'avatars', $request->file('avatar'), $request->user()->id
        );*/
    }

    public function getData()
    {
        $path = 'csv/domain.csv';

        if (!Storage::exists($path) ) {
            return [];
        }

        $domains = explode("\n",Storage:: get('csv/domain.csv'));

        foreach ($domains as $key => $domain) {

            //$domain = urldecode($domain);

            if (empty($domain)) {
                unset($domains[$key]);
                continue;
            }

            if (strpos($domain,'http') === 0) {
                $domains[$key] = parse_url( $domain, PHP_URL_HOST);
            } else {
                $domains[$key] = trim($domain);
            }
        }

        //echo '<pre>'; var_dump($domains); echo '</pre>';

        return $domains;
    }

    public function getPaginateData($page = 1, $perPage = 20)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = Collection::make(
            $this->getData()
        );
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, []);
    }

}
