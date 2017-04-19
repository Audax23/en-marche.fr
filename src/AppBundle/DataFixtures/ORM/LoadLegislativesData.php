<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\LegislativeCandidate;
use AppBundle\Entity\LegislativeDistrictZone;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @see https://fr.wikipedia.org/wiki/Liste_des_circonscriptions_l%C3%A9gislatives_de_la_France
 */
class LoadLegislativesData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($zones = $this->createLegislativeZones() as $zone) {
            $manager->persist($zone);
        }

        $candidate001 = $this->createLegislativeCandidate(
            $zones['0001'],
            "Troisième circonscription de l'Ain",
            '3',
            'Alban',
            'Martin',
            46.2600121,
            5.5815357
        );
        $candidate001->setSlug('alban-martin');
        $candidate001->setFacebookPageUrl('https://www.facebook.com/albanmartin-fake');
        $candidate001->setTwitterPageUrl('https://twitter.com/albanmartin-fake');
        $candidate001->setWebsiteUrl('https://albanmartin.en-marche-dev.fr');

        $manager->persist($candidate001);

        $manager->persist($this->createLegislativeCandidate(
            $zones['0073'],
            'Première circonscription de la Savoie',
            '1',
            'Michelle',
            'Dumoulin',
            45.6942366,
            5.8744525
        ));

        $manager->persist($this->createLegislativeCandidate(
            $zones['0073'],
            'Deuxième circonscription de la Savoie',
            '2',
            'Pierre',
            'Etchebest',
            45.6647635,
            6.3748451
        ));

        $manager->persist($this->createLegislativeCandidate(
            $zones['0074'],
            'Cinquième circonscription de la Haute-Savoie',
            '5',
            'Monique',
            'Albert',
            46.3910742,
            6.5735429
        ));

        $manager->persist($this->createLegislativeCandidate(
            $zones['0075'],
            'Première circonscription de Paris',
            '1',
            'Etienne',
            'de Monté-Cristo',
            48.8620254,
            2.318369
        ));

        $manager->persist($this->createLegislativeCandidate(
            $zones['0075'],
            'Deuxième circonscription de Paris',
            '2',
            'Valérie',
            'Langlade',
            48.8677068,
            2.3323267
        ));

        $manager->persist($this->createLegislativeCandidate(
            $zones['0075'],
            'Troisième circonscription de Paris',
            '3',
            'Isabelle',
            'Piémontaise',
            48.8625838,
            2.3505278
        ));

        $manager->persist($this->createLegislativeCandidate(
            $zones['0974'],
            'Première circonscription de la Réunion',
            '1',
            'Estelle',
            'Antonov',
            -20.9432,
            55.3705662
        ));

        $manager->persist($this->createLegislativeCandidate(
            $zones['0974'],
            'Deuxième circonscription de la Réunion',
            '2',
            'Jacques',
            'Arditi',
            -21.014042,
            55.2673329
        ));

        $manager->persist($this->createLegislativeCandidate(
            $zones['0974'],
            'Troisième circonscription de la Réunion',
            '3',
            'Albert',
            'Bérégovoy',
            -21.2917429,
            55.4074309
        ));

        $manager->persist($this->createLegislativeCandidate(
            $zones['1001'],
            'Première circonscription des Français établis hors de France',
            '1',
            'Franck',
            'de Lavalle',
            36.2305449,
            -113.8245564
        ));

        $manager->persist($this->createLegislativeCandidate(
            $zones['1011'],
            'Onzième circonscription des Français établis hors de France',
            '11',
            'Emmanuelle',
            'Parfait',
            1.3150701,
            103.7065847
        ));

        $manager->flush();
    }

    private function createLegislativeCandidate(
        LegislativeDistrictZone $zone,
        string $districtName,
        string $districtNumber,
        string $firstName,
        string $lastName,
        float $latitude,
        float $longitude,
        string $slug = null
    ): LegislativeCandidate {
        $directory = __DIR__.'/../../DataFixtures/legislatives';
        $description = sprintf('%s/description.txt', $directory);
        if ($slug && file_exists($path = sprintf('%s/%s.txt', $directory, $slug))) {
            $description = $path;
        }

        $candidate = new LegislativeCandidate();
        $candidate->setFirstName($firstName);
        $candidate->setLastName($lastName);
        $candidate->setDistrictZone($zone);
        $candidate->setDistrictName($districtName);
        $candidate->setDistrictNumber($districtNumber);
        $candidate->setLatitude($latitude);
        $candidate->setLongitude($longitude);
        $candidate->setDescription(file_get_contents($description));

        if ($slug) {
            $candidate->setSlug($slug);
        }

        return $candidate;
    }

    /**
     * @return LegislativeDistrictZone[]
     */
    private function createLegislativeZones(): array
    {
        // France Métropolitaine
        $zones['0001'] = LegislativeDistrictZone::createDepartmentZone('Ain', ['01']);
        $zones['0002'] = LegislativeDistrictZone::createDepartmentZone('Aisne', ['02']);
        $zones['0020'] = LegislativeDistrictZone::createDepartmentZone('Corse', ['20', '2A', '2B']);
        $zones['0073'] = LegislativeDistrictZone::createDepartmentZone('Savoie', ['73']);
        $zones['0074'] = LegislativeDistrictZone::createDepartmentZone('Haute-Savoie', ['74', 'Haute Savoie']);
        $zones['0075'] = LegislativeDistrictZone::createDepartmentZone('Paris', ['75']);
        $zones['0092'] = LegislativeDistrictZone::createDepartmentZone('Hauts-de-Seine', ['92', 'Hauts de Seine']);

        // Outre-Mer
        $zones['0971'] = LegislativeDistrictZone::createDepartmentZone('Guadeloupe', ['971']);
        $zones['0972'] = LegislativeDistrictZone::createDepartmentZone('Martinique', ['972']);
        $zones['0973'] = LegislativeDistrictZone::createDepartmentZone('Guyane', ['973']);
        $zones['0974'] = LegislativeDistrictZone::createDepartmentZone('La Réunion', ['974']);
        $zones['0975'] = LegislativeDistrictZone::createDepartmentZone('Saint-Pierre-et-Miquelon', ['975', 'Saint Pierre et Miquelon']);
        $zones['0976'] = LegislativeDistrictZone::createDepartmentZone('Mayotte', ['976']);
        $zones['0977'] = LegislativeDistrictZone::createDepartmentZone('Saint-Barthélemy', ['977', 'Saint Barthelemy']);
        $zones['0978'] = LegislativeDistrictZone::createDepartmentZone('Saint-Martin', ['978', 'Saint Martin']);
        $zones['0986'] = LegislativeDistrictZone::createDepartmentZone('Wallis-et-Futuna', ['986', 'Wallis et Futuna']);
        $zones['0987'] = LegislativeDistrictZone::createDepartmentZone('Polynésie française', ['987']);
        $zones['0988'] = LegislativeDistrictZone::createDepartmentZone('Nouvelle-Calédonie', ['988', 'Nouvelle Calédonie']);
        $zones['0989'] = LegislativeDistrictZone::createDepartmentZone('Clipperton', ['989']);

        // Circonscriptions des français à l'étranger
        $zones['1001'] = LegislativeDistrictZone::createRegionZone('USA et Canada', ['US', 'CA', 'USA', 'CAN', 'États-Unis', 'Etats Unis', 'Canada']);
        $zones['1002'] = LegislativeDistrictZone::createRegionZone('Amériques et Caraïbes', [
            'Antigua-et-Barbuda',
            'Argentine',
            'Bahamas',
            'Barbade',
            'Belize',
            'Bolivie',
            'Brésil',
            'Chili',
            'Colombie',
            'Costa Rica',
            'Cuba',
            'République dominicaine',
            'Dominique',
            'Équateur',
            'Grenade',
            'Guatemala',
            'Guyana',
            'Haïti',
            'Honduras',
            'Jamaïque',
            'Mexique',
            'Nicaragua',
            'Panama',
            'Paraguay',
            'Pérou',
            'Saint-Christophe-et-Niévès',
            'Sainte-Lucie',
            'Saint-Vincent-et-les Grenadines',
            'Salvador',
            'Suriname',
            'Trinité-et-Tobago',
            'Uruguay',
            'Venezuela',
        ]);

        $zones['1003'] = LegislativeDistrictZone::createRegionZone('Europe du Nord et Pays Baltes', [
            'Danemark',
            'Estonie',
            'Finlande',
            'Irlande',
            'Islande',
            'Lettonie',
            'Lituanie',
            'Norvège',
            'Royaume-Uni',
            'Suède',
        ]);

        $zones['1004'] = LegislativeDistrictZone::createRegionZone('Bénélux', [
            'Belgique',
            'Luxembourg',
            'Pays-Bas',
        ]);

        $zones['1005'] = LegislativeDistrictZone::createRegionZone('Péninsule Ibérique et Monaco', [
            'Andorre',
            'Espagne',
            'Monaco',
            'Portugal',
        ]);

        $zones['1006'] = LegislativeDistrictZone::createRegionZone('Suisse et Liechtenstein', [
            'Suisse',
            'Liechtenstein',
        ]);

        $zones['1007'] = LegislativeDistrictZone::createRegionZone('Europe Centrale', [
            'Allemagne',
            'Albanie',
            'Autriche',
            'Bosnie-Herzégovine',
            'Bulgarie',
            'Croatie',
            'Hongrie',
            'Kosovo',
            'Macédoine',
            'Monténégro',
            'Pologne',
            'Roumanie',
            'Serbie',
            'Slovaquie',
            'Slovénie',
            'République tchèque',
        ]);

        $zones['1008'] = LegislativeDistrictZone::createRegionZone('Pourtour méditerranéen', [
            'Chypre',
            'Grèce',
            'Israël',
            'Italie',
            'Malte',
            'Saint-Martin',
            'Saint-Siège',
            'Turquie',
        ]);

        $zones['1009'] = LegislativeDistrictZone::createRegionZone('Afrique du Nord et Centrale', [
            'Algérie',
            'Burkina Faso',
            'Cap-Vert',
            'Côte d\'Ivoire',
            'Gambie',
            'Guinée',
            'Guinée-Bissau',
            'Liberia',
            'Libye',
            'Mali',
            'Maroc',
            'Mauritanie',
            'Niger',
            'Sénégal',
            'Sierra Leone',
            'Tunisie',
        ]);

        $zones['1010'] = LegislativeDistrictZone::createRegionZone('Afrique du Sud et Moyen Orient', [
            'Afrique du Sud',
            'Émirats Arabes Unis',
            'Oman',
            'Qatar',
            // ...
            'Zimbabwe',
        ]);

        $zones['1011'] = LegislativeDistrictZone::createRegionZone('Europe Orientale, Asie et Océanie', [
            // Europe Orientale
            'Arménie',
            'Azerbaïdjan',
            'Biélorussie',
            'Géorgie',
            'Moldavie',
            'Russie',
            'Ukraine',

            // Asie
            'Afghanistan',
            'Bangladesh',
            'Indonésie',
            'Chine',
            'Japon',
            // ...

            // Océanie
            'Australie',
            'Fidji',
            'Nouvelle-Zélande',
            // ...
            'Vanuatu',
        ]);

        return $zones;
    }
}
