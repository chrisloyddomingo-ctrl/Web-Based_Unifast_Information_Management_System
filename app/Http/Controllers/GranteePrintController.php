<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GranteePrintController extends Controller
{
    public function printPreview(Request $request)
    {
        $title = $request->input('title', 'Grantees List');
        $subtitle = $request->input('subtitle', 'List of grantees');
        $printedAt = now()->format('F d, Y');
        $headers = $request->input('headers', []);
        $rows = $request->input('rows', []);
        $headerImage = $request->input('header_image', asset('assets/img/print-header.png'));

        return view('granteelist.print_preview', compact(
            'title',
            'subtitle',
            'printedAt',
            'headers',
            'rows',
            'headerImage'
        ));
    }
}