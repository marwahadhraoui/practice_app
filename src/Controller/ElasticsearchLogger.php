<?php
 
 namespace App\Controller;


// use Elastica\Client;
// use Elastica\Document;
// use Monolog\Handler\AbstractProcessingHandler;
// use Monolog\Handler\HandlerInterface;



 class ElasticsearchLogger 
 //extends AbstractProcessingHandler implements HandlerInterface
{
  /*   
    private $client;

    
    public function __construct(Client $client)
    {
        $this->client = $client;
        parent::__construct();
    }

    protected function write(array $record): void
    {
        $params = [
            'index' => 'app_test_64414a3986c7f5.07480548',
            'body' => [
                'level' => $record['level'],
                'message' => $record['message'],
                'context' => $record['context'],
                '@timestamp' => $record['datetime']->format('Y-m-d\TH:i:s.uP'), 
                'level_name' => strtolower($record['level_name']), 
                'route' => isset($record['context']['route']) ? $record['context']['route'] : null

            ],
        ];
        if (isset($record['context']['route'])) {
            $params['body']['route'] = $record['context']['route'];
        }

       $this->client->getIndex('app_test_64414a3986c7f5.07480548')->addDocument(new Document('', $params['body']));
      
}
*/
 }

