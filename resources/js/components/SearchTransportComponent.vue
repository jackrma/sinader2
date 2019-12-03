<template>
  <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="500"
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
           Buscar Empresa Trasnporte
        </v-card-title>

        <v-card-text>
     
            <v-layout>

                <v-flex xs12 class="px-2" style="overflow: auto">

                    <v-card class="py-4 px-2">
                        <v-card-title>
                            <v-text-field
                                v-model="search"
                                append-icon="search"
                                label="Search"
                                single-line
                                hide-details
                            ></v-text-field>
                        </v-card-title>
                      <v-data-table
                        :headers="headers"
                        :items="transports"
                        v-model="selected"
                      >
                        <template v-slot:items="props">
                          <tr @click="showAlert(props.item)">
                            <td class="text-xs-right">{{ props.item.rut }}</td>
                            <td class="text-xs-right">{{ props.item.name }}</td>
                        </tr>
                        </template>
                      </v-data-table>
                  

                    </v-card> 

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
            Cerrar
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

  import NewTraceabilityComponent  from './../components/NewTraceabilityComponent';

  export default {

    data () {
      return {
        checkbox:false,
        dialog: true,



        headers: [
            { text: 'Rut', value: '' },            
            { text: 'Razón Social', value: '' },
        ],

        transports: [
            {
                rut: '92176000-0',
                name: 'Tranportes René',

            },
            {
                rut: '92176000-0',
                name: 'Empresa Maldonado Spa',

            },
            {
                rut: '92176000-0',
                name: 'Empresa Spa',

            },
        ],


        }
      },
    }
  
</script>