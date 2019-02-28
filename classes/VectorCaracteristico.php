<?php 
use Phpml\Math\Distance\Euclidean;

use Phpml\Clustering\KMeans\Cluster;
use Phpml\Clustering\KMeans\Space;
use Phpml\Clustering\KMeans\Point;

class VectorCaracteristico {
    private $_img = null;
    private $_vector = [];
    private $_origin_vector = null;

    function __construct(Image $img) {
    	$this->initialize($img);   
    }

    private function initialize(Image $img){
    	$this->_img = $img;

    	$vectorComponentsQuantity = ($this->colorPalletDimension()*2);

        //index	 Required. The first index of the returned array
		//number Required. Specifies the number of elements to insert
		//value	 Required. Specifies the value to use for filling the array
        $this->_origin_vector = array_fill(0,$vectorComponentsQuantity,0);

        $this->_vector = $this->_origin_vector;
    }

    private function colorPallet(): array {
        return $colorPalletArray = [    
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
		    [119.21652378423 ,114.00523480768 ,106.60298915105, 1.7148167817313],
		];
    }

    private function colorPalletDimension(): int{
    	return count($this->colorPallet());
    }

    private function colorPalletPredominant($pallet, $colorRGBA): array{
	    $minDistance = 999999;
	    $palletColor = [];
	    $palletColorIndex = []; 
	    $color = [
	    	$colorRGBA->red,
	    	$colorRGBA->green,
	    	$colorRGBA->blue,
	    	$colorRGBA->alpha
	    ];

	    foreach ($pallet as $index => $p) {
	        $distanceToColorPallet = (new Euclidean())->distance($p,$color);
	        if($distanceToColorPallet < $minDistance)
	        {
	            $minDistance = $distanceToColorPallet;
	            $palletColor = $p;
	            $palletColorIndex = $index;
	        }        
	    }

	    // Convertir a enteros valores de la paleta de color
	    for ($i=0; $i < count($palletColor); $i++) { 
	        $palletColor[$i] = (int) round($palletColor[$i], 0, PHP_ROUND_HALF_UP);
	    }

	    return ['index' => $palletColorIndex, 'color' => $palletColor];
	}

	private function getCentroidOf3x3($arrayRGBA): stdClass{
	    $cluster = new Cluster( new Space(4), [[],[],[],[]]);
	    foreach ($arrayRGBA as $color) {
	        $cluster->attach(new Point([$color->red, $color->green, $color->blue, $color->alpha]));
	    }
	    $cluster->updateCentroid();
	    $centroid = $cluster->getCentroid();

	    $centroidRGBA = new stdClass();
	    $centroidRGBA->red = $centroid[0];
	    $centroidRGBA->green = $centroid[1];
	    $centroidRGBA->blue = $centroid[2];
	    $centroidRGBA->alpha = $centroid[3];

	    return (object) $centroidRGBA;
	}

	private function colorPalletAplliedForEachPixelAvoidPixel($color): bool{
		return boolval($pixelColor->alpha == 127);
	}

	//Calculo de ocurrencias de cada color de la paleta por cada pixel de la imagen
    private function colorPalletAplliedForEachPixel() {
		$totalPixelsUsed = 0;
        foreach (range(0, ($this->_img->width()-1), 1) as $w) {
		    foreach (range(0, ($this->_img->height()-1), 1) as $h) {
				$pixelColor = $this->_img->getPixelRGBA($w,$h);
				if(!$this->colorPalletAplliedForEachPixelAvoidPixel($pixelColor)){
					$res = $this->colorPalletPredominant($this->colorPallet() ,$pixelColor);
					$this->_vector[$res['index']] += 1;
					$totalPixelsUsed++;
				}
			}
		}

		foreach(range(0,19,1) as $i) {
			$this->_vector[$i] = ($this->_vector[$i]/$totalPixelsUsed);
		}
	}
	
	private function colorPalletAplliedForEachSquareAvoidPixel($square3x3): bool{
		$self = $this;
		return boolval(array_reduce(
			$a,
			function($el) use ($self) {
				return ($self->colorPalletAplliedForEachPixelAvoidPixel($el)? 0: 1); 
			},
			0
		) >= 6);
	}

    //Calculo de ocurrencias de cada color de la paleta por cada color (centroide) de region de pixels (3x3) de la imagen
    private function colorPalletAplliedForEachSquare(){
		$totalSquaresUsed = 0;
    	foreach (range(1, ($this->_img->width()-2), 1) as $w) {
			foreach (range(1, ($this->_img->height()-2), 1) as $h) {
				$pointsSquare = [
                    $this->_img->getPixelRGBA($w-1,$h+1),  $this->_img->getPixelRGBA($w,$h+1),  $this->_img->getPixelRGBA($w+1,$h+1),
                    $this->_img->getPixelRGBA($w-1,$h),  $this->_img->getPixelRGBA($w,$h),  $this->_img->getPixelRGBA($w+1,$h),
                    $this->_img->getPixelRGBA($w-1,$h-1),  $this->_img->getPixelRGBA($w,$h-1),  $this->_img->getPixelRGBA($w+1,$h-1)
				];
				if(! $this->colorPalletAplliedForEachSquareAvoidPixel($pointsSquare)){
					$rgbaCentroide = $this->getCentroidOf3x3($pointsSquare);                    
					$res = $this->colorPalletPredominant($this->colorPallet() ,$rgbaCentroide);
					$this->_vector[($this->colorPalletDimension()+$res['index'])] = $this->_vector[($this->colorPalletDimension()+$res['index'])] + 1;
					$totalSquaresUsed++;
				}               
			}
		}
		
		foreach(range(20,39,1) as $i) {
			$this->_vector[$i] = ($this->_vector[$i]/$totalSquaresUsed);
		}
    }

    private function NormalizeResultVector(){
		//Normalizar vector caracteristico
        $norma_vector = (new Euclidean())->distance($this->_origin_vector, $this->_vector);
        for( $i=0; $i < count($this->_vector); $i++) { 
            $this->_vector[$i] = $this->_vector[$i] / $norma_vector;
        }
    }

    public function get(): array{
    	$this->colorPalletAplliedForEachPixel();
    	$this->colorPalletAplliedForEachSquare();
    	$this->NormalizeResultVector();
    	return $this->_vector;
    }
}
?>