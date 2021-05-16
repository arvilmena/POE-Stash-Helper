<?php


namespace App\Service;


use App\Value\POEWebsiteSession;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class POEWebsiteBrowserService {

    /**
     * @var POEWebsiteSession
     */
    private $POEWebsiteSession;

    public function __construct(POEWebsiteSession $POEWebsiteSession) {

        $this->POEWebsiteSession = $POEWebsiteSession;


        $this->cookie = Cookie::create('POESESSID', $this->POEWebsiteSession->getPOESESSID(), strtotime('30 day'))
            ->withDomain('.pathofexile.com')
            ->withPath('/');
        
        $this->client = HttpClient::createForBaseUri('https://www.pathofexile.com', [
            'headers' => [
                'cookie' => (string) $this->cookie
            ]
        ]);
    }

    /**
     * @return POEWebsiteSession
     */
    public function getPOEWebsiteSession(): POEWebsiteSession
    {
        return $this->POEWebsiteSession;
    }

    public function visit(string $url) {


        try {
            $response = $this->client->request('GET', $url);
        } catch (TransportExceptionInterface $e) {
            return $e;
        }

        // TODO: Update cookies if needed.

        return $response;

    }

}