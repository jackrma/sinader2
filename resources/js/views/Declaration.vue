<template>

<v-layout row>
    <v-card>


    <v-toolbar  color="main_green" dark>

      <v-toolbar-title v-if="this.$store.getters.type=='GeneradorIndustrial' || this.$store.getters.type=='GeneradorMunicipal'" >Reportes de Generación de Residuos no Peligrosos</v-toolbar-title>

      <v-toolbar-title v-if="this.$store.getters.type=='CentroAcopio' || this.$store.getters.type=='DestinatarioFinal'" >Reportes de Salida de Residuos no Peligrosos</v-toolbar-title>


    </v-toolbar>

    <v-layout row>
        <v-flex xs1>
            <p></p>
        </v-flex>
    </v-layout> 

<!--     <v-toolbar  color="secondary_green" dark>
        <v-toolbar-title >Declaraciones de Residuos Entrantes</v-toolbar-title>

    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="declarations"
      class="elevation-1"
     
    >
      <template v-slot:items="props">
        <td class="text-xs-right">{{ props.item.correlative }} - {{ props.item.correlative_dv }}</td>
        <td class="text-xs-right">{{ props.item.period }}</td>
        <td class="text-xs-right">{{ props.item.rut }}</td>
        <td class="text-xs-right">{{ props.item.establecimiento }}</td>
        <td class="text-xs-right">{{ props.item.created_at }}</td>
        <td class="text-xs-right">{{ props.item.status }}</td>
        <td class="text-xs-right">{{ props.item.certificate }}</td>

      </template>
    </v-data-table>

    <v-layout row>
        <v-flex xs1>
            <p></p>
        </v-flex>
    </v-layout> 
 -->

    <v-toolbar color="secondary_green" dark>
        <v-toolbar-title></v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn @click='toNewDeclaration' color="main_green">Registrar nueva declaración</v-btn>
    </v-toolbar>


    <v-data-table
      :headers="headers"
      :items="declarations"
      class="elevation-1"
      
    >
      <template v-slot:items="props">
        <td class="text-xs-right">{{ props.item.correlative }} - {{ props.item.correlative_dv }}</td>
        <td class="text-xs-right">{{ props.item.period }}</td>
        <td class="text-xs-right">{{ props.item.user }}</td>
        <td class="text-xs-right">{{ props.item.created_at }}</td>
        <td class="text-xs-right">{{ props.item.type }}</td>
        <td class="text-xs-right">{{ props.item.status }}</td>
        <td class="text-xs-right">{{ props.item.certificate }}</td>




        <td> 
            <v-btn  v-if="props.item.status=='ENVIADO'" small @click="toNewDeclaration" color="ds_138" dark>Editar</v-btn>
 
             <v-btn  v-if="props.item.status!='ENVIADO'" small @click="" color="main_green" dark>Eliminar</v-btn>
        </td>   
      </template>
    </v-data-table>


    </v-card>
</v-layout>    
</template>

<script>

  import { mapState } from 'vuex';  
  import Vue from 'vue';  
  // import { EventBus } from './../eventbus.js';

 
  import DeclarationComponent  from './../components/DeclarationComponent';


  export default {
    props: {
        declaration: Object
    },
    data: () => ({
        headers: [


            { text: 'Folio', value: '' }, 
            { text: 'Ingresado Por', value: '' },            
            { text: 'Período', value: '' },
            { text: 'Fecha', value: '' },
            { text: 'Estado', value: '' },
            { text: 'Tipo', value: '' },
            { text: 'Certificado', value: '' },
            { text: 'Accion', value: '' },
        ],
        declarations: [
            // {
            //     correlative: 149882,
            //     correlative_dv: 'K',
            //     user:'René Maldonado',
            //     period: '2019',
            //     status: 'ENVIADO',
            //     type: 'SALIDA',
            //     created_at:'01/10/2019',
            //     certificate: 'certificado.pdf',
            // },

        ]

        }),
    

    created () {
        this.initialize();
    },
    
    methods: {
        initialize(){
            this.getdecalrations();
            // if(this.$store.getters.type=='CentroAcopio') {
            //     this.declarations=[
            //     {
            //         correlative: 149882,
            //         correlative_dv: 'K',
            //         user:'René Maldonado',
            //         period: '2019',
            //         status: 'ENVIADO',
            //         type: 'SALIDA',
            //         created_at:'01/10/2019',
            //         certificate: 'certificado.pdf',
            //     },
            //     {
            //         correlative: 149882,
            //         correlative_dv: 'K',
            //         user:'René Maldonado',
            //         period: '2019',
            //         status: 'ENVIADO',
            //         type: 'TRAZABILIDAD',
            //         created_at:'01/10/2019',
            //         certificate: 'certificado.pdf',
            //     }
            //     ]
            // }
        },  

        getdecalrations(){
            var app = this;
            axios.get('/api/declarations')
                .then(function (resp) {    
                    app.declarations = resp.data;
                    alert(JSON.stringify(resp.data));
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error declarations/index :" + resp);
                });

        },


        toNewDeclaration (){
            var ComponentReserv = Vue.extend(DeclarationComponent)
            var instance = new ComponentReserv({store: this.$store, propsData: {
            source: '',
             
          }});
            instance.$mount();
            this.$refs.container.appendChild(instance.$el);
        },
    }
    }
</script>    
