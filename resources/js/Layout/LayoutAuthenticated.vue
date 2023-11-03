<template>
  <v-app id="inspire">
    <v-layout>
      <header >
        <v-navigation-drawer color="#00796B" class="mx-2 my-2" rounded="1"  expand-on-hover :rail="rail" :permanent="!rail" style="z-index: 2; border-right-color: transparent ;">
        <v-list>
          <v-list-item prepend-avatar="https://randomuser.me/api/portraits/women/85.jpg" class="text-white" title="Sandra Adams"
            subtitle="sandra_a88@gmailcom"></v-list-item>
        </v-list>

        <v-list density="compact" nav>
          <v-list-item prepend-icon="mdi-table" class="text-white" title="NFe emitidas" href="/" value="NFe"></v-list-item>
          <!-- <v-list-item prepend-icon="mdi-account-multiple" title="Shared with me" value="shared"></v-list-item>
          <v-list-item prepend-icon="mdi-star" title="Starred" value="starred"></v-list-item> -->
        </v-list>
      </v-navigation-drawer>
     
      <v-app-bar class="ml-2" style=" z-index: 1; border: none; background-color: transparent; box-shadow: none; ">
        <v-card scroll-threshold="0" color="#00796B" class="ml-2" >
          <v-app-bar-nav-icon @click="rail = !rail" color="#FAFAFA" style="width: 55px !important;"/>
        </v-card>
      
       <v-card class="w-25 h-75 mx-auto text-center" color="#00796B" style="padding: 10px;">
        <h2 class="text-white font-weight-bold" style="font-family: 'Roboto', sans-serif;">Emissor de NFe</h2>
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

export default {
  data() {
    return {
      drawer: true,
      rail: true,
    }
  }
}
</script>