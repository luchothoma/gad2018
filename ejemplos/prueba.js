var data = {};

$(document).ready(function(){
  $.getJSON( "http://localhost/gad2018/histogramaNormalizado2.json", function(response) {
    console.log(response);
    data = response;
  });
});

function euclidiana(a, b) {
  var sum = 0
  var n
  for (n = 0; n < a.length; n++) {
    sum += Math.pow(a[n] - b[n], 2)
  }
  return Math.sqrt(sum)
}

function buscar(indexOfimage, acceptanceDistance){
  var resDiv = $('#resultados');
  resDiv.empty();

  var img = data[indexOfimage];
  var result = [];

  var img_png = 'http://localhost/gad2018/images/pokemons_db/'+img.name+'.png';
  var img_jpg = 'shttp://localhost/gad2018/images/pokemons_db/'+img.name+'.jpg';

  resDiv.load(img_png, function(response, status, xhr) {
    var imgurl = "";

    if (status == "error") 
      imgurl = img_jpg;
    else
      imgurl = img_png;

    resDiv.append('<b>'+indexOfimage+'</b><img src="'+imgurl+'" />');
    resDiv.append('<br/><br/><br/>');
  });


  data.forEach((elem,ind) => {
    if(euclidiana(elem.caracteristic_vector,img.caracteristic_vector) <= acceptanceDistance) {
      elem.distancia = euclidiana(elem.caracteristic_vector,img.caracteristic_vector);
      result.push(elem);
    }
  });

  result.sort(function(a,b) {
    /*
    if(a.distancia== b.distancia){
        return 0;
    }
    else if(a.distancia > b.distancia){
        return 1;
    }
    else{
        return -1;
    }
    */
    return a.distancia - b.distancia;
  });

  result.forEach((elem,ind) => {
    var img_png = 'http://localhost/gad2018/images/pokemons_db/'+elem.name+'.png';
    var img_jpg = 'http://localhost/gad2018/images/pokemons_db/'+elem.name+'.jpg';

    resDiv.load(img_png, function(response, status, xhr) {
      var imgurl = "";

      if (status == "error") 
          imgurl = img_jpg;
      else
          imgurl = img_png;

      resDiv.append('<div style="float:left;"><img src="'+imgurl+'"/><br/>'+ind+' - <b>'+euclidiana(elem.caracteristic_vector,img.caracteristic_vector).toFixed(7)+'</b></div>');
    });
  });

      return result;
  }
  
  function showPallet() {
    var resDiv = $('#resultados');
    resDiv.empty();

    [
      [185.77705977383, 194.19709208401, 185.91518578352, 89.032310177706],
      [175.61593851133, 177.84579288026, 169.79902912621, 0.55970873786408],
      [233.752,         223.54596721311, 157.2662295082,  0.504],
      [209.26541859146, 203.88094659211, 207.01037361212, 0.41073020504093],
      [61.59038694075,  86.111245465538, 91.054816606207, 1.8382708585248],
      [232.82925867508, 236.42436908517, 235.40512618297, 0.78383280757098],
      [167.58759157934, 148.41852916628, 117.76045627376, 1.1815821200037],
      [168.39075265079, 76.69337736833,  67.474882669911, 2.2473492091083],
      [129.0061734854,  152.60301349796, 151.13225907712, 1.4545359422413],
      [221.03179824561, 142.69210526316, 153.53486842105, 1.1151315789474],
      [81.636882129278, 71.525137304605, 142.78517110266, 0.86776510350655],
      [228.86812066857, 212.29005299633, 83.912759885854, 1.7362413371382],
      [102.7065084414,  78.2355028138,   59.301076584292, 1.9312454122828],
      [137.46332687517, 108.15222806532, 182.77940769444, 1.1796291170772],
      [48.259034051425, 134.16643502432, 161.58842946491, 2.5326615705351], 
      [47.590433284749, 46.594673380151, 43.450377633497, 2.6833178746522],
      [232.74494745352, 107.24151172191, 91.02748585287,  1.7010913500404],
      [131.0609264854,  205.42648539778, 221.79003021148, 1.0669687814703],
      [160.65338645418, 148.3797310757,  55.02938247012,  1.7203685258964],
      [119.21652378423, 114.00523480768, 106.60298915105, 1.7148167817313]
    ]
    .forEach((col) => resDiv.append('<div style="width:100px;height:100px;background-color:rgb('+parseInt(col[0])+','+parseInt(col[1])+','+parseInt(col[2])+');float:left;"></div>'));
  }