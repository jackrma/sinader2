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
                                :items="carriers"
                                v-model="transport"
                                label="Empresa de Transportes"
                                item-text="name"  
                                :rules = "generalRule"
                                v-on:change="changeCarrier"
                                return-object

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
                                :items="vehicle_types"
                                v-model="type"
                                label="Tipo de Vehículo"
                                item-text="name"  
                                :rules = "generalRule"
                                v-on:change="changeVehicleType"
                                return-object
                            ></v-select> 
                        </v-flex>
                    </v-layout>
                    <v-layout>
                        <v-flex xs12 class="px-1">
                            <v-select
                                :items="vehicles"
                                v-model="vehicle"
                                label="Patente"
                                item-text="plate"  
                                :rules = "generalRule"
                                v-on:change="changeVehicle"
                                return-object
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
            @click="saveCarrier()"
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

  import NewTransportComponent  from './../components/NewTransportComponent';
  import SearchTransportComponent  from './../components/SearchTransportComponent';


  export default {

    data () {
      return {
        checkbox:false,
        dialog: true,
        menu1: false,

        carrier:'',
        vehicle_type:'',
        vahicle:'',

        texto: 'Atención: Si el transporte no se encuentra en el listado, incorporelo a su declaración. Este listado será informado a los servicios fiscalizadores',

        carriers: [],
        vehicle_types: [],
        vehicles: [],    

        }
      },

    created(){
        this.initialize();
    },
    methods:{
        initialize(){
            var app = this;
            axios.get('/api/carrier')
                .then(function (resp) {    
                    app.carriers = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error carrier :" + resp);
                });

            axios.get('/api/vehicletype')
                .then(function (resp) {    
                    app.vehicle_types = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error Vehicle Type :" + resp);
                });
        },

        changeCarrier(carrier_selected){

            
            this.carrier_selected = carrier_selected;
            var app = this;

            axios.get('/api/vehicle/'+this.carrier_selected.id)
                .then(function (resp) {    
                    app.vehicles = resp.data;
                alert(JSON.stringify(resp.data));
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error Vehicle :" + resp);
                });

        },

        changeVehicle(vehicle_selected){
            this.vehicle_selected = vehicle_selected;
        },

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

        saveCarrier(){
            var transport={
                transport_date: this.move_date,
                carriername: this.carrier_selected.name,
                carrier_id: this.carrier_selected.id,
                vehicleplate: this.vehicle_selected.plate,
                vehicle_id: this.vehicle_selected.id,
            }

            this.$store.commit('changeCarrier', transport);

            this.dialog = false;

            EventBus.$emit('saveCarrier', 'someValue'); 
        }

      }
    }
  
</script>