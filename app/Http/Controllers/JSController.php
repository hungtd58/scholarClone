<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\JS;

use Illuminate\Support\Facades\Input;

class JSController extends Controller
{
    //
    public function showalljs(){
        $alljs = JS::all();

        return view('alljs')->with('alljs', $alljs);
    }

    public function alljs(){
        $articles = JS::paginate(10);

        return view('show')->with(['articles' => $articles, 'q' => ""]);
    }

    public function search(){
        $q = Input::get('q');
        $articles = JS::where('title', 'LIKE', '%'.$q.'%')
                        ->paginate(10);
        if($q != ""){
            return view('show')->with(['articles' => $articles, 'q' => $q]);
        }
    }
}
