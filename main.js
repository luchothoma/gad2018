// https://lian-yue.github.io/vue-upload-component/#/documents
Vue.component('file-upload', VueUploadComponent)

new Vue({
  el: '#app',
  data () {
    return {
      files: [],
      pokemon: [],
      searchLimit: 15
    }
  },
  components: {
    FileUpload: VueUploadComponent
  },
  methods: {
    inputFile: function (newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        // Get response data
        console.log('response', newFile.response.filename)
        if (newFile.xhr) {
          //  Get the response status code
          console.log('status', newFile.xhr.status)
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
      fetch('./selectAll', {
        method: 'GET'
      })
      .then(response => response.json())
      .then(data => this.pokemon = data)
      .catch(error => console.error(error))
    }
  },
   mounted: function () {
      this.getAllPokemon()
    }
})