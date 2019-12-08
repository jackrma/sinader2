<template>
  <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="450"
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
          Agregar Transporte
        </v-card-title>

        <v-card-text>
                        <v-layout>
                        <v-flex xs12 class="px-1">
                            <v-col cols="12" lg="6">
                                <v-menu
                                  v-model="menu1"
                                  :close-on-content-click="false"
                                  transition="scale-transition"
                                  offset-y
                                  full-width
                                  max-width="290px"
                                  min-width="290px"
                                >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                      v-model="move_date"
                                      label="Fecha de Movimiento"
                                      persistent-hint
                                      prepend-icon="event"
                                      readonly
                                      v-on="on"
                                    ></v-text-field>
                                  </template>
                                  <v-date-picker v-model="move_date" no-title @input="val_move_date"></v-date-picker>
                                </v-menu>
                            </v-col>


                        </v-flex>
                    </v-layout>
                    <v-layout>
                        <v-flex xs10 class="px-1">
                            <v-select
                                :items="transports"
                                v-model="transport"
                                label="Empresa de Transportes"
                            ></v-select> 
                        </v-flex>    
                        <v-flex xs2 class="px-1">
                            <v-btn text icon color="grey lighten-2" @click='toSearch' >
                                <v-icon>search</v-icon>
                            </v-btn>
                        </v-flex>
                    </v-layout>
                    <v-layout>
                        <v-flex xs12 class="px-1">
                            <v-select
                                :items="types"
                                v-model="type"
                                label="Tipo de Vehículo"
                            ></v-select> 
                        </v-flex>
                    </v-layout>
                    <v-layout>
                        <v-flex xs12 class="px-1">
                            <v-select
                                :items="plates"
                                v-model="plate"
                                label="Patente"
                            ></v-select> 
                        </v-flex>
                    </v-layout>                

                    <v-layout>
                        <v-flex xs12 class="px-1">
                            <v-btn @click='toNewTransport' class='white--text' color="main_green">Nuevo Transporte</v-btn>

                        </v-flex>
                    </v-layout> 
                    <v-layout>
                        <v-flex xs12 class="px-1">
                            <p>{{ texto }}</p>

                        </v-flex>
                    </v-layout> 
                    <v-layout>
                        <v-flex xs12 class="px-1">
                            <v-select
                                :items="others"
                                v-model="other"
                                label="Transportes ingresados por el declarante"
                            ></v-select> 
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
  
  // import { EventBus } from './../eventbus.js';

  import NewTransportComponent  from './../components/NewTransportComponent';
  import SearchTransportComponent  from './../components/SearchTransportComponent';


  export default {

    data () {
      return {
        checkbox:false,
        dialog: true,
        menu1: false,

        trasnport:'',
        type:'',
        plate:'',

        texto: 'Atención: Si el transporte no se encuentra en el listado, incorporelo a su declaración. Este listado será informado a los servicios fiscalizadores',

        headers: [
            { text: 'Rut', value: '' },            
            { text: 'Razón Social', value: '' },
        ],

        transports: [
            
                'Transportes René Maldonado Spa 1',
                'Transportes René Maldonado Spa 2',
                'Transportes René Maldonado Spa 3',
                'Transportes René Maldonado Spa 4',
            ],
        types: ['Tipo 1', 'Tipo2', 'Tipo 3'],
        plates: ['RD TR 56', 'RD TR 98' ,'RD TR 43', 'RD TR 87'],    

        }
      },
      methods:{
          toNewTransport (){

              var ComponentReserv = Vue.extend(NewTransportComponent)
              var instance = new ComponentReserv({store: this.$store, propsData: {
              source: '', 
              }});
              instance.$mount();
              this.$refs.container.appendChild(instance.$el);
          },

          toSearch(){
                var ComponentReserv = Vue.extend(SearchTransportComponent)
                var instance = new ComponentReserv({store: this.$store, propsData: {
                source: '', 
                }});
                instance.$mount();
                this.$refs.container.appendChild(instance.$el);
       
          },


        val_move_date(){
            this.menu1 = false;
           
            
        },

      }
    }
  
</script>