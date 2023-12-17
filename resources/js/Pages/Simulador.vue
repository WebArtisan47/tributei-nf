<template>
    <section class="my-1 w-100 h-screen">
        <div class="overflow-y-auto" style="height: 90% !important;">
            <section class="px-7 mt-3">
                <div v-show="cadastrando" class="w-100 h-100"
                    style="z-index: 4; position: absolute; text-align: center; display: flex; align-items: center; backdrop-filter: blur(2px); background: #fff0; justify-content: center;">
                    <v-progress-circular :size="70" :width="7" color="green" indeterminate></v-progress-circular>
                </div>
                <div class="w-100 h-100 pb-5" v-show="produtoCadastrado"
                    style="z-index: 4; position: absolute; text-align: center; display: flex; align-items: center; backdrop-filter: blur(2px); background: #fff0; justify-content: center;">
                    <v-card class="mx-auto w-25 pa-4">
                        <v-icon color="success" icon="mdi-check-circle" size="200px"></v-icon>
                        <v-toolbar color="transparent" class="text-center">
                            <v-toolbar-title class="text-h5">
                                Pedido cadastrado!
                            </v-toolbar-title>
                        </v-toolbar>
                        <div class="d-flex w-100 mx-auto justify-space-around">
                            <v-btn color="#00a540" @click="produtoCadastrado = false">
                                Simular pedidos
                            </v-btn>
                            <v-btn color="#00796b" @click="Location.reload()">
                                Emitir Nota
                            </v-btn>
                           
                        </div>
                        <v-btn color="#00796b" class="mt-3" @click="produtoCadastrado = false, addProd = true">
                                Adiconar produtos na simulação
                            </v-btn>
                    </v-card>
                </div>
                <v-card-title class="title-tributei px-0" style="font-size: 24px;">
                    {{ addProd ? `Pedido de venda | pedido ${pedido_id}` : 'Pedido de venda | Novo pedido' }}
                </v-card-title>
                <v-row>
                    <v-col :cols="addProd ? 8 : 12">
                        <v-row>
                            <v-col cols="12" class="">
                                <v-card>
                                    <v-card-title class="ml-4 my-3 tributei-title" style="font-size: 21px;">
                                        Cenário de Simulação
                                    </v-card-title>

                                    <v-divider class="mx-7 my-2"></v-divider>
                                    <v-row class="mx-5 mt-2 mb-4">
                                        <v-col cols="6">
                                            <label class="my-1">
                                                Cliente
                                            </label>
                                            <v-select v-model="cliente" placeholder="Selecione uma cliente"
                                                :disabled="addProd" density="compact" :items="getTributei" item-title="text"
                                                item-value="value" variant="outlined"></v-select>
                                        </v-col>
                                        <v-col cols="6">
                                            <label for="">
                                                Tipo de operação
                                            </label>
                                            <section>
                                                <div class="my-3">
                                                    <v-btn icon="" flat :color="tipo === true ? '#0a4' : '#999'"
                                                        class="mx-2" @click="tipo = true, tipoCalculo = 'DIFAL'" size="25px"
                                                        :style="tipo === true ? 'border: 1px solid #0a4;' : 'border: 1px solid #999;'" />
                                                    <span>Uso, consumo ou ativo imobilizado</span>
                                                </div>
                                                <div>
                                                    <v-btn icon="" @click="tipo = false, tipoCalculo = 'ICMS'"
                                                        :color="tipo === false ? '#0a4' : '#999'" class="mx-2" size="25px"
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
                                    <v-card-title class="ml-4 mt-2 tributei-title" style="font-size: 21px;">
                                        Produto
                                    </v-card-title>

                                    <v-divider class="mx-7 my-2"></v-divider>
                                    <v-row class="mx-5 mt-0 mb-4">
                                        <v-col cols="6">
                                            <label class="my-2">
                                                Produtos
                                            </label>
                                            <v-select placeholder="Selecione um produto" v-model="produto" density="compact"
                                                item-value="value" variant="outlined" :items="getProduto"
                                                :item-props="produtoProps"></v-select>
                                        </v-col>
                                        <v-col cols="2">
                                            <label class="my-2" for="">
                                                Quantidade
                                            </label>
                                            <section>
                                                <v-text-field density="compact" v-model="quantidade" placeholder="0"
                                                    variant="outlined"></v-text-field>
                                            </section>
                                        </v-col>
                                        <v-col cols="2">
                                            <label class="my-2" for="">
                                                Custo Unitário
                                            </label>
                                            <section>
                                                <v-text-field density="compact" v-model="vUnit" placeholder="0,00"
                                                    @input="('vUnit')" variant="outlined"></v-text-field>
                                            </section>
                                        </v-col>
                                        <v-col :class="addProd ? 'pt-1' : null" cols="2">
                                            <label :class="addProd ? null : 'my-2'" for="">
                                                Desconto incondicional
                                            </label>
                                            <section>
                                                <v-text-field density="compact" v-model="vDescIC" placeholder="0,00"
                                                    @input="('vDescIC')" variant="outlined"></v-text-field>
                                            </section>
                                        </v-col>
                                        <v-col :class="addProd ? 'pt-1' : null" cols="2">
                                            <label :class="addProd ? null : 'my-2'" for="">
                                                Desconto condicional
                                            </label>
                                            <section>
                                                <v-text-field density="compact" v-model="vDescC" placeholder="0,00"
                                                    @input="('vDescC')" variant="outlined"></v-text-field>
                                            </section>
                                        </v-col>
                                        <v-col :class="addProd ? 'pt-1' : null" cols="2">
                                            <label :class="addProd ? null : 'my-2'" for="">
                                                ICMS desonerado
                                            </label>
                                            <section>
                                                <v-text-field density="compact" v-model="vICMS" placeholder="0,00"
                                                    @input="('vICMS')" variant="outlined"></v-text-field>
                                            </section>
                                        </v-col>
                                        <v-col cols="2">
                                            <label class="my-2" for="">
                                                Outras Despesas
                                            </label>
                                            <section>
                                                <v-text-field density="compact" v-model="cOutro" placeholder="0,00"
                                                    variant="outlined"></v-text-field>
                                            </section>
                                        </v-col>
                                        <v-col cols="2">
                                            <label class="my-2" for="">
                                                IPI
                                            </label>
                                            <section>
                                                <v-text-field density="compact" v-model="ipi" placeholder="0,00"
                                                    variant="outlined"></v-text-field>
                                            </section>
                                        </v-col>
                                        <v-col cols="2">
                                            <label class="my-2" for="">
                                                Seguro
                                            </label>
                                            <section>
                                                <v-text-field density="compact" v-model="vSeg" placeholder="0,00"
                                                    variant="outlined"></v-text-field>
                                            </section>
                                        </v-col>
                                        <v-col cols="2">
                                            <label class="my-2" for="">
                                                Frete
                                            </label>
                                            <section>
                                                <v-text-field density="compact" v-model="vFrete" placeholder="0,00"
                                                    variant="outlined"></v-text-field>
                                            </section>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-btn prepend-icon="mdi-plus" @click="simuladorTributei" color="#0a4"
                                                size="large"
                                                style="box-shadow: 0 8px 25px -8px #0a4; text-transform: capitalize;">Adicionar
                                                produto ao pedido</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="4" class="h-100" v-if="addProd">
                        <v-card class="pa-6 h-100" style="font-weight: 600 !important;">
                            <v-card-tile class="" style="font-size: 20px;">Resultados</v-card-tile>
                            <v-row class="pt-9">
                                <v-col cols="12" class="py-0">
                                    <div class="d-flex justify-space-between pa-0">
                                        <p class="">ICMS-ST Fornecedor</p>
                                        <span class=""> R$ 0,00{{ }}</span>
                                    </div>
                                    <v-divider class="mt-0"></v-divider>
                                </v-col>
                                <v-col cols="12" class="py-0">
                                    <div class="d-flex justify-space-between pa-0">
                                        <p class="">ICMS-ST Destinatário</p>
                                        <span class=""> R$ 0,00{{ }}</span>
                                    </div>
                                    <v-divider class="mt-0"></v-divider>
                                </v-col>
                                <v-col cols="12" class="py-0">
                                    <div class="d-flex justify-space-between pa-0">
                                        <p class="">FCP Fornecedor</p>
                                        <span class="">R$ 0,00{{ }}</span>
                                    </div>
                                    <v-divider class="mt-0"></v-divider>
                                </v-col>
                                <v-col cols="12" class="py-0">
                                    <div class="d-flex justify-space-between pa-0">
                                        <p class="">FCP Destinatárior</p>
                                        <span class=""> R$ 0,00{{ }}</span>
                                    </div>
                                    <v-divider class="mt-0"></v-divider>
                                </v-col>
                                <v-col cols="12" class="py-0">
                                    <div class="d-flex justify-space-between pa-0">
                                        <p class="">Valor Total Produtos</p>
                                        <span class="">R$ {{ pedido ? formatCurrency(pedido.pedido.total_produto) : '0,00'
                                        }}</span>
                                    </div>
                                    <v-divider class="mt-0"></v-divider>
                                </v-col>
                                <v-col cols="12" class="py-0">
                                    <div class="d-flex justify-space-between pa-0">
                                        <p class="">Valor Total Pedido</p>
                                        <span class=""> R$ {{ pedido ? formatCurrency(pedido.pedido.total_pedido) : '0,00'
                                        }}</span>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-card>
                    </v-col>
                    <v-col v-if="addProd" cols="12">
                        <v-card class="w-100 py-5">
                            <v-card-title class="ml-4 mt-2 tributei-title" style="font-size: 21px;">
                                Pedido
                            </v-card-title>
                            <v-divider class="mx-7 my-2"></v-divider>
                            <v-table class="mx-7" style="font-family: 'Montserrat', sans-serif;">
                                <thead style="background: #f3f2f7; height: 30px !important;" class="rounded-0">
                                    <tr>
                                        <th class="text-center font-weight-bold w-75"
                                            style="color: black !important; font-size: 13px;">
                                            PRODUTO
                                        </th>
                                        <th class="text-center font-weight-bold"
                                            style="color: black !important; font-size: 13px;">
                                            NCM
                                        </th>
                                        <th class="text-center font-weight-bold"
                                            style="color: black !important; font-size: 13px;">
                                            CEST
                                        </th>
                                        <th class="text-center font-weight-bold"
                                            style="color: black !important; font-size: 13px;">
                                            VALOR TOTAL
                                        </th>
                                        <th class="text-center font-weight-bold"
                                            style="color: black !important; font-size: 13px;">
                                            BASE DE CALCULO
                                        </th>
                                        <th class="text-center font-weight-bold"
                                            style="color: black !important; font-size: 13px;">
                                            MVA
                                        </th>
                                        <th class="text-center font-weight-bold"
                                            style="color: black !important; font-size: 13px;">
                                            ALIQUOTA INTERNA
                                        </th>
                                        <th class="text-center font-weight-bold"
                                            style="color: black !important; font-size: 13px;">
                                            VALOR ICMS-ST
                                        </th>
                                        <th class="text-center font-weight-bold"
                                            style="color: black !important; font-size: 13px;">
                                            VALOR FCP
                                        </th>
                                        <th class="text-center font-weight-bold"
                                            style="color: black !important; font-size: 13px;">
                                            QUEM RECOLHE
                                        </th>
                                        <th class="text-center font-weight-bold"
                                            style="color: black !important; font-size: 13px;">
                                            PROTOCOLO
                                        </th>
                                        <th class="text-center font-weight-bold"
                                            style="color: black !important; font-size: 13px;">
                                            AÇÕES
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="produto in produtos" style="font-size: 12px; font-weight: 400;"
                                        :key="produto.id">
                                        <td class="text-center">{{ produto.produto.nome_produto }}</td>
                                        <td class="text-center">{{ formatNCM(produto.produto.ncm_compra) }}</td>
                                        <td class="text-center">{{ formatCEST(produto.produto.cest_compra) }}</td>
                                        <td class="text-center">{{ produto.vProd > 0 ?
                                            produto.vProd?.toLocaleString("pt-br", { style: "currency", currency: "BRL" }) :
                                            '0,00' }}</td>
                                        <td class="text-center">{{ produto.calculo.basecalculoantesmva > 0 ?
                                            produto.calculo.basecalculoantesmva?.toLocaleString("pt-br", {
                                                style:
                                                    "currency", currency: "BRL"
                                            }) : '0,00' }}</td>
                                        <td class="text-center">{{ produto.calculo.mva }}%</td>
                                        <td class="text-center">{{ produto.calculo.aliquotainterna }}%</td>
                                        <td class="text-center">{{ produto.calculo.valoricmsst > 0 ?
                                            produto.calculo.valoricmsst?.toLocaleString("pt-br", {
                                                style: "currency",
                                                currency: "BRL"
                                            }) : 'R$ 0,00' }}</td>
                                        <td class="text-center">{{ produto.calculo.valoricmsst > 0 ?
                                            produto.calculo.valoricmsst?.toLocaleString("pt-br", {
                                                style: "currency",
                                                currency: "BRL"
                                            }) : 'R$ 0,00' }}</td>
                                        <td class="text-center">{{ produto.protocolo.length > 0 ? 'FORNECEDOR' :
                                            "DESTINATÁRIO" }}</td>
                                        <td class="text-center"> <v-chip v-if="produto.protocolo.length <= 0" color="red">Sem protocolo</v-chip>
                                            <v-chip class="d-flex flex-column"  color="green" v-else> 
                                                <p v-for="protocolo in produto.protocolo" :key="protocolo.index">{{ protocolo.base_legal_st }}</p>
                                            </v-chip>
                                        </td>
                                        <td class="text-center"> <v-btn variant="plain" icon> <v-icon
                                                    size="large">mdi-trash-can-outline</v-icon>
                                                <v-tooltip activator="parent" location="top">Excluir produto</v-tooltip>
                                            </v-btn>
                                        </td>
                                    </tr>
                                </tbody>
                            </v-table>
                        </v-card>
                    </v-col>
                </v-row>
            </section>
        </div>
    </section>
