<template>

<v-layout row>
    <v-card>


    <v-toolbar  color="main_green" dark>
      <v-toolbar-title >Declaraciones del establecimiento</v-toolbar-title>
    </v-toolbar>

    <v-layout row>
        <v-flex xs1>
            <p></p>
        </v-flex>
    </v-layout> 

    <v-toolbar  color="secondary_green" dark>
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
<!--         <td class="justify-center layout px-0">
            <v-btn  v-if="props.item.state=='ACTIVO'" small @click="consumptionClick(props.item)" color="ds_138" dark>Registrar Consumo</v-btn>
 
             <v-btn  v-if="props.item.state!='ACTIVO'" small @click="consumptionClick(props.item)" color="main_green" dark>Ver Registro</v-btn>
        </td>    -->

      </template>
    </v-data-table>

    <v-layout row>
        <v-flex xs1>
            <p></p>
        </v-flex>
    </v-layout> 


    <v-toolbar color="secondary_green" dark>
        <v-toolbar-title>Declaraciones de Residuos Salientes</v-toolbar-title>
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
        <td class="text-xs-right">{{ props.item.rut }}</td>
        <td class="text-xs-right">{{ props.item.establecimiento }}</td>
        <td class="text-xs-right">{{ props.item.created_at }}</td>
        <td class="text-xs-right">{{ props.item.status }}</td>
        <td class="text-xs-right">{{ props.item.certificate }}</td>

<!-- 
        <td> 
            <v-btn  v-if="props.item.state=='ACTIVO'" small @click="consumptionClick(props.item)" color="ds_138" dark>Registrar Consumo</v-btn>
 
             <v-btn  v-if="props.item.state!='ACTIVO'" small @click="consumptionClick(props.item)" color="main_green" dark>Ver Registro</v-btn>
        </td>    -->
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
            { text: 'Periodo', value: '' },
            { text: 'Rut', value: '' },
            { text: 'Establecimiento Origen', value: '' },
            { text: 'Fecha', value: '' },
            { text: 'Estado', value: '' },
            { text: 'Certificado', value: '' },
        ],

        declarations: [
            {
                correlative: 149882,
                correlative_dv: 'K',
                period: '2019',
                rut:'96234839-4',
                establecimiento: 'Establecimiento de Prueba',
                status: 'ENVIADO',
                created_at:'01/10/2019',
                certificate: 'certificado.pdf'
            }
        ]

        }),
    

    
    methods: {
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
