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

class ApiController extends Controller
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

    public function getMetrics()
    {
        return [
            'error' => Cache::get('parse_error') ?: 0,
            'success' => Cache::get('parse_success') ?: 0,
            'total' => Cache::get('parse_total') ?: 0,
            'csv' => Cache::get('parse_csv') ?: 0,
        ];
    }

    public function getDomains()
    {
        return $this->csvService->getData();
    }

    public function findLogos($domain)
    {
        return $this->logoParserService->findLogo(urldecode($domain));
    }

}
