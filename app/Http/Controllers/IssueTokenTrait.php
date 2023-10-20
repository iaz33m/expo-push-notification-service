<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

trait IssueTokenTrait
{

  public function issueToken(Request $request, $grantType, $scope = "")
  {

    $client = DB::table('oauth_clients')->find(2);

    if (!$client) {
      abort(400, 'Passport client not found');
    }

    $params = [
      'grant_type' => $grantType,
      'client_id' => $client->id,
      'client_secret' => $client->secret,
      'scope' => $scope
    ];

    if ($grantType !== 'social') {
      $params['username'] = $request->username ?: $request->email;
    }

    $request->request->add($params);

    $proxy = Request::create('oauth/token', 'POST');

    return Route::dispatch($proxy);
  }
}
