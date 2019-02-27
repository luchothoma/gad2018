// https://lian-yue.github.io/vue-upload-component/#/documents
Vue.component('file-upload', VueUploadComponent)

new Vue({
  el: '#app',
  data () {
    return {
      files: [],
      pokemon: [],
      searchLimit: 15,
      pokemonData: {
        pokemonName: ''
      },
      selectedPokemon: '',
      similarPokemon: [],
      isLoading: false
    }
  },
  components: {
    FileUpload: VueUploadComponent
  },
  methods: {
    inputFile: function (newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        // Get response data
        console.log('response', newFile.response)
        if (newFile.xhr) {
          //  Get the response status code
          console.log('status', newFile.xhr.status)
        }

        if (newFile.success !== oldFile.success) {
          this.getAllPokemon()
          this.selectedPokemon = newFile.response.id
          this.searchSimilar()
        }
      }
    },
    inputFilter: function (newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Filter non-image file
        if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
          return prevent()
        }
      }

      // Create a blob field
      newFile.blob = ''
      let URL = window.URL || window.webkitURL
      if (URL && URL.createObjectURL) {
        newFile.blob = URL.createObjectURL(newFile.file)
      }
    },
    getAllPokemon: function () {
      this.isLoading = true

      fetch('./selectAll',)
        .then(response => response.json())
        .then(data => this.pokemon = data)
        .then(() => this.isLoading = false)
        .catch(error => console.error(error))
    },
    searchSimilar: function () {
      this.isLoading = true

      fetch(`./similar/${this.selectedPokemon}/${this.searchLimit}`)
        .then(response => response.json())
        .then(data => this.similarPokemon = this.formatSimilarResults(data))
        .then(() => this.isLoading = false)
        .catch(error => console.error(error))
    },
    formatSimilarResults: function (results) {
      return results.map(result => {
        const [id, distance] = result
          .obtenernpokemonssimilares
          .slice(1, -1)
          .split(',')

        const pokemon = this.pokemon.find(p => p.id == id)

        return { ...pokemon, distance }
      })   
    }
  },
  mounted: function () {
    this.getAllPokemon()
  }
})