<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DotenvEditor;

class installController extends Controller
{
    public function __construct()
    {
        
    }


    public function index()
    {

        if (DotenvEditor::keyExists('INSTALL')) {
            $chack_install = DotenvEditor::getValue('INSTALL');
            if ($chack_install == (string)'TRUE') {
                return redirect('/home');
            }
        }

        return view('admin.install');

    }
}
