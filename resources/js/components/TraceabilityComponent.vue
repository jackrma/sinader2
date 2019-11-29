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
                        <v-flex xs3 class="px-1">
                            

                            <v-select
                                :items="residues"
                                v-model="residue"
                                label="Residuo"
                            ></v-select> 

                        </v-flex>
                        
                        <v-flex xs3 class="px-1">
                            <v-text-field v-model='cantidad' type='number' label="Cantidad"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-select
                                :items="units"
                                v-model="unidad"
                                label="Unidad de Medida"
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
                            <td class="text-xs-right">{{ props.item.residue }}</td>
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
  
  // import { EventBus } from './../eventbus.js';

  import NewTraceabilityComponent  from './../components/NewTraceabilityComponent';

  export default {

    data () {
      return {
        checkbox:false,
        dialog: true,

        residue: '200101 | Metales',
        cantidad: 23,
        unidad: 'Ton',

        total: 9,


        capitulos: ['capitulo prueba 1','capitulo prueba 2', 'capitulo prueba 3','capitulo prueba 4'],
        subcapitulos: ['subcapitulo prueba 1','subcapitulo prueba 2', 'subcapitulo prueba 3','subcapitulo prueba 4'],
        residues: ['200101 | Metales','Papel y cartón', 'residuo 2', 'residuo 3'],
        
        tipos_recolecciom: ['Punto Verde','Tipo Recolección 2','Tipo Recolección 3'],

        destinatarios: ['11111111-1 | SOREPA', '11111111-1 | SOREPA 2' ],
        establishments: ['4989 | Planta Colina','4990 | Planta 2'],

        processings:['Pretratamiento de papel y cartón', 'tipo 2', 'tipo3'],
        gestion:['Centro Acopio', 'Gestion 2', 'Gestion 3'],
        units:['Kg','Ton'],

        headers: [
            { text: 'Descripción del Residuo', value: '' },            
            { text: 'Nombre Establecimiento', value: '' },
            { text: 'Tipo de Tratamiento', value: '' },
            { text: 'Tipo de Gestión', value: '' },
            { text: 'Cantidad', value: '' },
        ],

        residues: [
            {
                residue: '200101 | Metales',
                sum: '7 Ton',
                to: '92176000-0 | Gerdau Aza SA',
                establishment: '12345 | Gerdau Aza Colina',
                processing: 'Reciclaje de Metales',
                gestion:'Recolección',
            },
            {
                residue: '200101 | Metales',
                sum: '2 Ton',
                to: '92176000-0 | Gerdau Aza SA',
                establishment: '12345 | Gerdau Aza Colina',
                processing: 'Reciclaje de Metales',
                gestion:'Recolección',
            }
        ],


        }
      },
      methods:{
          NewDestiny (){

                  var ComponentReserv = Vue.extend(NewTraceabilityComponent)
                  var instance = new ComponentReserv({store: this.$store, propsData: {
                  source: '', 
                  }});
                  instance.$mount();
                  this.$refs.container.appendChild(instance.$el);
          },
      }
    }
  
</script>