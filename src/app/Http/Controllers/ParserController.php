<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\LogoParserService;
use App\Services\CsvService;
use \View;
use \Storage;
use App\Http\Requests\UploadCsvRequest;
use \Cache;

class ParserController extends Controller
{

    private LogoParserService $logoParserService;
    private CsvService $csvService;

    public function __construct(
        LogoParserService $logoParserService,
        CsvService $csvService

    )
    {
        $this->logoParserService = $logoParserService;
        $this->csvService = $csvService;

    }

    public function index(Request $request)
    {
        /*$domains = $this->csvService->getPaginateData($request->get('page', 1));

        //echo '<pre>'; var_dump($domains->toArray());die();

        if ($domains) {
            $domainLogos = $this->logoParserService->findLogos($domains->toArray()['data']);
        }*/

        return View::make(
            'logos',
            [
                //domains' => $domains,
                //'domainLogos' => $domainLogos,
                'parseError' => Cache::get('parse_error') ?: 0,
                'parseSuccess' => Cache::get('parse_success') ?: 0
            ]
        );
    }

    public function getMetrics()
    {
        return [
            'error' => Cache::get('parse_error') ?: 0,
            'success' => Cache::get('parse_success') ?: 0,
            'total' => Cache::get('parse_total') ?: 0,
        ];
    }


    //API
    public function getDomains()
    {
        return $this->csvService->getData();
    }

    public function findLogos($domain)
    {
        return $this->logoParserService->findLogo(urldecode($domain));
    }


    public function uploadCsv(UploadCsvRequest $request)
    {
        if( !$request->validated() ) {
            return Redirect::home()->withErrors('message', 'Wrong file! :)');
        }

        //$request->session()->getId();

        $path = $request->file('csv_file')->storeAs(
            'csv', 'domain.csv' //$request->user()->id
        );

        Cache::flush();

        return Redirect::home();
    }

}
