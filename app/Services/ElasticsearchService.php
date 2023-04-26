<?php

namespace App\Services;

use App\Models\Model;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchService
{
    /**
     * @var \Elastic\Elasticsearch\Client
     */
    protected $client;

    /**
     * ElasticsearchService constructor.
     * @throws \Elastic\Elasticsearch\Exception\AuthenticationException
     *
     */
    public function __construct()
    {

        //I used the elastic cloud using cloudId and apiKey
        $this->client = ClientBuilder::create()
            ->setHosts([env('ELASTICSEARCH_HOST')])
            ->setElasticCloudId(env('ELASTICSEARCH_CLOUD_ID'))
            ->setApiKey(env('ELASTICSEARCH_API_KEY'))
            ->build();
        $this->contentType = 'application/json';

    }

    /**
     * @param array $params
     * @return array
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function store(array $params): array
    {
        $this->client->index($params);

        return $this->getDocument($params);
    }

    /**
     * @param array $params
     * @return array
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function edit(array $params): array
    {
        $this->client->update($params);

        return $this->getDocument($params);
    }

    /**
     * @param array $params
     * @return array
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function getDocument(array $params): array
    {
        $params = [
            'index' => $params['index'],
            'id' => $params['id'],
        ];

        return $this->client->get($params)->asArray();
    }

    /**
     * @param array $params
     * @return array
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function deleteDocument(array $params): array
    {
        $params = [
            'index' => $params['index'],
            'id'    => $params['id']
        ];

        return $this->client->delete($params)->asArray();
    }
}
