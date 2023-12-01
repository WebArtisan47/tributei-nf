<template>
    <layout-authenticated>

        <section class="my-1 w-100 h-100">

            <div class="text-start mx-8 mt-16">
                <v-row justify="start">
                    <v-col cols="auto">
                        <section class="d-flex">
                            <v-row justify="center">
                                <v-col cols="6">
                                    <v-dialog v-model="dialog" width="1024">
                                        <template v-slot:activator="{ props }">
                                            <v-btn block elevated v-bind="props" color="#03a996"
                                                append-icon="mdi-file-document-arrow-right-outline" size="large"
                                                style="text-transform: capitalize;">Emissão</v-btn>
                                        </template>
                                        <div class="w-100 d-flex flex-column "
                                            style="background-color: transparent; border: none;">
                                            <v-btn icon="mdi-close" color="white" class="ml-auto" @click="dialog = !dialog"
                                                variant="text">
                                            </v-btn>
                                            <steppers :pedidos="pedidos" />
                                        </div>

                                    </v-dialog>
                                </v-col>
                                <v-col cols="6">
                                    <v-dialog fullscreen :scrim="false" v-model="tributei"
                                        transition="dialog-bottom-transition">
                                        <template v-slot:activator="{ props }">
                                            <v-btn block elevated color="#00a540" v-bind="props" size="large"
                                                style="text-transform: capitalize;">
                                                <v-tooltip activator="parent" color="white" location="top">Simulador
                                                    pedidos</v-tooltip>
                                                <v-avatar style="width: 90px !important;" rounded="0">
                                                    <v-img src="img/tributei.png"></v-img>
                                                </v-avatar></v-btn>

                                        </template>
                                        <v-card color="#f7f7f7">

                                            <v-toolbar dark color="#0a4">

                                                <v-toolbar-title> <v-avatar style="width: 90px !important;" rounded="0">
                                                        <v-img src="img/tributei.png"></v-img>
                                                    </v-avatar></v-toolbar-title>
                                                <v-spacer></v-spacer>

                                                <v-btn icon dark @click="tributei = !tributei">
                                                    <v-icon>mdi-close</v-icon>
                                                </v-btn>

                                            </v-toolbar>
                                            <section class="px-7 mt-3">
                                                <div v-show="cadastrando" class="w-100 h-100"
                                                    style="z-index: 4; position: absolute; text-align: center; display: flex; align-items: center; backdrop-filter: blur(2px); background: #fff0; justify-content: center;">
                                                    <v-progress-circular :size="70" :width="7" color="green"
                                                        indeterminate></v-progress-circular>
                                                </div>
                                                <div class="w-100 h-100 pb-5" v-show="produtoCadastrado"
                                                    style="z-index: 4; position: absolute; text-align: center; display: flex; align-items: center; backdrop-filter: blur(2px); background: #fff0; justify-content: center;">
                                                    <v-card class="mx-auto w-25 pa-4">
                                                        <v-icon color="success" icon="mdi-check-circle"
                                                            size="200px"></v-icon>
                                                        <v-toolbar color="transparent" class="text-center">
                                                            <v-toolbar-title class="text-h5">
                                                                Pedido cadastrado!
                                                            </v-toolbar-title>
                                                        </v-toolbar>
                                                        <div class="d-flex w-100 mx-auto justify-space-around">
                                                            <v-btn color="#00a540" @click="produtoCadastrado = false">
                                                                Simular pedidos
                                                            </v-btn>
                                                            <v-btn color="#00796b"
                                                                @click="produtoCadastrado = false, tributei = false, dialog = true">
                                                                Emitir Nota
                                                            </v-btn>
                                                        </div>
                                                    </v-card>
                                                </div>
                                                <v-card-title class="title-tributei px-0" style="font-size: 24px;">
                                                    Pedido de venda | Novo pedido
                                                </v-card-title>
                                                <v-row>
                                                    <v-col cols="12" class="">
                                                        <v-card>
                                                            <v-card-title class="ml-4 my-7 tributei-title"
                                                                style="font-size: 28px;">
                                                                Cenário de Simulação
                                                            </v-card-title>

                                                            <v-divider class="mx-7"></v-divider>
                                                            <v-row class="mx-5 mt-6 mb-4">
                                                                <v-col cols="6">
                                                                    <label class="my-2">
                                                                        Cliente
                                                                    </label>
                                                                    <v-select v-model="cliente"
                                                                        placeholder="Selecione uma cliente"
                                                                        density="compact" :items="getTributei"
                                                                        item-title="text" item-value="value"
                                                                        variant="outlined"></v-select>
                                                                </v-col>
                                                                <v-col cols="6">
                                                                    <label for="">
                                                                        Tipo de operação
                                                                    </label>
                                                                    <section>
                                                                        <div class="my-4">
                                                                            <v-btn icon="" flat
                                                                                :color="tipo === true ? '#0a4' : '#999'"
                                                                                class="mx-2"
                                                                                @click="tipo = true, tipoCalculo = 'DIFAL'"
                                                                                size="25px"
                                                                                :style="tipo === true ? 'border: 1px solid #0a4;' : 'border: 1px solid #999;'" />
                                                                            <span>Uso, consumo ou ativo imobilizado</span>
                                                                        </div>
                                                                        <div>
                                                                            <v-btn icon=""
                                                                                @click="tipo = false, tipoCalculo = 'ICMS'"
                                                                                :color="tipo === false ? '#0a4' : '#999'"
                                                                                class="mx-2" size="25px"
                                                                                :style="tipo === false ? 'border: 1px solid #0a4;' : 'border: 1px solid #999;'" />
                                                                            <span class="">Revenda</span>
                                                                        </div>
                                                                    </section>
                                                                </v-col>
                                                            </v-row>
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                                <v-row v-show="cliente != null">
                                                    <v-col cols="12" class="">
                                                        <v-card>
                                                            <v-card-title class="ml-4 my-7 tributei-title"
                                                                style="font-size: 28px;">
                                                                Produto
                                                            </v-card-title>

                                                            <v-divider class="mx-7"></v-divider>
                                                            <v-row class="mx-5 mt-6 mb-4">
                                                                <v-col cols="6">
                                                                    <label class="my-2">
                                                                        Produtos
                                                                    </label>
                                                                    <v-select placeholder="Selecione um produto"
                                                                        v-model="produto" density="compact"
                                                                        item-value="value" variant="outlined"
                                                                        :items="getProduto"
                                                                        :item-props="produtoProps"></v-select>
                                                                </v-col>
                                                                <v-col cols="2">
                                                                    <label class="my-2" for="">
                                                                        Quantidade
                                                                    </label>
                                                                    <section>
                                                                        <v-text-field density="compact" v-model="quantidade"
                                                                            placeholder="0"
                                                                            variant="outlined"></v-text-field>
                                                                    </section>
                                                                </v-col>
                                                                <v-col cols="2">
                                                                    <label class="my-2" for="">
                                                                        Custo Unitário
                                                                    </label>
                                                                    <section>
                                                                        <v-text-field density="compact" v-model="vUnit"
                                                                            placeholder="0,00"
                                                                            @input="formatarValor('vUnit')"
                                                                            variant="outlined"></v-text-field>
                                                                    </section>
                                                                </v-col>
                                                                <v-col cols="2">
                                                                    <label class="my-2" for="">
                                                                        Desconto incondicional
                                                                    </label>
                                                                    <section>
                                                                        <v-text-field density="compact" v-model="vDescIC"
                                                                            placeholder="0,00"
                                                                            @input="formatarValor('vDescIC')"
                                                                            variant="outlined"></v-text-field>
                                                                    </section>
                                                                </v-col>
                                                                <v-col cols="2">
                                                                    <label class="my-2" for="">
                                                                        Desconto condicional
                                                                    </label>
                                                                    <section>
                                                                        <v-text-field density="compact" v-model="vDescC"
                                                                            placeholder="0,00"
                                                                            @input="formatarValor('vDescC')"
                                                                            variant="outlined"></v-text-field>
                                                                    </section>
                                                                </v-col>
                                                                <v-col cols="2">
                                                                    <label class="my-2" for="">
                                                                        ICMS desonerado
                                                                    </label>
                                                                    <section>
                                                                        <v-text-field density="compact" v-model="vICMS"
                                                                            placeholder="0,00"
                                                                            @input="formatarValor('vICMS')"
                                                                            variant="outlined"></v-text-field>
                                                                    </section>
                                                                </v-col>
                                                                <v-col cols="2">
                                                                    <label class="my-2" for="">
                                                                        Outras Despesas
                                                                    </label>
                                                                    <section>
                                                                        <v-text-field density="compact" v-model="cOutro"
                                                                            placeholder="0,00"
                                                                            variant="outlined"></v-text-field>
                                                                    </section>
                                                                </v-col>
                                                                <v-col cols="2">
                                                                    <label class="my-2" for="">
                                                                        IPI
                                                                    </label>
                                                                    <section>
                                                                        <v-text-field density="compact" v-model="ipi"
                                                                            placeholder="0,00"
                                                                            variant="outlined"></v-text-field>
                                                                    </section>
                                                                </v-col>
                                                                <v-col cols="2">
                                                                    <label class="my-2" for="">
                                                                        Seguro
                                                                    </label>
                                                                    <section>
                                                                        <v-text-field density="compact" v-model="vSeg"
                                                                            placeholder="0,00"
                                                                            variant="outlined"></v-text-field>
                                                                    </section>
                                                                </v-col>
                                                                <v-col cols="2">
                                                                    <label class="my-2" for="">
                                                                        Frete
                                                                    </label>
                                                                    <section>
                                                                        <v-text-field density="compact" v-model="vFrete"
                                                                            placeholder="0,00"
                                                                            variant="outlined"></v-text-field>
                                                                    </section>
                                                                </v-col>
                                                                <v-col cols="6">
                                                                    <v-btn prepend-icon="mdi-plus"
                                                                        @click="simuladorTributei" color="#0a4" size="large"
                                                                        style="box-shadow: 0 8px 25px -8px #0a4;">Adicionar
                                                                        produto ao pedido</v-btn>
                                                                </v-col>
                                                            </v-row>
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                            </section>
                                        </v-card>
                                    </v-dialog>
                                </v-col>

                            </v-row>
                        </section>

                    </v-col>
                    <v-col cols="12">
                        <v-card class="w-100 ">
                            <div class="bg-blue-grey-lighten-2"
                                style="border: 1px solid; border-top-right-radius: 8px; border-top-left-radius: 8px;">
                                <v-card-title style="font-family: 'Roboto', sans-serif; font-size: 18px;">
                                    <v-icon icon="mdi-table"></v-icon>&nbspLista de NF emitidas
                                </v-card-title>
                            </div>
                            <section class="px-5 py-3">
                                <v-row>
                                    <v-col cols="9">
                                        <div class="d-flex align-center">
                                            <span class="mb-4 ml-1 mr-2"
                                                style="font-family: 'Roboto', sans-serif; font-size: 18px;">ítens por
                                                pág</span>
                                            <v-select class="w-25" style="max-width: 80px !important;" v-model="select"
                                                :items="num" variant="outlined"></v-select>
                                        </div>

                                    </v-col>
                                    <v-col cols="3">
                                        <v-text-field variant="outlined" placeholder="Pesquisar"></v-text-field>
                                    </v-col>
                                </v-row>

                            </section>
                            <section class="px-3 h-50">
                                <v-table fixed-header class="tabela">
                                    <thead>
                                        <tr class="text-uppercase">
                                            <th class="text-center">
                                                Empresa
                                            </th>
                                            <th class="text-center">
                                                Fornecedor
                                            </th>
                                            <th class="text-center">
                                                Valor da NFe
                                            </th>
                                            <th class="text-center">
                                                Pedido
                                            </th>
                                            <th class="text-center">
                                                Status
                                            </th>
                                            <th class="text-center" style="max-width: 90px;">
                                                DOWNLOAD NFe
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in filteredItems" :key="item.name">
                                            <td class="text-center">{{ item.empresa }}</td>
                                            <td class="text-center">{{ item.fornecedores }}</td>
                                            <td class="text-center">{{ item.valorNFe }}</td>
                                            <td class="text-center">{{ item.pedido }}</td>
                                            <td class="text-center">
                                                <v-tooltip :text="item.error" v-if="item.color === 'red'" location="top">
                                                    <template v-slot:activator="{ props }">
                                                        <v-chip class="ma-2 text-white" v-bind="props" :color="item.color">
                                                            {{ item.status }}
                                                        </v-chip>
                                                    </template>
                                                </v-tooltip>
                                                <v-chip v-else class="ma-2 text-white" :color="item.color">
                                                    {{ item.status }}
                                                </v-chip>
                                            </td>
                                            <td class="text-center">
                                                <v-icon icon="mdi-progress-download"></v-icon>
                                            </td>
                                        </tr>
                                    </tbody>
                                </v-table>

                            </section>
                            <section class="h-25">
                                <v-pagination v-model="page" :length="2" rounded="circle"></v-pagination>
                            </section>
                        </v-card>
                    </v-col>
                </v-row>
            </div>


        </section>
    </layout-authenticated>
