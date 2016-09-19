<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\JS;

use App\InfoJS;

use App\CiteToJS;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Input;

class CiteToJSController extends Controller
{
    //
    public function savecitetojs($id,$titlecheck,$mla,$apa,$chicago,$harvard,$vancouver){
        $cites = Input::get("cites");
        $versions = Input::get("versions");
        $cite_to_js = InfoJS::where('js_article_id', $id)->where('titleOnGoogle', $titlecheck)->first();
        if($cite_to_js == null){
            $cite_to_js = new CiteToJS();
        }
        if($cites != "0"){
            $cluster_id = str_replace("https://scholar.google.com.vn/scholar?cites=", "", $cites);
            $cluster_id = str_replace("&as_sdt=2005", "", $cluster_id);
            $cluster_id = str_replace("&as_sdt=0,5", "", $cluster_id);
            $cluster_id = str_replace("&sciodt=0,5", "", $cluster_id);
            $cluster_id = str_replace("&hl=en", "", $cluster_id);
            $cluster_id = str_replace("&num=20", "", $cluster_id);
            $number_cites = Input::get("number_cites");
            $number_cites = str_replace("Cited by ", "", $number_cites);
            $cite_to_js->cites = (int)$number_cites;
            $cite_to_js->cluster_id = $cluster_id;
            echo "Cluster: ".$cluster_id."<br>";
            echo "Cites: ".$number_cites;
        }else if($versions != "0"){
            $cluster_id = str_replace("https://scholar.google.com.vn/scholar?cluster=", "", $versions);
            $cluster_id = str_replace("&as_sdt=2005", "", $cluster_id);
            $cluster_id = str_replace("&as_sdt=0,5", "", $cluster_id);
            $cluster_id = str_replace("&sciodt=0,5", "", $cluster_id);
            $cluster_id = str_replace("&hl=en", "", $cluster_id);
            $cluster_id = str_replace("&num=20", "", $cluster_id);
            $cite_to_js->cluster_id = $cluster_id;
            echo "Cluster: ".$cluster_id."<br>";
            echo "Cites: 0";
        }else{
            echo "Cluster: NULL<br>";
            echo "Cites: 0";
        }

        $cite_to_js->js_article_id = $id;
        $cite_to_js->titleOnGoogle = $titlecheck;
        $cite_to_js->mla = $mla;
        $cite_to_js->apa = $apa;
        $cite_to_js->chicago = $chicago;
        $cite_to_js->harvard = $harvard;
        $cite_to_js->vancouver = $vancouver;
        $cite_to_js->save();
    }

    public function citetojs($js_id){
        $js = JS::where("id", $js_id)->first();
        $citetojs = CiteToJS::where("js_article_id", $js_id)->paginate(10);
        return view('citationjs')->with(['js' => $js, 'citetojs' => $citetojs, 'q' => ""]);
    }
}
