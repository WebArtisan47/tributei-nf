<template >
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
                    <p v-if="simulacao != null" class="ml-4 font-weight-medium"
                        style="font-family: 'Roboto', sans-serif; font-size: 17px;">Simulação
                        escolhida: <span class="font-weight-light">{{ simulacao.id }}</span></p>
                    <div class="w-75 ml-3">
                        <v-select label="Simulações" v-model="simulacao" :items="gerarOpcoesPedidos" item-title="text"
                            item-value="value" :hint="`Pedido: ${simulacao === null ? '' : simulacao.id}`" persistent-hint
                            variant="outlined"></v-select>
                    </div>
                    <!-- <v-divider></v-divider> -->
                    <!-- <div v-if="AltProdutos === false">
                        <div v-show="prod && prod.length > 0">
                            <p class="text-h6 pl-5">Produtos Selecionados: </p>
                            <div class="pl-4">
                                <v-chip v-for="produto in prod" color="green">
                                    {{ produto.produto.nome_produto }}
                                </v-chip>
                            </div>

                        </div>
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
                                <v-select label="Produtos" chips v-model="prod" :items="gerarOpcoesProdutos"
                                    item-title="text" item-value="value" hint="Selecione os produtos" multiple
                                    persistent-hint variant="outlined"></v-select>
                            </div>
                        </section>
                        <v-btn class="text-white ml-3" color="red" @click="AltProdutos = false">Fechar</v-btn>
                    </div> -->

                </div>
            </v-card>


        </template>
        <template v-slot:item.2>
            <section style="max-height: 350px !important; overflow-y: auto;">
                <div class="pa-3 w-100">
                    <section class="d-flex">
                        <div class="w-100">
                            <v-row>
                                <v-col cols="6" class="">
                                    <Cfop v-model="cfop" />
                                </v-col>
                                <v-col cols="6" class="">
                                    <v-text-field label="Natureza da operação" v-model="natureza_operacao"
                                        variant="outlined"></v-text-field>
                                </v-col>
                                <v-col cols="6" v-for="produto in produtos">
                                    <v-card-subtile>{{ produto.produto.nome_produto }}</v-card-subtile>
                                    <v-text-field @input="event => produto.codigo_produto = event.target.value"
                                        :key="produto.id" label="Codigo do produto" variant="outlined"></v-text-field>
                                </v-col>
                            </v-row>
                        </div>
                    </section>
                </div>
                <v-divider></v-divider>
                <section class="">
                    <div v-if="AltValor === false">
                        <v-card-title>
                            Deseja alterar o preço de venda?
                            <v-card-subtitle class="pa-0">
                                Se não, avance
                            </v-card-subtitle>
                        </v-card-title>
                        <p class="ml-4 font-weight-bold" style="font-family: 'Roboto', sans-serif; font-size: 17px;">Valor
                            Atual: <span class="font-weight-light">{{ PrecoVenda }}</span></p>
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




            </section>

        </template>

        <template v-slot:item.3>
            <v-card class="pa-5 text-center">
                <div v-show="download" class="w-100 h-100"
                    style="z-index: 4; position: absolute; text-align: center; display: flex; align-items: center; backdrop-filter: blur(2px); background: #fff0; justify-content: center;">
                    <v-progress-circular :size="70" :width="7" color="green" indeterminate></v-progress-circular>
                </div>
                <v-card-title>
                    <h3 class="text-h5">Emissão NFe</h3>
                </v-card-title>
                <section class="d-flex justify-content-center flex-wrap w-100 my-8">
                    <div class="">
                        <div>
                            <v-btn append-icon="mdi-receipt-text-plus" size="large"
                                :color="download === true ? 'green' : '#02a996f4'" @click="Emitir" class="ml-2 text-white">
                                Emitir
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
import Cfop from './Cfop.vue';
import axios from 'axios';

export default {
    props: {
        pedidos: Array,
    },
    components: {
        VStepper,
        Cfop
    },
    data() {
        return {
            http: axios.create({
                headers: { 'Authorization': 'Bearer YDWauEpovnjBQ-YDVPOPAh4ta.E-YDhdCjkazwv6A' }
            }),
            load: false,
            prod: null,
            produtos: null,
            todos: false,
            AltProdutos: false,
            codigo: null,
            complementares: false,
            download: false,
            simulacao: null,
            cfop: null,
            AltValor: false,
            condicao: "",
            PrecoVenda: 0,
            natureza_operacao: null,
            Steps: [
                "Simulação do tributei",
                "Dados complementares",
                "Emissão"
            ]
        }
    },
    mounted() {
    },
    watch: {
        prod() {
            if (this.prod) {

                if (this.prod.length <= this.produtos.length) {

                    this.todos = false
                }
            }

        },
        todos() {
            if (this.todos === true) {
                this.prod = this.produtos
            }
        },
        simulacao() {
            this.load = true
            // this.produto = []
            this.PrecoVenda = this.formatReal(this.simulacao.total_pedido)
            // console.log(this.simulacao)
            this.http.get(`https://apisaidas.tributei.net/api/00104603000303/simulador/pedidos/produtos/${this.simulacao.id}`)
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
                value: pedido,
                text: `${pedido.cliente.nome} | ${pedido.cliente.estado} | Valor: ${this.formatReal(pedido.total_pedido)}`
            }));
        },
        gerarOpcoesProdutos() {
            let produtos = this.produtos.map(produtos => ({
                value: produtos,
                text: produtos.produto.nome_produto
            }))

            this.load = false
            return produtos
        }
    },

    methods: {
        Emitir() {
            this.download = true
            let simulacao = this.simulacao;
            let produtos = this.produtos;
            console.log({simulacao,
                "cfop": this.cfop,
                "user_id": this.$page.props.user.data.id,
                "natureza_operacao": this.natureza_operacao,
                "produtos": produtos})
            // this.http.post("http://127.0.0.1:8000/api/emitir-nfe", {
            //     simulacao,
            //     "cfop": this.cfop,
            //     "user_id": this.$page.props.user.id,
            //     "natureza_operacao": this.natureza_operacao,
            //     "produtos": produtos

            // }).then(response => {
            //     this.download = false
            //     location.reload();
            // }).catch(error => {
            //     console.error('Erro na requisição:', error);
            // });

        },
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