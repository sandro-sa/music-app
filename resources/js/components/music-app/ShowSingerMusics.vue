<template>
	<div class="container">
		<alert-loading :msg="msg" :isLoading="isLoading" :alert="alert"></alert-loading>
		<div class="row">
            <div class="col">
                <h2 class="text-start mt-3">{{singer.singer_name}}</h2>
            	<table class="table table-bordered table-info table-hover">
					<thead>
						<tr>
						<th scope="col">#</th>
						<th scope="col">Musicas</th>
						<th scope="col">Ritmo</th>
						<th scope="col">tom</th>
						</tr>
					</thead>
					<tbody>
						<template v-for=" music in musics" :key="music.id">
						<tr @click="updatemusic(music)">
						<th scope="row">{{ music.id }}</th>
						<td>{{ music.music_name }}</td>
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
import {onMounted, ref} from 'vue';
import urls from '@/utils/urls';
import { useSinger } from '@/store/singer.js'
const props = defineProps(['token_crsf','singer']);
const page = urls.api+'singer_musics/'+props.singer.id
const singerStore = useSinger();
const musics = ref(false)
const isLoading = ref(false);
const msg = ref(false);
const alert = ref(false);

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
    return await singerStore.get(page, config)
    .then( response => {
        musics.value = response.data.data;
    })
    .catch((e) => {
        returnCath(e);
    })
    .finally(() => isLoading.value = false);
});

onMounted(() => execute() );
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
  