<template>
    
    <v-window v-model="tab">
        <v-window-item :value="1">
            <Emissor />
        </v-window-item>

        <v-window-item :value="2">
            <Simulador/>
        </v-window-item>
    </v-window>
</template>
<script>
import Emissor from './Emissor.vue';
import Simulador from './Simulador.vue';


export default {
    components: {
        Emissor,
        Simulador
    },
    props: {
        tabs: Number
    },
    data() {
        return {
            tab: this.tabs,
            hwindow: window.screen.height
        }
    },
    mounted(){
        console.log(this.hwindow)
    },  
    watch: {
        tabs() {
            this.tab = this.tabs
            console.log(this.tabs)
            console.log(this.tab)
        }
    }
}

</script>
