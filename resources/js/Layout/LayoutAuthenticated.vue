<template>
  <v-app id="inspire">
    <v-layout>
      <header>
        <v-navigation-drawer elevation="2" color="#00796B" class="mx-2 my-2" rounded="1" expand-on-hover :rail="rail"
          :permanent="!rail" style="z-index: 2; border-right-color: transparent ;">


          <v-list density="compact" nav>
            <v-list-item size="large" class="text-white" href="/" value="NFe">
              <template v-slot:prepend>
                <v-avatar>
                  <v-icon size="23" icon="mdi-table" color="white"></v-icon>
                </v-avatar>
              </template>
              <v-list-item-title class="text-subtitle-1">NFe emitidas</v-list-item-title>
            </v-list-item>
            <!-- <v-list-item prepend-icon="mdi-account-multiple" title="Shared with me" value="shared"></v-list-item>
          <v-list-item prepend-icon="mdi-star" title="Starred" value="starred"></v-list-item> -->
          </v-list>
        </v-navigation-drawer>

        <v-app-bar class="ml-2" style=" z-index: 1; border: none; background-color: transparent; box-shadow: none; ">
          <v-card elevation="2" scroll-threshold="0" color="#00796B" class="ml-2 mr-3">
            <v-app-bar-nav-icon @click="rail = !rail" color="#FAFAFA" style="width: 55px !important;" />
          </v-card>

          <v-card class="w-25 h-75 mx-auto text-center pt-2" color="#00796B">
            <h2 class="text-white font-weight-bold" style="font-family: 'Roboto', sans-serif;">NFExpress</h2>
          </v-card>

          <v-card class="w-25 h-75 text-center mr-4 d-flex align-center px-2" color="#00796B" style="font-size: 15px;"
            max-width="100">
            <v-row>
              <v-col cols="5" class="d-flex align-center">
                <v-badge dot color="error">
                  <v-icon size="x-large">mdi-bell-outline</v-icon>
                </v-badge>
              </v-col>
              <v-col cols="7">
                <Link :href="`/view/user/${$page.props.user.data.id}`">
                  <v-avatar class="text-white">
                  <v-img  src="/img/tributei.png"></v-img>
                </v-avatar>
                </Link>
              </v-col>
            </v-row>



          </v-card>
        </v-app-bar>
      </header>


      <v-main class="h-screen" style="background-color: #f3f1f1;">
        <slot />
      </v-main>
    </v-layout>

  </v-app>
</template>
  
<script>
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
export default {
  components: {
    Link
  },
  data() {
    return {
      drawer: true,
      rail: true,
    }
  },

}
</script>