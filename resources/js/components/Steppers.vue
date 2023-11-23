<template>
    <v-stepper prev-text="voltar" next-text="proximo" alt-labels color="#00796B" :items="Steps">
        <template v-slot:item.1>


            <v-card flat class="my-4">
                <div v-show="load" class="w-100 h-100"
                    style="z-index: 4; position: absolute; text-align: center; display: flex; align-items: center; backdrop-filter: blur(2px); background: #fff0; justify-content: center;">
                    <v-progress-circular :size="70" :width="7" color="green" indeterminate></v-progress-circular>
                </div>

                <div style="z-index: 2;">
                    <v-card-title>
                        <h3 class="text-h5">Simulador de Pedidos</h3>
                        <v-card-subtitle class="pa-0">
                            Essa são simulações feitas no simulador de pedidos do tributei
                        </v-card-subtitle>
                    </v-card-title>
                    <p class="ml-4 font-weight-medium" style="font-family: 'Roboto', sans-serif; font-size: 17px;">Simulação
                        escolhida: <span class="font-weight-light">{{ simulacao }}</span></p>
                    <div class="w-75 ml-3">
                        <v-select label="Simulações" v-model="simulacao" :items="gerarOpcoesPedidos" item-title="text"
                            item-value="value" :hint="`Pedido: ${simulacao === null ? '' : simulacao}`" persistent-hint
                            variant="outlined"></v-select>
                    </div>
                    <v-divider></v-divider>
                    <div v-if="AltProdutos === false">
                        <v-card-title>
                            Selecionar produtos?
                        </v-card-title>
                        <v-btn class="text-white ml-3" color="#02a996f4" @click="todos = true">Todos</v-btn>
                        <v-btn class="text-white ml-3" color="#02a996f4" @click="AltProdutos = true">Escolher</v-btn>
                    </div>
                    <div v-else>
                        <v-card-title>
                            Selecione os produtos
                            <v-card-subtitle class="pa-0">
                                Selecione os produtos que seram lançados na nota fiscal
                            </v-card-subtitle>
                        </v-card-title>
                        <section class="px-3">
                            <div class="w-75 ml-3">
                                <v-select label="Produtos" chips v-model="produto" :items="gerarOpcoesProdutos"
                                    item-title="text" item-value="value" hint="Selecione os produtos" multiple
                                    persistent-hint variant="outlined"></v-select>
                            </div>
                        </section>
                        <v-btn class="text-white ml-3" color="red" @click="AltProdutos = false">Fechar</v-btn>
                    </div>

                </div>
            </v-card>


        </template>
        <template v-slot:item.2>

            <section class="">
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


            <v-divider></v-divider>
            <v-card flat>
                <section>
                    <div v-if="complementares === false">
                        <v-card-title>
                            Deseja adicionar dados complementares?
                            <v-card-subtitle class="pa-0">
                                Se não, avance
                            </v-card-subtitle>
                        </v-card-title>
                        <p class="ml-4 font-weight-medium" style="font-family: 'Roboto', sans-serif; font-size: 17px;">
                            Exemplos: <v-card-subtitle class="font-weight-light pa-0">Marca, Produção, Altura,
                                Largura...</v-card-subtitle></p>
                        <v-btn class="text-white ml-3" color="#02a996f4" @click="complementares = true">Sim</v-btn>
                    </div>
                    <div v-else>
                        <v-card-title>
                            <v-text-field label="Marca" variant="outlined"></v-text-field>
                            <v-text-field label="Produção" variant="outlined"></v-text-field>
                            <v-text-field label="Altura" variant="outlined"></v-text-field>
                            <v-text-field label="Largura" variant="outlined"></v-text-field>
                        </v-card-title>
                        <section class="w-50 px-3">
                            <v-btn class="text-white ml-3" color="red" @click="complementares = false">Fechar</v-btn>
                        </section>

                    </div>

                </section>
            </v-card>
        </template>

        <template v-slot:item.3>
            <v-card class="pa-5 text-center">
                <v-card-title>
                    <h3 class="text-h5">Emitir NFe</h3>
                </v-card-title>
                <section class="d-flex justify-content-center flex-wrap w-100 my-8">
                    <div class="">
                        <div>
                            <v-btn append-icon="mdi-progress-download" size="large"
                                :color="download === true ? 'green' : '#02a996f4'" @click="download = true"
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
import axios from 'axios';

export default {
    props: {
        pedidos: Array,
    },
    components: {
        VStepper,
    },
    data() {
        return {
            http: axios.create({
                headers: { 'Authorization': 'Bearer YDmFIAkdQ4wm6-YDJZVb4pKo9Fk-YDWfuJEVPI.Zc' }
            }),
            load: false,
            produto: [],
            produtos: [],
            AltProdutos: false,
            complementares: false,
            download: false,
            simulacao: null,
            AltValor: false,
            condicao: "",
            PrecoVenda: 300,
            Steps: [
                "Simulação do tributei",
                "Dados complementares",
                "Emissão"
            ]
        }
    },
    watch: {
        simulacao() {
            this.load = true
            this.produto = []

            this.http.get(`https://apisaidas.tributei.net/api/05995840000155/simulador/pedidos/produtos/${this.simulacao}`)
                .then(response => {
                    // Acesse os dados da resposta aqui
                    this.produtos = response.data.data; // Ou ajuste conforme a estrutura da resposta
                    this.gerarOpcoesProdutos
                })
                .catch(error => {
                    console.error('Erro na requisição:', error);
                });
        }

    },
    computed: {
        gerarOpcoesPedidos() {
            return this.pedidos.map(pedido => ({
                value: pedido.id,
                text: `${pedido.cliente.nome} | ${pedido.cliente.estado} | Valor: ${this.formatReal(pedido.total_pedido)}`
            }));
        },
        gerarOpcoesProdutos() {
            let produtos = this.produtos.map(produtos => ({
                value: produtos.id,
                text: produtos.produto.nome_produto
            }))
            this.load = false
            return produtos
        }
    },

    methods: {

        formatReal(valor) {
            if (typeof valor !== 'number') {
                return 'Valor inválido';
            }

            // Formata o número como moeda brasileira (Real)
            const formatoReal = {
                style: 'currency',
                currency: 'BRL',
            };
            return valor.toLocaleString('pt-BR', formatoReal);
        }

    }


}
</script>

<style></style>