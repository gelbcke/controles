@extends('layouts.app')

@section('styles')
<style type="text/css">
.decoded-content {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  max-width: 100%;

  color: white;
  font-weight: bold;
  padding: 10px;
  background-color: rgba(0,0,0,.5);
}

.error {
  color: red;
  font-weight: bold;
}
  </style>
<link rel="stylesheet" href="{{ asset('assets/node_modules/vue-qrcode-reader/dist/vue-qrcode-reader.css') }}">
@endsection

@section('content')




 <div id="app">
    <qrcode-stream @init="onInit" @decode="onDecode" :paused="paused">
      <div v-if="decodedContent !== null" class="decoded-content">@{{ decodedContent }}</div>
    </qrcode-stream>

    <div class="error">
      @{{ errorMessage }}
    </div>
  </div>




@endsection


@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.js"></script>
<script type="text/javascript" src="{{ asset('assets/node_modules/vue-qrcode-reader/dist/vue-qrcode-reader.browser.js') }}"></script>



<script>

Vue.use(VueQrcodeReader)

new Vue({
  el: '#app',

  data () {
    return {
      paused: false,
      decodedContent: null,
      errorMessage: ''
    }
  },

  methods: {
    onDecode (content) {
      this.decodedContent = content
    },

    onInit (promise) {
      promise.then(() => {
        console.log('Iniciado com sucesso! Pronto para scannear!')
      })
      .catch(error => {
        if (error.name === 'NotAllowedError') {
          this.errorMessage = 'Ei! Preciso de acesso a sua câmera!'
        } else if (error.name === 'NotFoundError') {
          this.errorMessage = 'Você possuí alguma câmera no seu dispositivo?'
        } else if (error.name === 'NotSupportedError') {
          this.errorMessage = 'Parece que esta página é veiculada em um contexto não seguro (HTTPS, localhost ou file://)'
        } else if (error.name === 'NotReadableError') {
          this.errorMessage = 'Não foi possível acessar a sua câmera.'
        } else if (error.name === 'OverconstrainedError') {
          this.errorMessage = 'As restrições não correspondem a nenhuma câmera instalada. Você selecionou uma câmera frontal que não existe?'
        } else {
          this.errorMessage = 'ERRO DESCONHECIDO: ' + error.message
        }
      })
    }
  }
})
</script>


@endsection