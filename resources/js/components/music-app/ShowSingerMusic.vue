<template>
	<alert-loading :msg="msg" :isLoading="isLoading" :alert="alert"></alert-loading>
	<div class="container">
		<div class="row">
            <div class="col">
                <h2 class="text-start mt-3">Musicas</h2>
            	<table class="table table-bordered table-info table-hover">
					<thead>
						<tr>
						<th scope="col">#</th>
						<th scope="col">Nome</th>
						<th scope="col">Musico</th>
						<th scope="col">Ritmo</th>
						<th scope="col">tom</th>
						</tr>
					</thead>
					<tbody>
						<template v-for=" music in musics" :key="music.id">
						<tr @click="updatemusic(music)">
						<th scope="row">{{ music.id }}</th>
						<td>{{ music.music_name }}</td>
						<td>{{ music.singer.singer_name }}</td>
						<td>{{ music.rhythm.rhythm }}</td>
						<td>{{ music.tone.tone }}</td>
						</tr> 
						</template>
					</tbody>
            	</table>
       		</div>
   		</div>
	</div>
</template>
  
<script setup>
import { ref, onMounted } from 'vue';
import { useMusic } from '@/store/music.js';
import{ catchDefault } from '@/utils/messagesCatch';
import urls from '@/utils/urls';
import 'quill/dist/quill.snow.css';
const props = defineProps(['token_crsf']);
const musicStore = useMusic();
const isLoading = ref(false);
const alert = ref(false);
const msg = ref(false);
const musics = ref(null);
const page = urls.api+'music';

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

const execute = (async () => {
    isLoading.value = true;
    return await musicStore.get(page, config)
    .then( response => {
		console.log(response)
        musics.value = response.data.data;

    })
    .catch((e) => {
        returnCath(e);
    })
    .finally(() => isLoading.value = false);
});

const returnCath = ((e) => {
	console.log(e)
	const retornCatch = catchDefault(e);
	messages(retornCatch[0],retornCatch[1])
});

onMounted(() => {
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
  