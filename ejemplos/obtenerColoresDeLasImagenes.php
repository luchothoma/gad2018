<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Image.php';

use Phpml\Clustering\KMeansExtended;
/*
$dir = __DIR__ . '/images/pokemons_db/';
$pixels = null;
$pixelsCounted = null;

if ($gestor = opendir($dir)) {
    while (false !== ($entrada = readdir($gestor))) {
        if ($entrada != "." && $entrada != ".." && !is_dir($dir.$entrada)) {

            $img = new Image($dir.$entrada);

            for ($w=0; $w < $img->width(); $w++) { 
                for ($h=0; $h < $img->height(); $h++) { 
                    $rgba = $img->getPixelRGBA($w,$h);
                    //echo "X: {$w}\tY: {$h}\tR: {$rgba->red}\tG: {$rgba->green}\tB: {$rgba->blue}\tA: {$rgba->alpha} <br>";
                    if(!($rgba->red==0 && $rgba->green==0 && $rgba->blue==0 && $rgba->alpha==127))
                    {
                        if(isSet($pixelsCounted[$rgba->red][$rgba->green][$rgba->blue][$rgba->alpha]))
                        {
                            $pixelsCounted[$rgba->red][$rgba->green][$rgba->blue][$rgba->alpha]++;
                        }
                        else
                        {
                            $pixels[] = [$rgba->red, $rgba->green, $rgba->blue, $rgba->alpha];
                            $pixelsCounted[$rgba->red][$rgba->green][$rgba->blue][$rgba->alpha]=1;
                        }
                    }
                }
            }
        }
    }
    closedir($gestor);
}
echo json_encode($pixels);
echo "<br>";
echo json_encode($pixelsCounted);
*/

$numberOfClusters = 20;
$kmeans = new KMeansExtended($numberOfClusters);
$kmeans->generateClusters($samples);
$colorPallet = [];
for ($i=1; $i <= $numberOfClusters; $i++)
{ 
    $colorPallet[] = $kmeans->clusterCentroide($i);
}
var_dump($colorPallet);

$colorPalletArray = [    
    [185.77705977383, 194.19709208401 ,185.91518578352, 89.032310177706],
    [175.61593851133,177.84579288026 ,169.79902912621, 0.55970873786408],
    [233.752 ,223.54596721311 ,157.2662295082, 0.504],
    [209.26541859146 ,203.88094659211 ,207.01037361212, 0.41073020504093],
    [61.59038694075 ,86.111245465538 ,91.054816606207, 1.8382708585248],
    [232.82925867508 ,236.42436908517 ,235.40512618297, 0.78383280757098],
    [167.58759157934 ,148.41852916628 ,117.76045627376, 1.1815821200037],
    [168.39075265079 ,76.69337736833 ,67.474882669911, 2.2473492091083],
    [129.0061734854 ,152.60301349796 ,151.13225907712, 1.4545359422413],
    [221.03179824561 ,142.69210526316 ,153.53486842105, 1.1151315789474],
    [81.636882129278 ,71.525137304605 ,142.78517110266, 0.86776510350655],
    [228.86812066857 ,212.29005299633 ,83.912759885854, 1.7362413371382],
    [102.7065084414 ,78.2355028138 ,59.301076584292, 1.9312454122828],
    [137.46332687517 ,108.15222806532 ,182.77940769444, 1.1796291170772],
    [48.259034051425 ,134.16643502432 ,161.58842946491, 2.5326615705351], 
    [47.590433284749, 46.594673380151, 43.450377633497, 2.6833178746522],
    [232.74494745352 ,107.24151172191 ,91.02748585287, 1.7010913500404],
    [131.0609264854 ,205.42648539778 ,221.79003021148, 1.0669687814703],
    [160.65338645418 ,148.3797310757 ,55.02938247012, 1.7203685258964],
    [119.21652378423 ,114.00523480768 ,106.60298915105, 1.7148167817313]
];