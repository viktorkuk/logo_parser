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
        return explode("\n",Storage::get('csv/domain.csv'));
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
