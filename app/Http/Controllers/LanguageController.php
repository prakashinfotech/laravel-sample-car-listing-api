<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function index(Request $request,$locale) {
        app()->setLocale($locale); //set’s application’s locale
        session()->put('locale', $locale);
        return response()->json(['success' => true, 'message' => trans('message.language')], 200);
     }
}