</template>
<style scoped>
label {
    color: #111827 !important;
    font-size: 18px !important;
    font-weight: 600;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.title-tributei {
    color: #111827;
    font-weight: 500 !important;
    font-size: 1.4rem;
    line-height: 1.2;
    margin-bottom: 0.5rem;
    margin-top: 0;
    font-family: inherit;
}

.card {
    background-color: #283043;

}

.tabela::-webkit-scrollbar {
    width: 8px;
}

.tabela::-webkit-scrollbar-track {
    background: #00796B;
    /* color of the tracking area */
}

.tabela::-webkit-scrollbar-thumb {
    background-color: rgb(252, 252, 255);
    /* color of the scroll thumb */
    border-radius: 20px;
    /* roundness of the scroll thumb */
    border: 3px solid #00796B;
    /* creates padding around scroll thumb */
}
</style>
<script>
import axios from 'axios'
import LayoutAuthenticated from '../Layout/LayoutAuthenticated.vue'
import Steppers from '../components/Steppers.vue'


export default {
    components: {
        LayoutAuthenticated,
        Steppers
    },
    data() {
        return {
            http: axios.create({
                headers: { 'Authorization': 'Bearer YDWauEpovnjBQ-YDVPOPAh4ta.E-YDhdCjkazwv6A' }
            }),
            cadastrando: false,
            tipo: null,
            tributei: false,
            dialog: false,
            select: 5,
            quantidade: 0,
            cliente: null,
            num: [],
            limit: 5,
            page: 1,
            clientes: [],
            produtos: [],
            produto: null,
            pedidos: this.$page.props.pedidos.data ?? null,
            cliente_id: "",
            produtoCadastrado: false,
            tipoCalculo: "DIFAL",
            ipi: "",
            cOutro: "",
            pedido_id: null,
            produto_id: "",
            quantidade: "",
            vDescC: "",
            vDescIC: "",
            vFrete: "",
            vICMS: "",
            vSeg: "",
            vUnit: "",
            items: [
                {
                    empresa: 'Tiger LTDA',
                    fornecedores: 'System Innovation',
                    valorNFe: 'R$ 3.000',
                    pedido: '45',
                    color: 'orange',
                    status: 'Aguardando retorno',
                    link: 'https://example1.com'
                },
                {
                    empresa: 'Phoenix Corp',
                    fornecedores: 'Tech Solutions',
                    valorNFe: 'R$ 5.500',
                    pedido: '72',
                    color: 'green',
                    status: 'Emitido',
                    link: 'https://example2.com'
                },
                {
                    empresa: 'Skyline Enterprises',
                    fornecedores: 'Innovate Tech',
                    valorNFe: 'R$ 2.200',
                    pedido: '28',
                    color: 'red',
                    status: 'Falha na emissão',
                    error: 'NFe foi cancelada',
                    link: 'https://example3.com'
                },
                {
                    empresa: 'Green Systems',
                    fornecedores: 'Data Experts',
                    valorNFe: 'R$ 1.800',
                    pedido: '15',
                    color: 'orange',
                    status: 'Aguardando retorno',
                    link: 'https://example4.com'
                },
                {
                    empresa: 'Tech Innovators',
                    fornecedores: 'Future Solutions',
                    valorNFe: 'R$ 4.750',
                    pedido: '51',
                    color: 'green',
                    status: 'Emitido',
                    link: 'https://example5.com'
                }
            ],
        }
    },
    watch: {
        select() {
            if (this.select === 4) {
                this.quantidade = 1
            } else if (this.select === 3) {
                this.quantidade = 2

            } else if (this.select === 2) {
                this.quantidade = 3

            } else if (this.select === 1) {
                this.quantidade = 4
            } else {
                this.quantidade = 0
            }
        },


    },
    computed: {
        filteredItems() {
            return this.items.slice(this.quantidade, this.limit);
        },
        getTributei() {
            let data = this.$page.props.clientes.data
            return data.map(cliente => ({
                value: cliente,
                text: `${cliente.nome} | ${cliente.estado}`
            }));

        },
        getProduto() {
            return this.$page.props.produtos.map(produto => ({
                value: produto,
                descricao: produto.descricao,
                ncm: produto.ncm,
                cest: produto.cest
            }))

        },
    },
    mounted() {
        console.log(this.$page.props.user)
        // this.getTributei()
        // console.log(this.$page.props.clientes.map(item => item.data));
        for (let i = 1; i <= 5; i++) {
            this.num.push(i);

        }

    },
    methods: {
        formatarValor(campo) {
            // // Remove caracteres não numéricos, exceto ponto e vírgula
            // this[campo] = this[campo].replace(/[^0-9,.]/g, '');

            // // Adiciona vírgula antes dos dois últimos dígitos, garantindo que haja pelo menos um dígito antes
            // this[campo] = this[campo].replace(/^(\d*)(\d{2})$/, '$1,$2');
            // console.log(this[campo])
        },

        produtoProps(produto) {
            return {
                title: produto.descricao,
                subtitle: "NCM " + produto.ncm + " | " + "CEST " + produto.cest,
            }
        },
        simuladorTributei() {
            this.cadastrando = true;
            this.cliente_id = this.cliente.id;
            this.produto_id = this.produto.id;
            if (this.cliente_id, this.produto_id, this.quantidade, this.vDescIC, this.vUnit) {
                this.http.post('https://apisaidas.tributei.net/api/05995840000155/simulador/pedidos', {
                    cliente_id: this.cliente_id,
                    tipoCalculo: this.tipoCalculo
                })
                    .then(response => {
                        this.http.post('https://apisaidas.tributei.net/api/05995840000155/simulador/pedidos/produtos', {
                            IPI: this.ipi,
                            cOutro: this.cOutro,
                            pedido_id: response.data.id,
                            produto_id: this.produto_id,
                            quantidade: this.quantidade,
                            vDescC: this.vDescC,
                            vDescIC: this.vDescIC,
                            vFrete: this.vFrete,
                            vICMS: this.vICMS,
                            vSeg: this.vSeg,
                            vUnit: this.vUnit
                        }).then(response => {
                            if (response.status === 201) {
                                this.cadastrando = false;
                                this.produtoCadastrado = true;

                            }
                        }).catch(error => {
                            console.error('Erro na requisição:', error);
                        });
                    }).catch(error => {
                        console.error('Erro na requisição:', error);
                    });
            }

        }
    }
}
</script>