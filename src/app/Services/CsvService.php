<?php


namespace App\Services;

use \Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;


class CsvService
{
    public string $path = 'csv/domain.csv';


    public function upload(): void
    {
        /*$path = Storage::putFileAs(
            'avatars', $request->file('avatar'), $request->user()->id
        );*/
    }

    public function getData(): array
    {
        $path = $this->path;

        return Cache::remember('domain_csv', 86400, function () use ($path) {
            if (!Storage::exists($path)) {
                return [];
            }

            $domains = array_unique(explode("\n", Storage:: get('csv/domain.csv')));

            Cache::add('parse_csv', count($domains));

            foreach ($domains as $key => $domain) {

                //$domain = urldecode($domain);

                if (empty($domain)) {
                    unset($domains[$key]);
                    continue;
                }

                if (strpos($domain, 'http') === 0) {
                    $domains[$key] = parse_url($domain, PHP_URL_HOST);
                } else {
                    $domains[$key] = trim($domain);
                }
            }

            return $domains;
        });
    }

    public function getPaginateData($page = 1, $perPage = 20): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = Collection::make(
            $this->getData()
        );
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, []);
    }

    public function resetData(): void
    {
        Cache::flush();
        Storage::delete($this->path);
    }

}
