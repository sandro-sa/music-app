<template>
	<alert-loading :msg="msg" :isLoading="isLoading" :alert="alert"></alert-loading>
	<div class="container">
		<singer-create v-if="newSinger"  :token_crsf="token_crsf" @sendMessageDad="messages"  @excuteLoadind="isLoading = !isLoading" @execute="execute"></singer-create>
		<tone-create v-if="newTone"  :token_crsf="token_crsf" @sendMessageDad="messages"  @excuteLoadind="isLoading = !isLoading" @execute="execute"></tone-create>
		<rhythm-create v-if="newRhythm"  :token_crsf="token_crsf" @sendMessageDad="messages"  @excuteLoadind="isLoading = !isLoading" @execute="execute"></rhythm-create>
		<form @submit.prevent="submitForm">
			<div class="row">

				<div class="col-md-4">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label for="music_name">Informar musico</label>
								<select v-model="singer" class="form-select" aria-label="Default select example">
									<template v-for="singer in singers" :key="singer.id">
										<option :value="singer.id">{{singer.singer_name  }}</option>
									</template>
								</select>
        					</div>
						</div>
						<div class="col-md-4 d-flex justify-content-start align-items-end">
							<div class="">
								<button class="btn  btn-primary" type="button" @click="newSinger =! newSinger">Novo</button>
							</div>
						</div>
					</div>
          		</div>

				<div class="col-md-4">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label for="music_name">Informar tom</label>
								<select v-model="tone" class="form-select" aria-label="Default select example">
									<template v-for="tone in tones" :key="tone.id">
										<option :value="tone.id">{{tone.tone  }}</option>
									</template>
								</select>
        					</div>
						</div>
						<div class="col-md-4 d-flex justify-content-start align-items-end">
							<div class="">
								<button class="btn  btn-primary" type="button" @click="newTone =! newTone">Novo</button>
							</div>
						</div>
					</div>
					
				</div>

				<div class="col-md-4">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label for="music_name">Informar ritmo</label>
								<select v-model="rhythm" class="form-select" aria-label="Default select example" >
									<template v-for="rhythm in rhythms" :key="rhythm.id">
										<option :value="rhythm.id">{{rhythm.rhythm  }}</option>
									</template>
								</select>
        					</div>
						</div>
						<div class="col-md-4 d-flex justify-content-start align-items-end">
							<div class="">
								<button class="btn  btn-primary" type="button" @click="newRhythm =! newRhythm">Novo</button>
							</div>
						</div>
					</div>
				</div>

        	</div>
       
			<div class="form-group">
				<label for="music_name">Título da Música</label>
				<input v-model="music_name" type="text" class="form-control" id="music_name" name="music_name" placeholder="Digite o título da música">
			</div>

			<div class="form-group">
				<label for="music_name">Introdução</label>
				<input v-model="introduction" type="text" class="form-control" id="introduction" name="introduction" placeholder="Introdução em cifras">
			</div>
        
			<div class="form-group">
				<label for="music">Letra da Música</label>
				<div ref="editor" class="quill-editor"></div>
			</div>
  
			<div class="d-flex justify-content-end">
				<button type="submit" class="btn btn-success mt-5" @click="submit()">Salvar</button>
			</div>
      </form>
    </div>
  </template>
  
<script setup>
import { ref, onMounted } from 'vue';
import { useSinger } from '@/store/singer.js';
import{ catchDefault } from '@/utils/messagesCatch';
import urls from '@/utils/urls';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';
const props = defineProps(['token_crsf']);
const newSinger = ref(false);
const newTone = ref(false);
const newRhythm = ref(false);
const isLoading = ref(false);
const alert = ref(false);
const msg = ref(false);
const store = useSinger();
const singers = ref(null);
const tones = ref(null);
const rhythms = ref(null);
const singer = ref(null);
const tone = ref(null);
const rhythm = ref(null);
const introduction = ref(null);
const music_name = ref('');
const music = ref(null);
const editor = ref(null);


const config = {
   headers: {
       'Content-Type': 'multipart/form-data',
       'Accept': 'application/json',
   }
};
const messages = ((text, type ) => {
    msg.value = text;
    alert.value = type;
    setTimeout(() =>{
        resetMessages();
    }, 2000)
});
const resetMessages = (( ) => {
    msg.value = false;
    alert.value = false;
});
const submit = (async () => {
    isLoading.value = true;
   const fields = {
        _method:'POST',
		singer_id: singer.value,
		tone_id: tone.value,
		rhythm_id: rhythm.value,
		introduction: introduction.value,
		music_name: music_name.value,
		music: music.value,
        
    }
    return store.insert(urls.api+'music', fields, config)
    .then((response) => {
        if(response.request.status === 200 || response.request.status === 201 ){
            messages( 'Musica inserida','alert-success');
            execute();
			singer.value = null;
			tone.value = null;
			rhythm.value = null;
			introduction.value = null;
			music_name.value = null;
			music.value = "";
        }
    })
    .catch((e) => {
        returnCath(e);
    })
    .finally(() => isLoading.value = false);
});
const getRhythm = (async () => {
    return await store.get(urls.api+'rhythm', config)
    .then( response => {
        rhythms.value = response.data.data;
    })
    .catch((e) => {
        returnCath(e);
    })
});
const getTone = (async () => {
    return await store.get(urls.api+'tone', config)
    .then( response => {
        tones.value = response.data.data;
    })
    .catch((e) => {
        returnCath(e);
    })
});
const getSinger = (async () => {
    return await store.get(urls.api+'singer', config)
    .then( response => {
        singers.value = response.data.data;
    })
    .catch((e) => {
        returnCath(e);
    })
});
const returnCath = ((e) => {
	console.log(e)
	const retornCatch = catchDefault(e);
	messages(retornCatch[0],retornCatch[1])
});
const execute = (() => {
	getSinger();
	getTone();
	getRhythm();
	newSinger.value = false;
	newTone.value = false;
	newRhythm.value = false;
	isLoading.value = false;
}) ;
onMounted(() => {
  const quill = new Quill(editor.value, {
      theme: 'snow',
      placeholder: 'Escreva a letra da música aqui...',
      modules: {
        toolbar: [
			[{ 'header': '1' }, { 'header': '2' }, { 'font': [] }],
			[{ 'list': 'ordered' }, { 'list': 'bullet' }],
			[{ 'align': [] }],
			['bold', 'italic', 'underline'],
			['link'],
			['blockquote'],
			[{ 'color': [] }, { 'background': [] }],
			['clean']
        ]
      }
    });
  
    quill.on('text-change', () => {
      music.value = quill.root.innerHTML;
    });
	execute();
});
</script>
<style scoped>
  .quill-editor {
    min-height: 700px;
	background-color: rgb(255, 255, 255);
  }
  input, select{
	background-color: white;
  }
</style>
  