<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;


class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/api/*',
    ];
}

class APIController extends Controller
{
    //

    public function index() {


        if (Auth::check()) {
            $mySettings = DB::table('users')->where('id','=',Auth::id())->first();
            $favourites = DB::table('translate_history')->where('userId','=',Auth::id())->get();
            return view('welcome',["favourites"=>$favourites,"storeMyData"=>$mySettings->logHistorySettings]);

        }
        else {
            $favourites = array();
            return view('welcome',["favourites"=>$favourites]);

        }

    }
    public function about() {
        return view('about');
    }

    public function translate(Request $req) {

        // get cURL resource
        $ch = curl_init();
        // set url
        curl_setopt($ch, CURLOPT_URL, 'https://lindat.cz/translation/api/v2/languages/?src='.$req->from.'&tgt='.$req->to);
        // set method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

        // return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // set headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Accept: application/json',
          'Content-Type: application/x-www-form-urlencoded',
        ]);

        // form body
        $body = [
          'input_text' => $req->text,
        ];
        $body = http_build_query($body);

        // set body
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        // send the request and save response to $response
        $response = curl_exec($ch);

        // stop if fails
        if (!$response) {
          die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
        }


        curl_close($ch);

        $Json = json_decode($response);
        $translation = "";
        foreach( $Json as $item ){
            $translation.= $item;
        }
        echo $translation;

        $req->translation = $translation;
        $req->userId = Auth::id();

        if ($req->storing=="1") {
            $this->logTranslation($req);
        }

    }

    public function translateSaveFavourite(Request $req) {
        DB::table('translate_history')->insert(
               array(
                   'langFrom' => $req->from,
                   'langTo' => $req->to,
                   'textFrom' => $req->text,
                   'textTo' => $req->translation,
                   'userId' => Auth::id(),
                   'star' => 1,
               )
           );

    }
    public function translateSaveSettings(Request $req) {

        $idoagree = match($req->idoagree) {
            "true" => '1',
            "false" => '0',
        };
        $affected = DB::table('users')
          ->where('id', Auth::id())
          ->update(['logHistorySettings' => $idoagree]);
          return redirect('/invoices');

    }
    public function translateUnSaveFavourite(Request $req) {
        //echo "user: ".Auth::id();
        DB::table('translate_history')->where('textFrom', '=', $req->text)->where('userId', '=', Auth::id())->delete();
    }
    public function logTranslation($req) {
        if (Auth::check()) {
           //echo "prihlasen";
           DB::table('translate_history')->insert(
               array(
                   'langFrom' => $req->from,
                   'langTo' => $req->to,
                   'textFrom' => $req->text,
                   'textTo' => $req->translation,
                   'userId' =>  Auth::id(),
               )
           );
        }
        else {
            //echo "NEprihlasen";

        }
    }
}
