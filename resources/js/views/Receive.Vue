<template>

<v-layout row>
<v-layout>
	<v-flex xs12 class="pr-1 px-2">
	  
    <v-card>
    <v-toolbar  color="main_green" dark>

      	<v-toolbar-title>Validar Recepción de Residuos no Peligrosos</v-toolbar-title>
    </v-toolbar>



    <v-data-table
      :headers="headers"
      :items="declarations"
      class="elevation-1"
      
    >
      <template v-slot:items="props">
        <td class="text-xs-right">{{ props.item.correlative }} - {{ props.item.correlative_dv }}</td>
        <td class="text-xs-right">{{ props.item.period }}</td>
        <td class="text-xs-right">{{ props.item.establishment }}</td>
        <td class="text-xs-right">{{ props.item.created_at }}</td>
        <td class="text-xs-right">{{ props.item.status }}</td>
        <td class="text-xs-right">{{ props.item.certificate }}</td>

        <td> 
            <v-btn  v-if="props.item.status=='ENVIADO'" small @click="toReceive" color="ds_138" dark>Recepcionar</v-btn>
 
             <v-btn  v-if="props.item.status!='ENVIADO'" small @click="toReceive" color="ds_138" dark>Recepcionar</v-btn>
        </td>   
      </template>
    </v-data-table>


    </v-card>
    	</v-flex>

</v-layout>
    <br>
    <br>
  

<v-layout>
	<v-flex xs12 class="px-2">

    <v-card>

    <v-toolbar  color="main_green" dark>

      	<v-toolbar-title>Recepción de Residuos no Peligrosos Generadores No Registrados</v-toolbar-title>

 	    <v-spacer></v-spacer>
        <v-btn @click='toNewReceive' color="main_green">Nueva Recepción</v-btn>
    </v-toolbar>



    <v-data-table
      :headers="headers"
      :items="receivenn"
      class="elevation-1"
      
    >
      <template v-slot:items="props">
        <td class="text-xs-right">{{ props.item.correlative }} - {{ props.item.correlative_dv }}</td>
        <td class="text-xs-right">{{ props.item.period }}</td>
        <td class="text-xs-right">{{ props.item.establishment }}</td>
        <td class="text-xs-right">{{ props.item.created_at }}</td>
        <td class="text-xs-right">{{ props.item.status }}</td>
        <td class="text-xs-right">{{ props.item.certificate }}</td>

        <td> 
            <v-btn  v-if="props.item.status=='ENVIADO'" small @click="toReceive" color="ds_138" dark>Editar</v-btn>
 
             <v-btn  v-if="props.item.status!='ENVIADO'" small @click="toReceive" color="ds_138" dark>Editar</v-btn>
        </td>   
      </template>
    </v-data-table>


    </v-card>

</v-flex>
</v-layout> 
</v-layout>    
</template>

<script>

  import { mapState } from 'vuex';  
  import Vue from 'vue';  
  // import { EventBus } from './../eventbus.js';

 
  import DeclarationComponent  from './../components/ReceiveComponent';
  import NewReceiveComponent  from './../components/NewReceiveComponent';



  export default {
    props: {
        declaration: Object
    },
    data: () => ({
        headers: [

            { text: 'Folio Origen', value: '' },           
            { text: 'Período Origen', value: '' },
            { text: 'Fecha', value: '' },
            { text: 'Establecimiento', value:''},
            { text: 'Estado', value: '' },
            { text: 'Certificado', value: '' },
            { text: 'Accion', value: '' },
        ],
        declarations: [
            {
                correlative: 149882,
                correlative_dv: 'K',
                establishment:'Municipalidad Prueba',
                period: '2019',
                status: 'Por Recepcionar',
                created_at:'01/10/2019',
                certificate: 'certificado.pdf',
            }
        ],

        receivenn: [
            {
                correlative: 149882,
                correlative_dv: 'K',
                establishment:'Fredy Remirez',
                period: '2019',
                status: 'Recibido',
                created_at:'01/10/2019',
                certificate: 'certificado.pdf',
            }
        ]
        }),
    

    created () {
        this.initialize();
    },
    
    methods: {
        initialize(){

        },  


        toReceive (){
            var ComponentReserv = Vue.extend(DeclarationComponent)
            var instance = new ComponentReserv({store: this.$store, propsData: {
            source: '',
             
          }});
            instance.$mount();
            this.$refs.container.appendChild(instance.$el);
        },
        toNewReceive (){
            var ComponentReserv = Vue.extend(NewReceiveComponent)
            var instance = new ComponentReserv({store: this.$store, propsData: {
            source: '',
             
          }});
            instance.$mount();
            this.$refs.container.appendChild(instance.$el);
        },

    }
    }
</script>   