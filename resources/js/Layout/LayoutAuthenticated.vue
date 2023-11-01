<template>
  <v-app id="inspire">
    <v-layout>
      
      <v-navigation-drawer expand-on-hover rail style="z-index: 2; border-right-color: transparent ;">
        <v-list>
          <v-list-item prepend-avatar="https://randomuser.me/api/portraits/women/85.jpg" title="Sandra Adams"
            subtitle="sandra_a88@gmailcom"></v-list-item>
        </v-list>

      

        <v-list density="compact" nav>
          <v-list-item prepend-icon="mdi-folder" title="My Files" value="myfiles"></v-list-item>
          <v-list-item prepend-icon="mdi-account-multiple" title="Shared with me" value="shared"></v-list-item>
          <v-list-item prepend-icon="mdi-star" title="Starred" value="starred"></v-list-item>
        </v-list>
      </v-navigation-drawer>
      <v-app-bar scroll-threshold="0" style="z-index: 1;" >
        <h1 class="font-weight-light"> Emissão de notas fiscais</h1>
      </v-app-bar>

      <v-main style="background-color: #FAFAFA;">
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
    }
  }
}
</script>