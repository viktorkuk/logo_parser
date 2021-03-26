<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\LogoParserService;
use App\Services\LogoMakerService;
use App\Services\CsvService;
use \View;
use \Storage;

class LogoController extends Controller
{
    private LogoMakerService $logoMakerService;

    public function __construct(
        LogoMakerService $logoMakerService
    )
    {
        $this->logoMakerService = $logoMakerService;
    }

    public function make(Request $request)
    {
        //header('Content-Type: image/png');
        return $this->logoMakerService->getLogo(
            urldecode($request->get('url')),
            $request->get('color')
        );
    }

    public function download(Request $request)
    {
        $filename = $request->get('name') . '.png';

        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename=' . $filename);
        return $this->logoMakerService->getLogo(
            urldecode($request->get('url')),
            $request->get('color')
        );
    }

    public function downloadOrigin(Request $request)
    {
        $srcUrl = $request->get('src_url');
        $fileContent = file_get_contents($srcUrl);
        $fileType = strtolower(substr($srcUrl, strrpos($srcUrl, '.')+1, 3));
        $fileName = $request->get('name') . '.'.$fileType;

        header('Content-Disposition: attachment; filename=' . $fileName);
        return $fileContent;
    }

}
