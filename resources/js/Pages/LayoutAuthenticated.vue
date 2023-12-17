<template>
  <v-app id="inspire">
    <v-layout>
      <header>
        <v-navigation-drawer elevation="2" color="#FAFAFA" class="mx-2 my-2" rounded="1" expand-on-hover :rail="rail"
          :permanent="!rail" style="z-index: 2; border-right-color: transparent ;">


          <v-list density="compact" nav>
            <v-list-item size="large" @click="tab = 1"
              :style="tab === 1 ? 'background: linear-gradient(45deg,#0a4 7.55%,#0a8 91.23%); color: white !important;' : null"
              class="text-black" >
              <template v-slot:prepend>
                <v-avatar>
                  <v-icon size="23" icon="mdi-file" :color="tab === 1 ? 'white' : 'black'"></v-icon>
                </v-avatar>
              </template>
              <v-list-item-title class="side-text">NFe emitidas</v-list-item-title>
            </v-list-item>
            <v-list-item size="large" @click="tab = 2"
              :style="tab === 2 ? 'background: linear-gradient(45deg,#0a4 7.55%,#0a8 91.23%); color: white !important;' : null"
              class="text-black" >
              <template v-slot:prepend>
                <v-avatar>
                  <v-icon size="23" icon="mdi-calculator"
                    :color="tab === 2 ? 'white' : 'black'"></v-icon>
                </v-avatar>
              </template>
              <v-list-item-title class="side-text">Simulador de venda </v-list-item-title>
            </v-list-item>
            <!-- <v-list-item prepend-icon="mdi-account-multiple" title="Shared with me" value="shared"></v-list-item>
          <v-list-item prepend-icon="mdi-star" title="Starred" value="starred"></v-list-item> -->
          </v-list>
        </v-navigation-drawer>

        <v-app-bar class="ml-2" style=" z-index: 1; border: none; background-color: transparent; box-shadow: none; ">
          <v-card elevation="2" scroll-threshold="0" color="#00aa44" class="ml-2 mr-3">
            <v-app-bar-nav-icon @click="rail = !rail" color="#FAFAFA" style="width: 55px !important;" />
          </v-card>

          <v-card class="mx-auto " style="width: 30% !important; height: 80% !important;" color="#00aa44">
            <v-autocomplete class="text-white mx-auto font-weight-bold w-75" menu-icon="" :items="empresas" v-model="empresa" density="compact" variant="outlined" style="font-family: 'Roboto', sans-serif; margin-top: 4px;"></v-autocomplete>
          </v-card>

          <v-card class="w-25 h-75 text-center mr-4 d-flex align-center px-2" color="#FAFAFA" style="font-size: 15px;"
            max-width="100">
            <v-row>
              <v-col cols="5" class="d-flex align-center">
                <v-badge dot color="error">
                  <v-icon size="x-large">mdi-bell-outline</v-icon>
                </v-badge>
              </v-col>
              <v-col cols="7">
                <Link :href="`/view/user/${$page.props.user.data.id}`">
                <v-avatar color="#00aa44">
                  <v-img src="/img/tributei.png"></v-img>
                </v-avatar>
                </Link>
              </v-col>
            </v-row>



          </v-card>
        </v-app-bar>
      </header>


      <v-main class="h-screen" style="background-color: #f3f1f1;">
        <Home :tabs="tab" />
      </v-main>
    </v-layout>

  </v-app>
</template>
  
<script>
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import Home from './Home.vue';
export default {
  components: {
    Link,
    Home
  },
  data() {
    return {
      drawer: true,
      rail: true,
      tab: 1,
      empresa: "41.219.310/0001-89, ANA MARTHA CURSOS ONLINE LTDA",
      empresas: ["41.219.310/0001-89, ANA MARTHA CURSOS ONLINE LTDA"]
    }
    
  },
  
}
</script>

<style>
.side-text {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700;
  font-size: 16px !important;
}
</style>