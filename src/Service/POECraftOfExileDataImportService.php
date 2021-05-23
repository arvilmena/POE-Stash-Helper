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
use App\Entity\POEBaseGroup;
use App\Entity\POEBaseGroupAffixes;
use App\Entity\POEBaseGroupAffixesTier;
use App\Entity\POEItem;
use App\Repository\POEAffixRepository;
use App\Repository\POEBaseGroupAffixesRepository;
use App\Repository\POEBaseGroupAffixesTierRepository;
use App\Repository\POEBaseGroupRepository;
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
     * @var POEBaseGroupRepository
     */
    private $baseGroupRepository;
    /**
     * @var POEItemRepository
     */
    private $itemRepository;
    /**
     * @var POEAffixRepository
     */
    private $affixRepository;
    /**
     * @var POEBaseGroupAffixesRepository
     */
    private $baseGroupAffixesRepository;
    /**
     * @var POEBaseGroupAffixesTierRepository
     */
    private $baseGroupAffixesTierRepository;

    public function __construct(EntityManagerInterface $em,
                                POEBaseGroupRepository $baseGroupRepository,
                                POEItemRepository $itemRepository,
                                POEAffixRepository $affixRepository,
                                POEBaseGroupAffixesRepository $baseGroupAffixesRepository,
                                POEBaseGroupAffixesTierRepository $baseGroupAffixesTierRepository)
    {
        $this->em = $em;
        $this->baseGroupRepository = $baseGroupRepository;
        $this->itemRepository = $itemRepository;
        $this->affixRepository = $affixRepository;
        $this->baseGroupAffixesRepository = $baseGroupAffixesRepository;
        $this->baseGroupAffixesTierRepository = $baseGroupAffixesTierRepository;
    }

    public function importData(array $data)
    {
        // @see craftofexile-scrape-example.json
        // for structure of $data

        var_dump($data);

        $baseGroup = trim($data['baseGroup']);

        $baseGroupEntity = $this->baseGroupRepository->findOneBy(['name' => $baseGroup]);
        if(!($baseGroupEntity instanceof POEBaseGroup)) {
            $baseGroupEntity = new POEBaseGroup();
            $baseGroupEntity->setName($baseGroup);
            $this->em->persist($baseGroupEntity);
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
                    $itemEntity->setBaseGroup($baseGroupEntity);
                    $this->em->persist($itemEntity);
                    $this->em->flush();
                }
            }
        }

        $this->importAffixes($baseGroupEntity, $data['prefixes'], 'prefix');
        $this->importAffixes($baseGroupEntity, $data['suffixes'], 'suffix');

        $this->em->flush();
    }

    public function importAffixes(POEBaseGroup $baseGroupEntity,array $modGroups, $prefixOrSuffix = null)
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

                $baseGroupAffixAssocEntity = $this->baseGroupAffixesRepository->findOneBy(['baseGroup' => $baseGroupEntity, 'poeAffix' => $affixEntity, 'prefixOrSuffix'=>$prefixOrSuffix, 'affixGroupName'=>$modGroup['groupName']]);
                if ( !($baseGroupAffixAssocEntity instanceof POEBaseGroupAffixes)) {
                    $baseGroupAffixAssocEntity = new POEBaseGroupAffixes();
                    $baseGroupAffixAssocEntity->setBaseGroup($baseGroupEntity);
                    $baseGroupAffixAssocEntity->setPoeAffix($affixEntity);
                    $baseGroupAffixAssocEntity->setPrefixOrSuffix($prefixOrSuffix);
                    $baseGroupAffixAssocEntity->setAffixGroupName($modGroup['groupName']);
                    $this->em->persist($baseGroupAffixAssocEntity);
                    $this->em->flush();
//                            $baseGroupEntity->addPoeBaseGroupAffix($baseGroupAffixAssocEntity);
//                            $this->em->persist($baseGroupEntity);
                }

                // tiers under this affix
                if (!empty($affix['tiers'])) {
                    foreach ($affix['tiers'] as $tier) {
                        $tierEntity = $this->baseGroupAffixesTierRepository->findOneBy(['baseGroupAffixes' => $baseGroupAffixAssocEntity, 'tier' => (int) $tier['tier']]);
                        if (!($tierEntity instanceof POEBaseGroupAffixesTier)) {
                            $tierEntity = new POEBaseGroupAffixesTier();
                            $tierEntity->setBaseGroupAffixes($baseGroupAffixAssocEntity);
                            $tierEntity->setTier((int)$tier['tier']);
                        }
                        $tierEntity->setName($tier['name']);
                        $tierEntity->setIlvl((int)$tier['ilvl']);
                        $this->em->persist($tierEntity);
                        $this->em->flush();
                    }
                }
            }
        }
    }
}
