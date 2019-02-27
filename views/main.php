<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Pokebúsqueda · ¡Búscalos ya!</title>
  <link rel="icon" href="./images/favicon.png">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700">
</head>
<body>
  <div id="app">
    <section id="busqueda">
      <div class="heading">
        <h2>¡Búscalo ya!</h2>
        <h3>Elige o sube un pokemon</h3>
      </div>
      
      <ul class="lista-pokemon">
        <li v-for="poke in pokemon" :key="poke.id">
          <input
            type="radio"
            :id="poke.id"
            name="selectedPokemon"
            v-model="selectedPokemon"
            :value="poke.id">
          <label :for="poke.id">
            <img :src="poke.nombrearchivo">
            <strong>{{ poke.nombre }}</strong>
          </label>
        </li> 
      </ul>
      
      <div class="toolbar">
        <div class="limit-filter">
          <input
            type="range"
            v-model="searchLimit"
            class="slider"
            value="15"
            min="5"
            max="20"
            step="1">
          <div class="limit-number">
            <strong class="label">Límite de búsqueda:</strong> <span class="number">{{ searchLimit }}</span>
          </div>
        </div>

        <div class="upload-area">
          <file-upload
            ref="upload"
            v-model="files"
            class="file-input"
            post-action="./upload"
            @input="promptPokemonName"
            @input-file="inputFile"
            @input-filter="inputFilter"
          >
            Seleccionar pokemon...
          </file-upload>
    
          <a
            v-show="!$refs.upload || !$refs.upload.active"
            @click.prevent="$refs.upload.active = true"
            type="button"
          >
            Subir y buscar similares
          </a>
  
          <a
            v-show="$refs.upload && $refs.upload.active"
            @click.prevent="$refs.upload.active = false"
            type="button"
          >
            Detener subida
          </a>
        </div>
        <a id="buscar" @click.prevent="searchSimilar">Buscar similares</a>
      </div>
    </section>
    <section id="resultados">
      <div class="heading">
        <h2>Pokemon similares</h2>
        <h3>Resultado de la búsqueda</h3>
      </div>

      <ul class="lista-pokemon">
        <li v-for="poke in similarPokemon" :key="poke.id">
          <label>
            <img :src="poke.nombrearchivo">
            <strong>{{ poke.nombre }}</strong>
            <span>{{ poke.distance }}</span>
          </label>
        </li> 
      </ul>
    </section>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-upload-component"></script>
<script src="main.js"></script>
</html>