<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Búsqueda de Pokémon</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="app">
    <section id="busqueda">
      
      <ul class="lista-pokemon">
        <!-- <li v-for="name in imagesFilenames" :key="name">
          <input type="radio" :id="name" name="pokemon" :value="name">
          <label :for="name">
            <img :src="`images/pokemons_db/${name}.png`">
            {{ name }}
          </label>
        </li> -->
      </ul>
      
      <div class="toolbar">
        <file-upload
          ref="upload"
          v-model="files"
          class="file-input"
          post-action="./upload"
          @input-file="inputFile"
          @input-filter="inputFilter"
        >
          Agregar pokemon...
        </file-upload>
  
        <a
          v-show="!$refs.upload || !$refs.upload.active"
          @click.prevent="$refs.upload.active = true"
          type="button"
        >
          Subir y buscar
        </a>

        <a
          v-show="$refs.upload && $refs.upload.active"
          @click.prevent="$refs.upload.active = false"
          type="button"
        >
          Detener subida
        </a>
        <a id="buscar">Buscar pokemons similares</a>
      </div>
    </section>
    <section id="resultados">
      <h2>Resultados XYZ</h2>
    </section>
  </div>
</body>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-upload-component"></script>
<script src="main.js"></script>
<!-- <script src="prueba.js"></script> -->
</html>