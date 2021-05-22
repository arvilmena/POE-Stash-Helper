<?php


namespace App\Value;


class POEWebsiteSession {

    /**
     * @var string
     */
    private $POESESSID;
    /**
     * @var string
     */
    private $accountName;
    /**
     * @var string
     */
    private $league;
    /**
     * @var string
     */
    private $realm;

    public function __construct(string $POESESSID, string $accountName, string $league, string $realm = 'pc') {

        $this->POESESSID = $POESESSID;
        $this->accountName = $accountName;
        $this->league = $league;
        $this->realm = $realm;
    }

    /**
     * @return string
     */
    public function getPOESESSID(): string
    {
        return $this->POESESSID;
    }

    /**
     * @return string
     */
    public function getAccountName(): string
    {
        return $this->accountName;
    }

    /**
     * @return string
     */
    public function getLeague(): string
    {
        return $this->league;
    }

    /**
     * @return string
     */
    public function getRealm(): string
    {
        return $this->realm;
    }

}