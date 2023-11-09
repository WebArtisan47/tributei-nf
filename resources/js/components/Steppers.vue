<template>
    <v-stepper prev-text="voltar" next-text="proximo" alt-labels color="#00796B" :items="Steps">
        <template v-slot:item.1>
            <v-card flat>
                <div>
                    <v-card-title>
                        <h3 class="text-h5">Simulador de Pedidos</h3>
                        <v-card-subtitle class="pa-0">
                            Essa são simulações feitas no simulador de pedidos do tributei
                        </v-card-subtitle>
                    </v-card-title>
                    <p class="ml-4 font-weight-medium" style="font-family: 'Roboto', sans-serif; font-size: 17px;">Simulação
                        escolhida: <span class="font-weight-light">{{ simulacao }}</span></p>
                    <div class="w-75 ml-3">
                        <v-select label="Simulações" v-model="simulacao" :items="pedidos.map(pedido => pedido.name)"
                            hint="Selecione uma Simulação" persistent-hint variant="outlined"></v-select>
                    </div>

                </div>
            </v-card>
        </template>
        <template v-slot:item.2>
            <v-card class="pa-5">
                <v-card-title>
                    <h3 class="text-h5">Condição do produto</h3>
                    <v-card-subtitle class="pa-0">
                        Informe se o prodto é novo ou usado.
                    </v-card-subtitle>
                </v-card-title>
                <section class="d-flex flex-wrap w-50 my-8">
                    <div class="justify-space-around align-center w-50  d-flex">
                        <div>
                        <v-icon v-show="condicao === 'novo'" color="success" icon="mdi-check-circle" size="large"></v-icon>
                        <v-btn :color="condicao === 'novo' ? 'green' : '#02a996f4'" @click="condicao = 'novo'"
                            class="ml-2 text-white">
                            Novo
                        </v-btn>
                    </div>
                    <div>
                        <v-btn class="text-white mr-2" @click="condicao = 'usado'"
                            :color="condicao === 'usado' ? 'green' : '#02a996f4'">Usado</v-btn>
                        <v-icon v-show="condicao === 'usado'" color="success" icon="mdi-check-circle" size="large"></v-icon>
                    </div>
                    </div>
                  

                </section>

            </v-card>
            <v-card title="" subtitle="">
                <section class="ml-5">
                    <div v-if="AltValor === false">
                        <v-card-title>
                            Deseja alterar o preço de venda?
                            <v-card-subtitle class="pa-0">
                                Se não, avance
                            </v-card-subtitle>
                        </v-card-title>
                        <p class="ml-4 font-weight-bold" style="font-family: 'Roboto', sans-serif; font-size: 17px;">Valor
                            Atual: <span class="font-weight-light">R$ {{ PrecoVenda }},00</span></p>
                        <v-btn class="text-white ml-3" color="#02a996f4" @click="AltValor = true">Sim</v-btn>
                    </div>
                    <div v-else>
                        <v-card-title>
                            Alterar preço de venda
                            <v-card-subtitle class="pa-0">
                                Isso irá alterar o preço da venda do produto na NFe
                            </v-card-subtitle>
                        </v-card-title>
                        <section class="w-50 px-3">
                            <v-text-field clearable variant="outlined" label="Valor" v-model="PrecoVenda"></v-text-field>
                        </section>
                        <v-btn class="text-white ml-3" color="red" @click="AltValor = false">Fechar</v-btn>
                    </div>

                </section>

            </v-card>
        </template>

        <template v-slot:item.3>
            <v-card  flat>
                <section>
                    <div v-if="complementares === false">
                        <v-card-title>
                            Deseja adicionar dados complementares?
                            <v-card-subtitle class="pa-0">
                                Se não, avance
                            </v-card-subtitle>
                        </v-card-title>
                        <p class="ml-4 font-weight-medium" style="font-family: 'Roboto', sans-serif; font-size: 17px;">Exemplos: <v-card-subtitle  class="font-weight-light pa-0">Marca, Produção, Altura, Largura...</v-card-subtitle></p>
                        <v-btn class="text-white ml-3" color="#02a996f4" @click="complementares = true">Sim</v-btn>
                    </div>
                    <div v-else>
                        <v-card-title>
                            Adicionar dados complementares
                        </v-card-title>
                        <section class="w-50 px-3">
                            <v-btn class="text-white ml-3" color="red" @click="complementares = false">Fechar</v-btn>
                        </section>

                    </div>

                </section>
            </v-card>
        </template>

        <template v-slot:item.4>
            <v-card class="pa-5 text-center">
                <v-card-title>
                    <h3 class="text-h5">Emitir NFe</h3>
                </v-card-title>
                <section class="d-flex justify-content-center flex-wrap w-100 my-8">
                    <div class="">
                        <div>
                        <v-btn append-icon="mdi-progress-download" size="large" :color="download === true ? 'green' : '#02a996f4'" @click="download = true"
                            class="ml-2 text-white">
                            DOWNLOAD NFe
                        </v-btn>
                    </div>
                    
                    </div>
                </section>

            </v-card>
        </template>
    </v-stepper>
</template>
<style scoped>
.title-card {
    font-family: inherit;
    font-size: 25px;

}
</style>
<script>
import { VStepper } from 'vuetify/labs/VStepper'
export default {
    components: {
        VStepper,
    },
    data() {
        return {
            pedidos: [
                {
                    pedido: 132,
                    cliente: "JENNIFER MARCAL DOS SANTOS 05681000184",
                    produto: 'SOFA',
                    name: "SOFA | JENNIFER MARCAL DOS SANTOS 05681000184",
                }
            ],
            complementares: false,
            download: false,
            simulacao: null,
            AltValor: false,
            condicao: "",
            PrecoVenda: 300,
            Steps: [
                "Simulação do tributei",
                "Dados Basicos do produto",
                "Dados complementares",
                "Emissão"
            ]
        }
    },


}
</script>

<style></style>