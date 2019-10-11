<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use App\Tables\ContactFormTable;
use Laravolt\Suitable\Plugins\Pdf;
use Laravolt\Suitable\Plugins\Spreadsheet;

class ContactFormController extends Controller
{
    public function index()
    {
        $contactForms = ContactForm::autoSort()->autoFilter()->paginate();

        // $table = \Suitable::source($contactForms)
        //     ->title('Contact Form')
        //     // ->search('keyword')
        //     ->columns(
        //         [
        //             ['field' => 'id', 'sortable' => true, 'searchable' => true],
        //             ['field' => 'name', 'sortable' => true, 'searchable' => true],
        //             ['field' => 'email', 'sortable' => true, 'searchable' => true],
        //             ['field' => 'kategori', 'sortable' => true, 'searchable' => true],
        //             ['field' => 'message', 'sortable' => true, 'searchable' => true],
        //         ]
        //     )
        //     ->render();
        //
        // return view('admin.contact-form.index', compact('table'));

        return ContactFormTable::make($contactForms)->plugins([
            new Pdf('contact-form.pdf'),
            new Spreadsheet('contac-form.csv'),
        ])->view('admin.contact-form.index');

    }
}
