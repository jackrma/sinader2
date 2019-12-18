<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">

      <v-card>
        <v-toolbar dark color="main_green">
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Nueva Declaración</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn flat class='white--text' v-if="this.declaration.status!='ENVIADA'"  @click="sinMovimiento()">Declarar Sin Movimiento</v-btn>

          </v-toolbar-items>
        </v-toolbar>

                <v-card class="px-5">
                    <br>

                    <v-layout>
                        <v-flex  xs3 class="pr-1">
                            <v-text-field v-model="this.correlative"  readonly='true' label="Folio"></v-text-field>
                        </v-flex>

                        <v-flex  xs3 class="px-1">
                            <v-text-field  v-model="this.$store.getters.establishment.id" readonly='true' label="Id VU"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.company" readonly='true' label="Empresa"></v-text-field>
                        </v-flex>
                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.rut" readonly='true' label="Rut"></v-text-field>
                        </v-flex>
                    </v-layout>

                    <v-layout>
                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.establishment" readonly='true'  label="Establecimiento"></v-text-field>
                        </v-flex>
 
                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.address" readonly='true'  label="Dirección"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.commune"  label="Comuna"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.region" readonly='true' label="Región"></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout>
                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="this.$store.getters.user.name" readonly='true' label="Declarado Por"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-select
                                :items="types"
                                v-model="type"
                                label="Tipo Reporte"
                            ></v-select> 

                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-select
                                :items="periods"
                                v-model="period"
                                label="Periodo"
                            ></v-select>
                        </v-flex>
                    </v-layout>



                </v-card>
        

          

                <v-card v-if="this.$store.getters.type=='GeneradorMunicipal'" class="px-5">
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
                </v-card>


        <v-toolbar  color="secondary_green" dark>
            <v-toolbar-title >Residuos</v-toolbar-title>
        <v-spacer></v-spacer>
            <v-btn  v-if="this.declaration.status!='ENVIADA'" class="ma-2 white--text" @click='toNewResidue' color="main_green">
                Agregar
                <v-icon lefth>add</v-icon>
            </v-btn>          
        
            <v-btn v-if="this.declaration.status!='ENVIADA'" @click='toNewResidue' color="main_green">Subir Excel</v-btn>
        </v-toolbar>
        <v-data-table
          :headers="headers"
          :items="residues"
          class="elevation-1"
          v-if="this.declaration.status!='ENVIADA'"
        >
          <template v-slot:items="props">
            <td class="text-xs-right">{{ props.item.waste }}</td>
            <td class="text-xs-right">{{ props.item.quantity }}</td>
            <td class="text-xs-right">{{ props.item.company }}</td>
            <td class="text-xs-right">{{ props.item.establishment }}</td>
            <td class="text-xs-right">{{ props.item.processing }}</td>
            <td class="text-xs-right">{{ props.item.gestion }}</td>


            <td  class="justify-center layout px-0">

