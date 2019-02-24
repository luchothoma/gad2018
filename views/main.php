<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Pokebúsqueda · ¡Búscalos ya!</title>
  <link rel="icon" href="./images/favicon.png">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="app">
    <section id="busqueda">
      <h2>Elige un pokemon</h2>
      
      <ul class="lista-pokemon">
         <li v-for="poke in pokemon" :key="poke.id">
          <input type="radio" :id="poke.id" name="pokemon-elegido" :value="poke.id">
          <label :for="poke.id">
            <img :src="poke.nombrearchivo">
            {{ poke.nombre+ ' ' + poke.id }}
          </label>
        </li> 
      </ul>
      
      <div class="toolbar">
        <input type="range" class="slider">
        <div class="upload-area">
          <file-upload
            ref="upload"
            v-model="files"
            class="file-input"
            post-action="./upload"
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
        <a id="buscar">Buscar similares</a>
      </div>
    </section>
    <section id="resultados">
      <h2>Resultados</h2>
    </section>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-upload-component"></script>
<script src="main.js"></script>
</html>