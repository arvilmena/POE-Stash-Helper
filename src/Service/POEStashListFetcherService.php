<?php


namespace App\Service;


use App\Value\POEWebsiteSession;

class POEStashListFetcherService {

    public function getAllStash(POEWebsiteBrowserService $browserService) {

        $encoded = http_build_query([
            'accountName' => $browserService->getPOEWebsiteSession()->getAccountName(),
            'realm' => $browserService->getPOEWebsiteSession()->getRealm(),
            'league' => $browserService->getPOEWebsiteSession()->getLeague(),
            'tabs' => 1,
            'tabIndex' => 0,
        ]);

        $response = $browserService->visit('https://www.pathofexile.com/character-window/get-stash-items?' . $encoded);
        $response = json_decode($response->getContent(),true);

        return (!empty($response['tabs'])) ? $response['tabs'] : null;
    }

    public function getStashAtIndex(POEWebsiteBrowserService $browserService, $index) {

        // https://www.pathofexile.com/character-window/get-stash-items?accountName=ZiriusPH&realm=pc&league=SSF+Ultimatum&tabs=0&tabIndex=6
        $encoded = http_build_query([
            'accountName' => $browserService->getPOEWebsiteSession()->getAccountName(),
            'realm' => $browserService->getPOEWebsiteSession()->getRealm(),
            'league' => $browserService->getPOEWebsiteSession()->getLeague(),
            'tabIndex' => $index
        ]);

        $response = $browserService->visit('https://www.pathofexile.com/character-window/get-stash-items?' . $encoded);
        $response = json_decode($response->getContent(), true);

        return (!empty($response['items'])) ? $response['items'] : null;
    }

}