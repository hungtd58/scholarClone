<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\JS;

use App\InfoJS;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Input;

class InfoJSController extends Controller
{
    //
    public function checkinfo($id, $titlecheck, $mla, $apa, $chicago, $harvard, $vancouver){
        if($titlecheck == "0"){
            echo "Không có kết quả";
            return;
        }
        try{
            $js = JS::findOrFail($id);
            similar_text($js->title, $titlecheck, $percent);
            if($percent >= 80){
                $infojs = InfoJS::where('js_article_id', $id)->first();
                if($infojs == null){
                    $infojs = new InfoJS();
                    $infojs->js_article_id = $id;
                    $infojs->titleOnGoogle = $titlecheck;
                    $infojs->cluster_id = "";
                    $infojs->mla = $mla;
                    $infojs->apa = $apa;
                    $infojs->chicago = $chicago;
                    $infojs->harvard = $harvard;
                    $infojs->vancouver = $vancouver;
                    $infojs->save();
                }else{
                    $infojs->js_article_id = $id;
                    $infojs->titleOnGoogle = $titlecheck;
                    $infojs->mla = $mla;
                    $infojs->apa = $apa;
                    $infojs->chicago = $chicago;
                    $infojs->harvard = $harvard;
                    $infojs->vancouver = $vancouver;
                    $infojs->save();
                }
                echo "<p>1</p>";
            }else{
                echo "<p>0</p>";
            }
        }catch(ModelNotFoundException $e){
            echo "<p>-1</p>";
        }
    }

    public function saveciteandclusterid($id){
        $cites = Input::get("cites");
        $versions = Input::get("versions");
        $infojs = InfoJS::where('js_article_id', $id)->first();
        if($cites != "0"){
            $cluster_id = str_replace("https://scholar.google.com.vn/scholar?cites=", "", $cites);
            $cluster_id = str_replace("&as_sdt=2005", "", $cluster_id);
            $cluster_id = str_replace("&as_sdt=0,5", "", $cluster_id);
            $cluster_id = str_replace("&sciodt=0,5", "", $cluster_id);
            $cluster_id = str_replace("&hl=en", "", $cluster_id);
            $cluster_id = str_replace("&num=20", "", $cluster_id);
            $number_cites = Input::get("number_cites");
            $number_cites = str_replace("Cited by ", "", $number_cites);
            $infojs->cites = (int)$number_cites;
            $infojs->cluster_id = $cluster_id;
            $infojs->save();
            echo "Cluster: ".$cluster_id."<br>";
            echo "Cites: ".$number_cites;
        }else if($versions != "0"){
            $cluster_id = str_replace("https://scholar.google.com.vn/scholar?cluster=", "", $versions);
            $cluster_id = str_replace("&as_sdt=2005", "", $cluster_id);
            $cluster_id = str_replace("&as_sdt=0,5", "", $cluster_id);
            $cluster_id = str_replace("&sciodt=0,5", "", $cluster_id);
            $cluster_id = str_replace("&hl=en", "", $cluster_id);
            $cluster_id = str_replace("&num=20", "", $cluster_id);
            $infojs->cluster_id = $cluster_id;
            $infojs->save();
            echo "Cluster: ".$cluster_id."<br>";
            echo "Cites: 0";
        }else{
            echo "Cluster: NULL<br>";
            echo "Cites: 0";
        }
    }

    public function detail($js_id){
        $jsArticle = JS::where('id', $js_id)->first();
        $article = InfoJS::where('js_article_id', $js_id)->first();
        return view('detail')->with(['jsArticle' => $jsArticle, 'article' => $article]);
    }
}
