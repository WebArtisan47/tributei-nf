<template>
    <v-responsive>
        <LayoutAuthenticated>
            <section class="my-1 ml-3 w-100 h-100">
                <h3 class="text-h4 ml-8 mt-8">Usuario</h3>
                <div class="w-100 px-15 my-3" style="height: 90%;">
                    <v-card class="w-100 h-100">
                        <v-row class="h-100" style="margin: 0;">
                            <v-col cols="3" class="pa-0" >
                                <v-card class="w-100 h-100" style="z-index: 4;">
                                    <v-card-title class="text-h3 text-center my-3" style="font-family: 'Roboto', sans-serif !important;">
                                        {{ $page.props.user.nome }}
                                    </v-card-title>
                                    
                                </v-card>
                            </v-col>
                            <v-col cols="8">
                                <v-card class="w-25" style="z-index: 3;">
                                    DADOS
                                </v-card>
                                <v-card class="w-25" style="z-index: 3;">
                                    DADOS
                                </v-card>
                                <v-card class="w-25" style="z-index: 3;">
                                    DADOS
                                </v-card>
                                <v-card class="w-25" style="z-index: 3;">
                                    DADOS
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card>
                </div>

            </section>
        </LayoutAuthenticated>
    </v-responsive>
</template>
<script>
import LayoutAuthenticated from '../../Layout/LayoutAuthenticated.vue';
export default {
    components: {
        LayoutAuthenticated,
    }
}

</script>
