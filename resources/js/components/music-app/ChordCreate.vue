<template>
    <alert-loading :msg="msg" :isLoading="isLoading" :alert="alert"></alert-loading>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
    
                <h2 class="text-center">Posição do acorde</h2>

                <form action="">
                    <div class="row ">
                        <div class="col-sm-2 m-1">
                            <input type="text" class="form-control" v-model="state.title" placeholder="Acorde">
                        </div>
                    </div>
                    <div v-for="(line, lineIndex) in state.lines" :key="'line-' + lineIndex" class="acorde">
                        <div class="col-sm-2 m-1" v-for="(filed, index, aux) in line" :key="lineIndex + '-' + index">
                            <input v-if="aux == 0" type="text" class="form-control" v-model="line[index]" />
                            <input v-else type="number" class="form-control" v-model="line[index]" />
                        </div>
                    </div>

                    <button class="btn btn-sm btn-success mt-2" type="button" @click="submit(state)">Salvar acorde</button>
                </form>
            </div>
            
            <div class="col-md-6">
                <h2 class="text-center">Acorde</h2>
                <div class="row d-flex">
                    <div class="chord d-flex justify-content-center" >
                        <div class="chord-content">
                            <p class="m-0 p-0 text-center">{{ state.title }}</p>
                            <div class="line l1">
                                <span class="field2" v-for="(filed, index) in state.lines[0]" :key="'l1-' + index">
                                    <span v-if="index == 'line_1_position_1'" class="field2">{{ filed }}</span><span v-else class="field">{{ filed }}</span>
                                </span>
                            </div>
                            <div class="line l2">
                                <span class="field2" v-for="(filed, index) in state.lines[1]" :key="'l2-' + index">
                                    <span v-if="index == 'line_2_position_1'" class="field2">{{ filed }}</span><span v-else class="field">{{ filed }}</span>
                                </span>
                            </div>
                            <div class="line l3">
                                <span class="field2" v-for="(filed, index) in state.lines[2]" :key="'l3-' + index">
                                    <span v-if="index == 'line_3_position_1'" class="field2">{{ filed }}</span><span v-else class="field">{{ filed }}</span>
                                </span>
                            </div>
                            <div class="line l4">
                                <span class="field2" v-for="(filed, index) in state.lines[3]" :key="'l4-' + index">
                                    <span v-if="index == 'line_4_position_1'" class="field2">{{ filed }}</span><span v-else class="field">{{ filed }}</span>
                                </span>
                            </div>
                            <div class="line l5">
                                <span class="field2" v-for="(filed, index) in state.lines[4]" :key="'l5-' + index">
                                    <span v-if="index == 'line_5_position_1'" class="field2">{{ filed }}</span><span v-else class="field">{{ filed }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template v-if="chords">
        <h1 class="text-center mt-5">Lista de acordes</h1>
        
        <div class="list containe d-flex justify-content-center">
            <div  v-for=" chord in chords" :key="chord.id" >
                <div class="list-chord ">      
                    <span v-for="(position , index) in  convertForArray(chord.chord_positions)" :key="index">
                        <div class="list-chord-content mt-0">
                        <div class="list-line l1 d-flex justify-content-end me-4">
                            <p class="m-0 p-0 ">{{ chord.chord_name}}</p>
                        </div>
                        <div class="list-line l1">
                            <span class="list-field2" v-for="(filed, index) in position[0]" :key="'l1-' + index">
                               
                                <span v-if="index == 'line_1_position_1'" class="list-field2">{{ filed }}</span><span v-else class="list-field">{{ filed }}</span>
                            </span>
                        </div>
                        <div class="list-line l2">
                            <span class="list-field2"  v-for="(filed, index) in position[1]"  :key="'l2-' + index">
                                <span v-if="index == 'line_2_position_1'"class="list-field2">{{ filed }}</span><span v-else class="list-field">{{ filed }}</span>
                            </span>
                        </div>
                        <div class="list-line l3">
                            <span class="list-field2" v-for="(filed, index) in position[2]"  :key="'l3-' + index">
                                <span v-if="index == 'line_3_position_1'" class="list-field2">{{ filed }}</span><span v-else class="list-field">{{ filed }}</span>
                            </span>
                        </div>
                        <div class="list-line l4">
                            <span class="list-field2"  v-for="(filed, index) in position[3]" :key="'l4-' + index">
                                <span v-if="index == 'line_4_position_1'" class="list-field2">{{ filed }}</span><span v-else class="list-field">{{ filed }}</span>
                            </span>
                        </div>
                        <div class="list-line l5">
                            <span class="list-field2"  v-for="(filed, index) in position[4]"  :key="'l5-' + index">
                                <span v-if="index == 'line_5_position_1'" class="list-field2">{{ filed}}</span><span v-else class="list-field">{{ filed,0 }}</span>
                            </span>
                        </div>

                        <div class="list-line l5 d-flex justify-content-end me-1">
                            <button class="btn" @click="deleteChord(chord,index)"><i class="bi bi-trash" style="color: red;" ></i></button>
                        </div>
                    </div>
                    </span>
                </div>
            </div>
        </div>
    </template>
</template>

<script setup>
import { reactive, onMounted, ref, getCurrentInstance } from 'vue';
import { useChord } from '@/store/chord.js';
import{ catchDefault } from '@/utils/messagesCatch';
import urls from '@/utils/urls';
const props = defineProps(['token_crsf']);
const chords = ref(false);
const isLoading = ref(false);
const alert = ref(false);
const msg = ref(false);
const chordStore = useChord();
const page = urls.api+'chord';
const { proxy } = getCurrentInstance();
const config = {
   headers: {
       'Content-Type': 'multipart/form-data',
       'Accept': 'application/json',
   }
};

const messageSweet = ((text, type ) => {
	proxy.$swal.fire({
		title: text ,
		icon: type,

    });
});

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
const capitalizeFirstLetter = (string) => {
  return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}
const convertForArray = ((json) => {
    let parsedArray = JSON.parse(json);
    return parsedArray
});
const state = reactive({
  title: '',
  lines: [
    { line_1_position_1: '', line_1_position_2: '', line_1_position_3: '', line_1_position_4: '', line_1_position_5: '' },
    { line_2_position_1: '', line_2_position_2: '', line_2_position_3: '', line_2_position_4: '', line_2_position_5: '' },
    { line_3_position_1: '', line_3_position_2: '', line_3_position_3: '', line_3_position_4: '', line_3_position_5: '' },
    { line_4_position_1: '', line_4_position_2: '', line_4_position_3: '', line_4_position_4: '', line_4_position_5: '' },
    { line_5_position_1: '', line_5_position_2: '', line_5_position_3: '', line_5_position_4: '', line_5_position_5: '' }
  ]
});
const submit = (() => {
   const fields = {
        _method:'POST',
        chord_name : capitalizeFirstLetter(state.title),
        chord_positions : state.lines,
    }
    return chordStore.insert(page, fields, config)
    .then((response) => {
        if(response.request.status === 200 || response.request.status === 201 ){
            messageSweet( 'Novo acorde inserido','success');
            execute();
        }
    })
    .catch((e) => {
        returnCath(e);
    })
    .finally(() => isLoading.value = false);
});
const deleteChord = ((chord, index) => {
   const fields = {
        _method:'Delete',
        id : chord.id,
        chord_name : [chord.chord_name],
        key: index,
    }

    return chordStore.delete(page+"/"+fields.id, fields, config)
    .then((response) => {
        if(response.request.status === 200 || response.request.status === 201 ){
            messageSweet( 'Acorde apagado','success');
            execute();
        }
    })
    .catch((e) => {
        returnCath(e);
    })
    .finally(() => isLoading.value = false);
});
const execute = (async () => {

    isLoading.value = true;
    return await chordStore.get(page, config)
    .then( response => {
        chords.value = response.data.data;
    })
    .catch((e) => {
        returnCath(e);
    })
    .finally(() => isLoading.value = false);
});
const returnCath = ((e) => {
	const retornCatch = catchDefault(e);
	messages(retornCatch[0],retornCatch[1])
});

onMounted(() => execute() );
</script>

<style scoped>
.acorde{
    display: flex;
}
.chord-content {
    margin: 10px 10px;
    font-family: monospace;
}
.line {
    display: flex;
}
.field {
    width: 1.3em;
    height: 2em;
    font-weight: bold;
    font-family: sans-serif;
    font-size: larger;
    border-top: #f80303 1px solid; /* Mantém a borda superior da célula */
    display: inline-block;
    text-align: center;
    vertical-align: middle;
    position: relative; /* Necessário para o posicionamento da line */
    overflow: hidden; /* Garante que a line não ultrapasse as extremidades */
}
.field::before {
    content: "";
    position: absolute;
    top: 0; /* Começa a line no topo da célula */
    bottom: 0; /* Faz a line cobrir a célula sem ultrapassar */
    left: 50%; /* Centraliza a line na horizontal */
    width: 1px; /* Largura da line */
    background-color: #289c0b; /* Cor da line */
    transform: translateX(-50%); /* Ajusta o centro exato da line */
}
.field2 {
    width: 1em;
    height: 2em;
    display: inline-block;
    text-align: center;
    vertical-align: middle;
}
.list{
    display: flex;
    flex-wrap: wrap;
}
.list-chord{
    display: flex;
    flex-wrap: wrap;
}
.list-chord-content {
    margin: 10px 10px;
    margin-left: 10px;
    font-family: monospace;
}
.list-line {
    display: flex;
}
.list-field {
    width: 1.3em;
    height: 2em;
    font-weight: bold;
    font-family: sans-serif;
    font-size: larger;
    border-top: #289c0b 1px solid;
    display: inline-block;
    text-align: center;
    vertical-align: middle;
    position: relative;
    overflow: hidden;
}
.list-field::before {
    content: "";
    position: absolute;
    top: 0; 
    bottom: 0; 
    left: 50%; 
    width: 1px; 
    background-color: #289c0b; 
    transform: translateX(-50%); 
}
.list-field2 {
    width: 1em;
    height: 2em;
    display: inline-block;
    text-align: center;
    vertical-align: middle;
}
input{
    background-color: white;
}
input:focus{
    background-color: rgb(245, 255, 236);
}
</style>