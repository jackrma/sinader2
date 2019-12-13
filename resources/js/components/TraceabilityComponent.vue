<template>
  <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="1100"
    >
<!--       <template v-slot:activator="{ on }">
        <v-btn
          color="red lighten-2"
          dark
          v-on="on"
        >
          Click Me
        </v-btn>
      </template> -->

      <v-card>
        <v-card-title
          class="headline grey lighten-2"
          primary-title
        >
          Agregar Trazabilidad
        </v-card-title>

        <v-card-text>
     
                    <v-layout>
                        <v-flex xs10 class="px-1">
                            <v-text-field v-model='residue' readonly  label="Residuo"></v-text-field>
                        </v-flex>
                    </v-layout>    
                    <v-layout>
                        
                        <v-flex xs2 class="px-1">
                            <v-text-field v-model='cantidad' type='number' label="Cantidad"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-select
                                :items="units"
                                v-model="unidad"
                                label="Unidad de Medida"
                                item-text="name" 
                                :rules = "generalRule"
                                v-on:change="changeUnit"
                                return-object
                            ></v-select> 
                        </v-flex>

                    </v-layout>
                    <v-layout>
                        <v-flex xs12 class="px-1">
                        <v-toolbar  color="secondary_green" dark>
                            <v-toolbar-title >Destinatarios</v-toolbar-title>

                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                          <v-btn flat class='white--text'  @click="NewDestiny">Agregar Destinatario</v-btn>
                        </v-toolbar-items>
                        </v-toolbar>

                        </v-flex>
                    </v-layout>

                    <v-layout>

                        <v-flex xs12 class="px-1">
                        <v-data-table
                          :headers="headers"
                          :items="residues"
                          class="elevation-1"
                         
                        >
                          <template v-slot:items="props">
                            <td class="text-xs-right">{{ props.item.establishment }}</td>
                            <td class="text-xs-right">{{ props.item.processing }}</td>
                            <td class="text-xs-right">{{ props.item.gestion }}</td>
                            <td class="text-xs-right">{{ props.item.sum }}</td>

                          </template>
                        </v-data-table>
                      </v-flex>
                    </v-layout>

                    <v-layout>
                      <v-flex xs6 class="px-1 py-4">
                      </v-flex>  
                      <v-flex xs3 class="px-1 py-4">
                          <h2> Total:</h2>
                      </v-flex> 
                      <v-flex xs3 class="px-1 py-4">
                          <h2> {{total}} Ton</h2>
                      </v-flex> 
                    </v-layout>


        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="main_green"
            class='white--text'
            @click="dialog = false"
          >
            Guardar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>


  import Vue from 'vue';  
  import Vuex from 'vuex'; 
  import { mapState } from 'vuex';  
  
  import { EventBus } from './../eventbus.js';

  import NewTraceabilityComponent  from './../components/NewTraceabilityComponent';

  export default {
    props:{
       waste_detail: Object,
    },

    data () {
      return {
        checkbox:false,
        dialog: true,

        residue: '',
        cantidad: '',
        unidad: '',

        total: 0,


        headers: [           
            { text: 'Destinatario', value: '' },
            { text: 'Tipo de Tratamiento', value: '' },
            { text: 'Tipo de Gestión', value: '' },
            { text: 'Cantidad', value: '' },
        ],

        residues: [],
        units: [],


        }
      },
    created(){
        var app = this;
        this.initialize();
        EventBus.$on('saveResidues', function(){  
            alert('residues');
            app.refreshList();
        });
  

    },
      methods:{
        initialize(){
            var app = this;

            alert(JSON.stringify(this.waste_detail));
            this.residue= this.waste_detail.waste;
            this.cantidad= this.waste_detail.quantity;
            this.unidad= 'Toneladas';

            this.total=0;

            axios.get('/api/unit')
                .then(function (resp) {    
                    app.units = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error unit :" + resp);
                });

          
        },
          NewDestiny (){

                  var ComponentReserv = Vue.extend(NewTraceabilityComponent)
                  var instance = new ComponentReserv({store: this.$store, propsData: {
                  waste_detail: this.waste_detail, remainder: this.waste_detail - this.total 
 
                  }});
                  instance.$mount();
                  this.$refs.container.appendChild(instance.$el);
          },

        refreshList(){
            this.residues.push(this.$store.getters.residue);
            this.total = this.total + parseFloat(this.$store.getters.residue.quantity);
        },   
      }
    }
  
</script>