<!--                 <v-btn icon  @click="edit_item(props.item)" >
                    <v-icon>edit</v-icon>
                </v-btn> -->

                <v-btn  icon @click="delete_item(props.item)" >
                    <v-icon>delete</v-icon>
                </v-btn>
            </td>   

          </template>
        </v-data-table>

        <v-data-table
          :headers="headers"
          :items="residues"
          class="elevation-1"
          v-if="this.declaration.status=='ENVIADA'"
        >
          <template v-slot:items="props">
            <td class="text-xs-right">{{ props.item.waste }}</td>
            <td class="text-xs-right">{{ props.item.quantity }}</td>
            <td class="text-xs-right">{{ props.item.company }}</td>
            <td class="text-xs-right">{{ props.item.establishment }}</td>
            <td class="text-xs-right">{{ props.item.processing }}</td>
            <td class="text-xs-right">{{ props.item.gestion }}</td>
          </template>
        </v-data-table>

             <v-layout>
                <v-flex xs10 class="px-1">
                </v-flex>
                <v-flex xs2 class="px-1">
                    
                    <v-btn v-if="this.declaration.status!='ENVIADA'" class="ma-2 white--text" color="main_green"  @click="createdeclaration()">
                        Guardar
                        <v-icon right>save</v-icon>
                    </v-btn>
                </v-flex>
            </v-layout>        

      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>


  import Vue from 'vue';  
  import Vuex from 'vuex'; 
  import { mapState } from 'vuex';  
  
  import { EventBus } from './../eventbus.js';

 
  import NewResidueIndComponent  from './../components/NewResidueIndComponent';
  import NewResidueMunComponent  from './../components/NewResidueMunComponent';
  

  export default {
    props: {
        declaration_edit: Object,
    },
    data () {
      return {
        dialog: true,
        notifications: false,

        type: 'D.S.N°1/2013 MMA (Mensual)',
        types: ['D.S.N°1/2013 MMA (Mensual)'],

        period: '2019/Enero',
        periods: ['2019/Diciembre','2020/Enero','2020/Febrero', '2020/Marzo','2020/Abril'],

        correlative:'',
        company:'',
        rut:'',
        establishment:'',
        address:'',
        commune:'',
        region:'',


        headers: [
            { text: 'Descripción del Residuo', value: '' },            
            { text: 'Cantidad(t)', value: '' },
            { text: 'Destinatario', value: '' },
            { text: 'Nombre Establecimiento', value: '' },
            { text: 'Tipo de Tratamiento', value: '' },
            { text: 'Tipo de Gestión', value: '' },

        ],

       
        residues: [
        ],

        declaration:  {},
        
      }
    },
    
    created () {
        this.initialize();
        var app = this;
        EventBus.$on('saveResidues', function(){   
            app.refreshList();
        });

    },

    methods: {
        initialize(){


            this.company        = this.$store.getters.company.name;
            this.rut            = this.$store.getters.company.rut + '-' + this.$store.getters.company.digit;
            this.establishment  = this.$store.getters.establishment.name;
            this.address        = this.$store.getters.establishment.street + this.$store.getters.establishment.number;
            this.commune        = this.$store.getters.establishment.commune.name;
            this.region         = this.$store.getters.establishment.region.name;
            
            var app = this;

            if(this.declaration_edit){
                app.declaration = app.declaration_edit;
                app.correlative = app.declaration_edit.correlative + '-' + app.declaration_edit.correlative_dv;     

                axios.get('/api/waste_details/'+app.declaration.id)
                    .then(function (resp) {    
                        app.residues = resp.data;
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Error waste_details :" + resp);
                    }); 

            } else {
                axios.post('/api/declaration/create')
                    .then(function (resp) {    
                        app.declaration = resp.data;
                        app.correlative    = app.declaration.correlative + '-' + app.declaration.correlative_dv; 
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Error declaration/create :" + resp);
                    });                
            }
        },  

        createdeclaration(){

            var declaration = {
                correlative: this.declaration.correlative,
                correlative_dv: this.declaration.correlative_dv,
                rut: this.rut,
                company: this.company,
                establishment: this.establishment,
                direccion: this.address,
                comuna: this.commune,
                region: this.region,
                type: this.type,
                period: this.period,
                carrier: 0,
                waste_detail: this.residues,
            }

            if(this.residues.length>0){
                axios.post('/api/declaration/store', {declaration: declaration})
                    .then(function (resp) {    
                        EventBus.$emit('saveDeclaration', 'someValue');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Error declaration/store :" + resp);
                    });
                this.dialog = false;
            } else {
                alert('No se han ingresado residuos');
            }

        },

        sinMovimiento(){

            var declaration = {
                correlative: this.declaration.correlative,
                correlative_dv: this.declaration.correlative_dv,
                
                type: this.type,
                period: this.period,
                carrier: 0,
            }

            axios.post('/api/declaration/sinmovimiento', {declaration: declaration})
                .then(function (resp) {    
                    EventBus.$emit('saveDeclaration', 'someValue');
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error declaration/sinmovieminto :" + resp);
                });
            this.dialog = false;


        },



        toNewResidue (){
            //alert(this.$store.getters.type);
            if(this.$store.getters.type=='GeneradorIndustrial' || this.$store.getters.type=='CentroAcopio' || this.$store.getters.type=='DestinatarioFinal' ) {
                var ComponentReserv = Vue.extend(NewResidueIndComponent)
                var instance = new ComponentReserv({store: this.$store, propsData: {
                source: '', 
                }});
                instance.$mount();
                this.$refs.container.innerHTML = "" 
                this.$refs.container.appendChild(instance.$el);
            }else {
                var ComponentReserv = Vue.extend(NewResidueMunComponent)
                var instance = new ComponentReserv({store: this.$store, propsData: {
                source: '', 
                }});
                instance.$mount();
                this.$refs.container.innerHTML = "" 
                this.$refs.container.appendChild(instance.$el);
            }


        },


        edit_item(item){

            //alert(JSON.stringify(item));

            this.$store.commit('changeIndexedit', this.residues.indexOf(item));

            if(this.$store.getters.type=='GeneradorIndustrial' || this.$store.getters.type=='CentroAcopio' || this.$store.getters.type=='DestinatarioFinal' ) {
                var ComponentReserv = Vue.extend(NewResidueIndComponent)
                var instance = new ComponentReserv({store: this.$store, propsData: {
                residue_edit: item, 
                }});
                instance.$mount();
                this.$refs.container.innerHTML = "" 
                this.$refs.container.appendChild(instance.$el);
            }else {
                var ComponentReserv = Vue.extend(NewResidueMunComponent)
                var instance = new ComponentReserv({store: this.$store, propsData: {
                residue_edit: item, 
                }});
                instance.$mount();
                this.$refs.container.innerHTML = "" 
                this.$refs.container.appendChild(instance.$el);
            }

        },

        refreshList(){
            // 

            alert(JSON.stringify(this.$store.getters.residue));

            if(this.$store.getters.indexedit == -1){
                this.residues.push(this.$store.getters.residue);
            } else {
                this.residues.splice(this.$store.getters.editindex, 1);
                this.residues.push(this.$store.getters.residue);
                this.$store.commit('changeIndexedit', -1);
            }


        },   

 

        delete_item(item){

            this.residues.pop(item);
        },   


    }

  }
</script>