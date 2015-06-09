<?php namespace Quince\Pelastic\Api\Document;

use Quince\Pelastic\Api\GuzzleRepository;
use Quince\Pelastic\Contracts\Api\Document\Index\IndexRepositoryInterface;
use Quince\Pelastic\Contracts\Api\Document\Index\IndexRequestInterface;

class IndexGuzzleRepository extends GuzzleRepository implements IndexRepositoryInterface {

    /**
     * Execute an index request
     *
     * @param IndexRequestInterface $request
     * @return mixed
     */
    public function executeRequest(IndexRequestInterface $request)
    {
        $client = $this->getGuzzleClient();

        $uri = $request->getIndex();

        if (null !== ($type = $request->getType())) {
            $uri .= '/' . $type;
        }

        if (null !== ($id = $request->getDocumentId())) {
            $uri .= '/' . $id;
        }

        $guzzleReq = $client->createRequest('POST', $uri, [
            'body' => $request->getDocument()->toJson()
        ]);

        $response = $client->send($guzzleReq)->json();

        return $response;
    }
}