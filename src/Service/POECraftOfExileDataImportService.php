<?php
/**
* POECraftOfExileDataImportService.php file summary.
*
* POECraftOfExileDataImportService.php file description.
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

use App\Entity\POEAffix;
use App\Entity\POEBase;
use App\Entity\POEBaseAffixes;
use App\Entity\POEBaseAffixesTier;
use App\Entity\POEItem;
use App\Repository\POEAffixRepository;
use App\Repository\POEBaseAffixesRepository;
use App\Repository\POEBaseAffixesTierRepository;
use App\Repository\POEBaseRepository;
use App\Repository\POEItemRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class POECraftOfExileDataImportService.
 *
 * Class POECraftOfExileDataImportService description.
 *
 * @since 1.0.0
 */
class POECraftOfExileDataImportService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var POEBaseRepository
     */
    private $baseRepository;
    /**
     * @var POEItemRepository
     */
    private $itemRepository;
    /**
     * @var POEAffixRepository
     */
    private $affixRepository;
    /**
     * @var POEBaseAffixesRepository
     */
    private $baseAffixesRepository;
    /**
     * @var POEBaseAffixesTierRepository
     */
    private $baseAffixesTierRepository;

    public function __construct(EntityManagerInterface $em,
                                POEBaseRepository $baseRepository,
                                POEItemRepository $itemRepository,
                                POEAffixRepository $affixRepository,
                                POEBaseAffixesRepository $baseAffixesRepository,
                                POEBaseAffixesTierRepository $baseAffixesTierRepository)
    {
        $this->em = $em;
        $this->baseRepository = $baseRepository;
        $this->itemRepository = $itemRepository;
        $this->affixRepository = $affixRepository;
        $this->baseAffixesRepository = $baseAffixesRepository;
        $this->baseAffixesTierRepository = $baseAffixesTierRepository;
    }

    public function importData(array $data)
    {
        // @see craftofexile-scrape-example.json
        // for structure of $data

        $base = trim($data['base']);

        $baseEntity = $this->baseRepository->findOneBy(['name' => $base]);
        if(!($baseEntity instanceof POEBase)) {
            $baseEntity = new POEBase();
            $baseEntity->setName($base);
            $this->em->persist($baseEntity);
            $this->em->flush();
        }

        if (!empty($data['items'])) {
            foreach($data['items'] as $item) {
                $item = trim($item);
                echo 'processing ' . $item . PHP_EOL;
                $itemEntity = $this->itemRepository->findOneBy(['name'=>$item]);
                if (!($itemEntity instanceof POEItem)) {
                    echo '> not found, creating ...' . PHP_EOL;
                    $itemEntity = new POEItem();
                    $itemEntity->setName($item);
                    $itemEntity->setBaseGroup($baseEntity);
                    $this->em->persist($itemEntity);
                    $this->em->flush();
                }
            }
        }

        $this->importAffixes($baseEntity, $data['prefixes'], 'prefix');
        $this->importAffixes($baseEntity, $data['suffixes'], 'suffix');

        $this->em->flush();
        $this->em->clear();
    }

    public function importAffixes(POEBase $baseEntity, array $modGroups, $prefixOrSuffix = null)
    {
        foreach($modGroups as $modGroup) {
            foreach ($modGroup['affixes'] as $affix) {
                // affix
                echo 'processing: ' . $affix['name'] . PHP_EOL;
                $affixEntity = $this->affixRepository->findOneBy(['coeAffixID' => (int)$affix['coeAffixID']]);
                if (!($affixEntity instanceof POEAffix)) {
                    echo '> not found, creating ...' . PHP_EOL;
                    $affixEntity = new POEAffix();
                    $affixEntity->setCoeAffixID((int) $affix['coeAffixID']);
                }
                $affixEntity->setAModGrp($affix['aModGrp']);
                $affixEntity->setName($affix['name']);
                $this->em->persist($affixEntity);
                $this->em->flush();

                $baseAffixesEntity = $this->baseAffixesRepository->findOneBy(['base' => $baseEntity, 'poeAffix' => $affixEntity, 'prefixOrSuffix'=>$prefixOrSuffix, 'affixGroupName'=>$modGroup['groupName']]);
                if ( !($baseAffixesEntity instanceof POEBaseAffixes)) {
                    $baseAffixesEntity = new POEBaseAffixes();
                    $baseAffixesEntity->setBaseGroup($baseEntity);
                    $baseAffixesEntity->setPoeAffix($affixEntity);
                    $baseAffixesEntity->setPrefixOrSuffix($prefixOrSuffix);
                    $baseAffixesEntity->setAffixGroupName($modGroup['groupName']);
                    $this->em->persist($baseAffixesEntity);
                    $this->em->flush();
//                            $baseEntity->addPOEBaseAffix($baseAffixesEntity);
//                            $this->em->persist($baseEntity);
                }

                // tiers under this affix
                if (!empty($affix['tiers'])) {
                    foreach ($affix['tiers'] as $tier) {
                        $tierEntity = $this->baseAffixesTierRepository->findOneBy(['baseAffixes' => $baseAffixesEntity, 'tier' => (int) $tier['tier']]);
                        if (!($tierEntity instanceof POEBaseAffixesTier)) {
                            $tierEntity = new POEBaseAffixesTier();
                            $tierEntity->setBaseAffixes($baseAffixesEntity);
                            $tierEntity->setTier((int)$tier['tier']);
                        }
                        $tierEntity->setName($tier['name']);
                        $tierEntity->setIlvl((int)$tier['ilvl']);
                        $this->em->persist($tierEntity);
                        $this->em->flush();
                    }
                    $this->em->clear();
                }
            }
        }
    }
}
