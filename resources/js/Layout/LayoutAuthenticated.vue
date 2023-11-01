<template>
    <v-app id="inspire">
        <v-layout>
      

      <v-main style="height: 250px">
        <slot/>
    </v-main>
    </v-layout>

    </v-app>
  </template>
  
  <script>
  
    export default {
      data(){
        return{
            drawer: true,
        }
      }
    }
  </script>