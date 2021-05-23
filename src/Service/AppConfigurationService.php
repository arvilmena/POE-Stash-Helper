<?php
/**
* AppConfigurationService.php file summary.
*
* AppConfigurationService.php file description.
*
* @link       https://project.com
*
* @package    Project
*
* @subpackage App\Service
*
* @author     Arvil Meña <arvil@arvilmena.com>
*
* @since      1.0.0
*/

declare(strict_types=1);
namespace App\Service;

/**
 * Class AppConfigurationService.
 *
 * Class AppConfigurationService description.
 *
 * @since 1.0.0
 */
class AppConfigurationService
{
    /**
     * @var string
     */
    private $projectDir;

    public function __construct(string $projectDir) {
        $this->projectDir = $projectDir;
    }

    /**
     * @return string
     */
    public function getProjectDir(): string
    {
        return $this->projectDir;
    }

    public function getCraftOfExileScrapedDataDir() {
        return $this->getProjectDir() . '/craftofexile_scraped_data';
    }
}
