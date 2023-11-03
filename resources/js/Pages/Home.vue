<template>
    <layout-authenticated>

        <section class="my-1 w-100 h-100">
            <div class="text-start mx-8 mt-4">
                <v-row justify="start">
                    <v-col cols="4">
                        <v-card elevation="9" style="position: relative;"
                            class="w-75 mx-auto text-white py-2 pr-5 bg-green">
                            <v-card-title class="ml-3 pa-0 pl-4 pt-2" style="font-size: 25px;">Emitidos</v-card-title>
                            <div class="w-100">
                                <p style="font-weight: 600; font-size: 80px; height: 30px; position: relative; top: -55px; right: 10px;"
                                    class="text-end ml-6">2</p>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="4">
                        <v-card elevation="9" style="position: relative;"
                            class="w-75 mx-auto text-white py-2 pr-5 bg-yellow-darken-3">
                            <v-card-title class="ml-3 pa-0 pl-4 pt-2" style="font-size: 25px;">Aguardando
                                retorno</v-card-title>
                            <div class="w-100">
                                <p style="font-weight: 600; font-size: 80px; height: 30px; position: relative; top: -55px; right: 10px;"
                                    class="text-end ml-6">2</p>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="4">

                        <v-card elevation="9" style="position: relative;" class="w-75 mx-auto text-white py-2 pr-5 bg-red">
                            <v-card-title class="ml-3 pa-0 pl-4 pt-2" style="font-size: 25px;">Falha na
                                emissão</v-card-title>
                            <div class="w-100">
                                <p style="font-weight: 600; font-size: 80px; height: 30px; position: relative; top: -55px; right: 10px;"
                                    class="text-end ml-6">1</p>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="auto">
                        <v-btn block elevated color="info" append-icon="mdi-plus" size="large"
                            style="text-transform: capitalize;">Adicionar</v-btn>
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
                                            <td class="text-center"> <v-chip class="ma-2 text-white" :color="item.color">
                                                    {{ item.status }}
                                                </v-chip></td>
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
<style>
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
import LayoutAuthenticated from '../Layout/LayoutAuthenticated.vue'

export default {
    components: {
        LayoutAuthenticated


    },
    data() {
        return {
            select: 5,
            quantidade: 0,
            num: [],
            limit: 5,
            page: 1,
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
        }
    },
    computed: {
        filteredItems() {
            return this.items.slice(this.quantidade, this.limit);
        },
    },
    mounted() {
        for (let i = 1; i <= 5; i++) {
            this.num.push(i);

        }

    }
}
</script>