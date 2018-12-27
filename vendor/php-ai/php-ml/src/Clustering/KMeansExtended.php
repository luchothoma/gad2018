<?php

declare(strict_types=1);

namespace Phpml\Clustering;

use Phpml\Clustering\KMeans\Space;
use Phpml\Exception\InvalidArgumentException;

class KMeansExtended extends KMeans
{
    private $clusters = null;

    public function __construct(int $clustersNumber, int $initialization = self::INIT_KMEANS_PLUS_PLUS)
    {
        parent::__construct($clustersNumber, $initialization); 
        $this->clusters = [];
    }

    public function generateClusters(array $samples): void
    {
        $space = new Space(count($samples[0]));
        foreach ($samples as $sample) {
            $space->addPoint($sample);
        }

        $this->clusters = [];
        foreach ($space->cluster($this->clustersNumber, $this->initialization) as $cluster) {
            $this->clusters[] = $cluster;
        }
    }

    public function clusterCentroide(int $index): array
    {
        if($index >= 0)
            return $this->clusters[$index-1]->getCentroid();
        else
            return null;
    }

    public function clusterPoints(int $index): array
    {
        if($index >= 0)
            return $this->clusters[$index-1]->getPoints();
        else
            return null;
    }
}