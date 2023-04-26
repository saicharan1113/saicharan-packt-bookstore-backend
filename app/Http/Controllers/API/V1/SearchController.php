<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public $c;
    public $client;
    public function __construct()
    {
//        ini_set('max_execution_time', 300);
//        $c = ClientBuilder::create()
//            ->setElasticCloudId(env('ELASTICSEARCH_CLOUD_ID'))
//            ->setApiKey(env('ELASTICSEARCH_API_KEY'))
//            ->build();

//        $c->setAsync(true);
        $this->client = ClientBuilder::create()
            ->setHosts(['http://localhost:9200'])
            ->setElasticCloudId(env('ELASTICSEARCH_CLOUD_ID'))
            ->setApiKey(env('ELASTICSEARCH_API_KEY'))
//            ->setBasicAuthentication('elastic', 'UrODxEENuJsvGGzCLkA6GD2J')

//            ->setSSLVerification(true)
//            ->setCABundle('/http_ca.crt')
            ->build();

        $promise = [];
//        for ($i = 0; $i < 10; $i++) {
//            $promise[] = $c->index([
//                'index' => 'my-index',
//                'body' => [
//                    'foo' => base64_encode(random_bytes(24))
//                ]
//            ]);
//        }
    }

    public function search()
    {

        $response = $this->client->info()->version;
        return $response;
    }
}
