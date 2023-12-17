<template>
    <Layout>
        <title>Tributei | Usuário</title>
        <v-responsive class="h-100">
            <section class="my-1 ml-3 w-100 h-100 overflow-y-auto">
                <h3 class="text-h4 ml-8 mb-0">Usuario</h3>
                <div class="w-100 px-15 my-3 " style="height: 90%;">
                    <section class="w-100 h-100 d-grid align-center" color="transparent"
                        style="border: none !important; position: relative; font-weight: 600 !important;">
                        <v-card class="w-50 h-100 " id="card1" max-width="310" style=" z-index: 4; position: absolute; font-weight: 600 !important;">
                            <v-row class="">
                                <v-col cols="12">
                                    <v-card-title class="text-h5 text-center mt-3"
                                        style="font-family: 'Roboto', sans-serif !important;">
                                        {{ $page.props.user.data.nome }}
                                    </v-card-title>
                                </v-col>
                                <v-col cols="12" max-height="182" class="text-center pt-0">
                                    <v-avatar color="success" size="150">
                                        <v-img src="/img/tributei.png"></v-img>
                                    </v-avatar>
                                </v-col>
                                <v-col cols="12" max-height="48" class="text-start pt-0">
                                    <v-card-title class="text-subtitle-1 text-center"
                                        style="font-family: 'Roboto', sans-serif !important;">
                                        Administrador
                                    </v-card-title>
                                </v-col>
                                <!-- DADOS -->
                                <v-row justify="center" class="mx-2">
                                    <!-- COL 1 -->
                                    <v-col cols="6">
                                        <v-col cols="12" max-height="48" class="text-start pt-0">
                                            <v-card-title class="text-subtitle-2 text-start pa-0"
                                                style="font-family: 'Roboto', sans-serif !important;">
                                                CPF/CNPJ
                                            </v-card-title>
                                            <v-card-text class="text-caption pa-0">
                                                {{ $page.props.user.data.cpf === null ? $page.props.user.data.cnpj :
                                                    $page.props.user.data.cpf }}
                                            </v-card-text>
                                        </v-col>
                                        <v-col cols="12" max-height="48" class="text-start pt-0">
                                            <v-card-title class="text-subtitle-2 text-start pa-0"
                                                style="font-family: 'Roboto', sans-serif !important;">
                                                Telefone
                                            </v-card-title>
                                            <v-card-text class="text-caption pa-0">
                                                {{ $page.props.user.data.telefone }}
                                            </v-card-text>
                                        </v-col>
                                        <v-col cols="12" max-height="48" class="text-start pt-0 pr-0">
                                            <v-card-title class="text-subtitle-2 pa-0 text-start "
                                                style="font-family: 'Roboto', sans-serif !important;">
                                                Vinculo Tributei
                                            </v-card-title>
                                            <v-card-text class="pa-0" style="font-size: 13px;">
                                                {{ $page.props.user.data.api_token_tributei != null ? 'Sim' : 'Não' }}
                                            </v-card-text>
                                        </v-col>
                                    </v-col>
                                    <!-- COL 2 -->
                                    <v-col cols="6" style="padding-right: 5px;">
                                        <v-col cols="12" max-height="48" class="text-start pt-0">
                                            <v-card-title class="text-subtitle-2 text-start pa-0"
                                                style="font-family: 'Roboto', sans-serif !important;">
                                                Email
                                            </v-card-title>
                                            <v-card-text class="text-caption pa-0">
                                                {{ $page.props.user.data.email }}
                                            </v-card-text>
                                        </v-col>
                                        <v-col cols="12" max-height="48" class="text-start pt-0 pr-0">
                                            <v-card-title class="text-subtitle-2 pa-0 text-start "
                                                style="font-family: 'Roboto', sans-serif !important;">
                                                Endereço
                                            </v-card-title>
                                            <v-card-text class="pa-0" style="font-size: 13px;">
                                                {{ $page.props.user.data.endereco + ',' + $page.props.user.data.numero }}
                                            </v-card-text>
                                        </v-col>

                                        <v-col cols="12" max-height="48" class="text-start pt-0">
                                            <v-card-title class="text-subtitle-2 text-start  pa-0"
                                                style="font-family: 'Roboto', sans-serif !important;">
                                                Bairro
                                            </v-card-title>
                                            <v-card-text class="text-caption pa-0">
                                                {{ $page.props.user.data.bairro }}
                                            </v-card-text>
                                        </v-col>
                                    </v-col>
                                </v-row>


                            </v-row>


                        </v-card>
                        <v-card class="h-100 pa-8" id="card2"
                            :style="`height: calc(${cardH}px - 79px ) !important; z-index: 2; padding-left: 350px !important; font-weight: 600 !important;`">
                            <v-row justify="cennter" class="h-100">
                                <v-col cols="2">
                                    <v-card class="w-100 h-100 " color="#06bba5" style="z-index: 3;">
                                        <v-card-tiltle class="pa-3 text-h5">
                                            Emissões
                                        </v-card-tiltle>
                                    </v-card>
                                </v-col>
                                <v-col cols="7">
                                    <v-card class="w-100 h-100" color="#1a7b70" style="z-index: 3;">
                                        <v-card-tiltle class="pa-3 text-h5 ">
                                            Emissões neste mês
                                        </v-card-tiltle>
                                    </v-card>
                                </v-col>
                                <v-col cols="3">
                                    <v-card class="w-100 h-100" color="#06bba5" style="z-index: 3;">
                                        <v-card-tiltle class="pa-3 text-h5">
                                            Emissões
                                        </v-card-tiltle>
                                    </v-card>
                                </v-col>
                                <v-col cols="6">
                                    <v-card class="w-100 h-100" color="#1a7b70" style="z-index: 3;">
                                        <v-card-tiltle class="pa-3 text-h5 ">
                                            Emissões neste mês
                                        </v-card-tiltle>
                                    </v-card>
                                </v-col>
                                <v-col cols="6">
                                    <v-card class="w-100 h-100" color="#1a7b70" style="z-index: 3;">
                                        <v-card-tiltle class="pa-3 text-h5 ">
                                            Emissões neste mês
                                        </v-card-tiltle>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-card>
                    </section>
                </div>

            </section>

        </v-responsive>
    </Layout>
</template>
<script>
import Layout from '../Layout/Layout.vue';


export default {
    components: {
        Layout
    },
    data: () => ({
        cardH: null,
    }),
    mounted() {
        this.cardH = document.getElementById('card1').clientHeight

    }
}

</script>
<style scoped>
.body{
    
}
</style>
