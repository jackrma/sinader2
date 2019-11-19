<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">

      <v-card>
        <v-toolbar dark color="main_green">
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Nueva Recepción de Residuos no Peligrosos Generadores No Registrados</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
              <v-btn flat class='white--text'  @click="dialog = false">Guardar</v-btn>
          </v-toolbar-items>
        </v-toolbar>

                <v-card class="px-5">
                    <br>

                    <v-layout>
                        <v-flex  xs3 class="pr-1">
                            <v-text-field v-model="this.declaration.folio"  readonly='true' label="Folio"></v-text-field>
                        </v-flex>


                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.declaration.company"  label="Empresa"></v-text-field>
                        </v-flex>
                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.declaration.rut"  label="Rut"></v-text-field>
                        </v-flex>
                    </v-layout>

                    <v-layout>
                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.declaration.establishment"  label="Establecimiento"></v-text-field>
                        </v-flex>
 
                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.declaration.address"  label="Dirección"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.declaration.commune"  label="Comuna"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.declaration.region"  label="Región"></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout>
                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.declaration.user"  label="Declarado Por"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.declaration.report_type" label="Tipo Reporte"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.declaration.period" readonly='true'  label="Período"></v-text-field>
                        </v-flex>
                    </v-layout>

                </v-card>
        

          

<!--                 <v-card v-if="this.$store.getters.type=='GeneradorMunicipal'" class="px-5">
                    <br>
                    <v-layout>
                        <v-flex xs3 class="px-1">
                            <h4>Información para SUBDERE</h4>
                        </v-flex>
                    </v-layout>    
                    <v-layout>
                        <v-flex xs2 class="px-1">
                            <h5>Cobertura Servicios Aseo</h5>
                        </v-flex>
                        
                        <v-flex xs2 class="px-1">
                            <v-text-field  label="Urbana %"></v-text-field>
                        </v-flex>
                        <v-flex xs2 class="px-1">
                            <v-text-field  label="Rural %"></v-text-field>
                        </v-flex>
                        <v-flex xs2 class="px-1">
                            <h5>Frecuencia recolección Días por semana</h5>
                        </v-flex>
                        <v-flex xs2 class="px-1">
                            <v-text-field  label="Zona Urbana"></v-text-field>
                        </v-flex>
                        <v-flex xs2 class="px-1">
                            <v-text-field  label="Zona Rural"></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout>   
                        <v-flex xs1 class="px-1">
                            <h5>Costos</h5>
                        </v-flex>
                        <v-flex xs3 class="px-1">
                            <v-text-field  label="Recolección y transporte $/año"></v-text-field>
                        </v-flex>
                        <v-flex xs3 class="px-1">
                            <v-text-field  label="Tonelada recolectada $/tonelada "></v-text-field>
                        </v-flex>
                        <v-flex xs3 class="px-1">
                            <v-text-field  label="Disposición final $/año "></v-text-field>
                        </v-flex>
                        <v-flex xs3 class="px-1">
                            <v-text-field  label="Tonelada dispuesta $/tonelada"></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout> 

                        <v-flex xs1 class="px-1">
                            <h5>Recaudación</h5>
                        </v-flex>
                        <v-flex xs4 class="px-1">
                            <v-text-field  label="Por derecho de aseo $/año"></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-card> -->


        <v-toolbar  color="secondary_green" dark>
            <v-toolbar-title >Residuos</v-toolbar-title>
        <v-spacer></v-spacer>
            <v-btn @click='toNewResidue' color="main_green">Agregar Residuo</v-btn>
        
            <v-btn @click='toNewResidue' color="main_green">Subir Excel</v-btn>
        </v-toolbar>
        <v-data-table
          :headers="headers"
          :items="residues"
          class="elevation-1"
         
        >
          <template v-slot:items="props">
            <td class="text-xs-right">{{ props.item.residue }}</td>
            <td class="text-xs-right">{{ props.item.sum }}</td>
            <td class="text-xs-right">{{ props.item.to }}</td>
            <td class="text-xs-right">{{ props.item.establishment }}</td>
            <td class="text-xs-right">{{ props.item.processing }}</td>
            <td class="text-xs-right">{{ props.item.gestion }}</td>

    <!--         <td class="justify-center layout px-0">
                <v-btn  v-if="props.item.state=='ACTIVO'" small @click="consumptionClick(props.item)" color="ds_138" dark>Registrar Consumo</v-btn>
     
                 <v-btn  v-if="props.item.state!='ACTIVO'" small @click="consumptionClick(props.item)" color="main_green" dark>Ver Registro</v-btn>
            </td>    -->

          </template>
        </v-data-table>






      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>


  import Vue from 'vue';  
  import Vuex from 'vuex'; 
  import { mapState } from 'vuex';  
  
  // import { EventBus } from './../eventbus.js';


  import NewResidueNNComponent  from './../components/NewResidueNNComponent';


  export default {
    data () {
      return {
        dialog: true,
        notifications: false,

        headers: [
            { text: 'Descripción del Residuo', value: '' },            
            { text: 'Cantidad(t)', value: '' },
            { text: 'Destinatario', value: '' },
            { text: 'Nombre Establecimiento', value: '' },
            { text: 'Tipo de Tratamiento', value: '' },
            { text: 'Tipo de Gestión', value: '' },

        ],

       
        residues: [
            {
                residue: '200101 | Metales',
                sum: '23 t',
                to: '92176000-0 | Gerdau Aza SA',
                establishment: '12345 | Gerdau Aza Colina',
                processing: 'Reciclaje de Metales',
                gestion:'Valorización',
            }
        ],

        declaration:  {
            folio: '12345',   
            id_vu:  '7802',    
            company:  '',   
            rut: '',  
            establishment:  '',   
            address:   '',  
            commune:  '',    
            region:  '',   
            user:   'Maritza Barrera', 
            report_type: '',    
            period: ''    
            }
        
      }
    },
    
    computed () {
        this.initialize();
    },

    methods: {
        initialize(){
            
        },  


        toNewResidue (){

                var ComponentReserv = Vue.extend(NewResidueNNComponent)
                var instance = new ComponentReserv({store: this.$store, propsData: {
                source: '', 
                }});
                instance.$mount();
                this.$refs.container.appendChild(instance.$el);

        },



    }

  }
</script>