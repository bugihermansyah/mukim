<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfDocumentController extends Controller
{
    public function __invoke(Document $document)
    {
        return Pdf::loadview('document/surat-keterangan', [ 'record' => $document ])
            ->stream($document->warga->full_name.'.pdf');
    }
}