</template>
<script>
import axios from 'axios'

import Steppers from '../components/Steppers.vue'


export default {
    components: {

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
            addProd: false,
            num: [],
            limit: 5,
            page: 1,
            clientes: [],
            produtos: [],
            produto: null,
            pedido: null,
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
            items: this.$page.props.emissoes,
        }
    },
    watch: {
        addProd() {
            if (this.addProd === true) {
                this.produto = null,
                    this.quantidade = "",
                    this.vDescC = "",
                    this.vDescIC = "",
                    this.vFrete = "",
                    this.vICMS = "",
                    this.vSeg = "",
                    this.vUnit = "",
                    this.ipi = "",
                    this.cOutro = "",
                    this.http.get(`https://apisaidas.tributei.net/api/00104603000303/simulador/pedidos/produtos/${this.pedido_id}`).then(response => {
                        this.pedido = response.data
                        this.pedido.data.forEach(element => {
                            this.produtos.push(element);
                        });
                        console.log(this.produtos)
                        console.log(this.pedido)
                    })
            }
        },
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
        formatCurrency(value) {
            console.log(value)
            const formattedValue = value.toFixed(2).replace(/\./g, ',').replace(/\d(?=(\d{3})+,)/g, '$&.');
            return formattedValue;
        },

        formatNCM(ncm) {
            if (!ncm) return ''
            if (ncm && ncm.length >= 10) return ncm
            return ncm?.replace(/(\d{4})(\d{2})(\d{2})/, "\$1.\$2.\$3")
        },
        formatCEST(cest) {
            if (!cest) return ''
            return cest.replace(/(\d{2})(\d{3})(\d{2})/, "\$1.\$2.\$3")
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
                this.http.post('https://apisaidas.tributei.net/api/00104603000303/simulador/pedidos', {
                    cliente_id: this.cliente_id,
                    tipoCalculo: this.tipoCalculo
                })
                    .then(response => {
                        this.pedido_id = response.data.id
                        this.http.post('http://127.0.0.1:8000/api/cadastrar-request', [
                            {
                                user_id: 1,
                                empresa_id: 1,
                                ipi: this.ipi,
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
                            }
                        ]);
                        this.http.post('https://apisaidas.tributei.net/api/00104603000303/simulador/pedidos/produtos', {
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
                                //                               location.reload();

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
<style>
body {
    font-family: 'Montserrat', sans-serif !important;
    color: #000000 !important;
    font-weight: 500;
}
</style>