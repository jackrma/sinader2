<template>
  <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="1000"
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
          Agregar Residuo
        </v-card-title>

        <v-card-text>
            <v-form ref="form"  lazy-validation>
                    <v-layout>
                        <v-flex  xs3 class="px-1">

                            <v-select
                                :items="destinatarios"
                                v-model="destiny"
                                label="Destinatario"
                                :rules = "generalRule"
                                return-object
                            ></v-select> 


                        </v-flex>
                        <v-flex  xs3 class="px-1">


                            <v-select
                                :items="establishments"
                                v-model="establishment"
                                label="Establecimiento"
                                :rules = "generalRule"
                                return-object
                            ></v-select> 

                        </v-flex>
                        <v-flex xs3 class="px-1">
                            
                            <v-select
                                :items="processings"
                                v-model="procesing"
                                label="Tipo de Tratamiento"
                                item-text="name"  
                                :rules = "generalRule"
                                v-on:change="changeProcess"
                                return-object
                            ></v-select> 
                        </v-flex>
                        <v-flex xs3 class="px-1">
                            
                            <v-select
                                :items="gestions"
                                v-model="gestion"
                                label="Tipo de Gestión"
                                item-text="name" 
                                :rules = "generalRule"
                                v-on:change="changeGestion"
                                return-object
                            ></v-select> 

                        </v-flex>

                    </v-layout>

                    <v-layout>
                        <v-flex  xs4 class="px-1">

                            <v-select
                                :items="capitulos"
                                v-model="capitulo"
                                label="Capitulo"
                                :rules = "generalRule"
                                item-text="name"   
                                v-on:change="changeChapter"
                                return-object
                            ></v-select> 


                        </v-flex>
                        <v-flex  xs4 class="px-1">
                            <v-select
                                :items="subcapitulos"
                                v-model="subcapitulo"
                                label="Sub Capitulo"
                                :rules = "generalRule"
                                item-text="name" 
                                v-on:change="changeSupChapter"
                                return-object
                            ></v-select> 

                        </v-flex>
                        <v-flex xs4 class="px-1">
                            <v-select
                                :items="residues"
                                v-model="residue"
                                label="Residuo"
                                item-text="name" 
                                v-on:change="changeResidue"
                                return-object
                                :rules = "generalRule"
                            ></v-select> 
                        </v-flex>
                        
                    </v-layout>
                    <v-layout>
                        <v-flex xs3 class="px-1">
                            <v-text-field  :rules = "numberRule" v-model='cantidad' type='number' label="Cantidad"></v-text-field>
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
                        <v-checkbox
                          v-model="checkbox"
                          label="Residuo Exportado ?"
                        ></v-checkbox>
                    </v-layout>    

                    <v-layout v-if="checkbox">
                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="pais" label="País"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="empresa" label="Empresa"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="contacto" label="Contacto"></v-text-field>
                        </v-flex>

                        <v-flex xs3 class="px-1">
                            <v-text-field v-model="email" label="Email"></v-text-field>
                        </v-flex>

                    </v-layout>
            </v-form>        

        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="main_green"
            class='white--text'
            @click="saveResidue()"
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


  export default {
    data () {
      return {

        generalRule: [v => !!v || 'Campo requerido'],
        numberRule: [v => !!v || 'Campo requerido', v => v && /^[0-9]+$/.test(v) || 'Debe ser valor numérico',],



        checkbox:false,
        dialog: true,

        cantidad:0,
        unidad:'',
        destiny:'',
        residue:'',
        residuetext:'',
        capitulos: '',
        subcapitulos: '',
        residues: '',

        company_selected:1,
        establishment_selected:1,
        residue_selected:'',
        process_selected:'',
        gestion_selected:'',
        unit_selected:'',

        pais:'',
        empresa:'',
        contacto:'',
        email:'',
        
        tipos_recoleccion: '',

        destinatarios: ['92176000-0 | Gerdau Aza SA', '92176000-0 | Gerdau Aza SA' ],
        establishments: ['12345 | Gerdau Aza Colina','12345 | Gerdau Aza Colina'],

        procesing:'',
        processings:'',
        gestion:'',
        gestions:'',
        units:'',
        }
    },
    created(){
        this.initialize();
    },
    methods: {
        initialize(){
            var app = this;
            axios.get('/api/unit')
                .then(function (resp) {    
                    app.units = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error unit :" + resp);
                });

            axios.get('/api/managetype')
                .then(function (resp) {    
                    app.gestions = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error ManageType :" + resp);
                });

            axios.get('/api/processtype')
                .then(function (resp) {    
                    app.processings = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error ProcessType :" + resp);
                });

            axios.get('/api/recolectiontype')
                .then(function (resp) {    
                    app.tipos_recoleccion = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error RecolectionType :" + resp);
                });
            axios.get('/api/lerchapter')
                .then(function (resp) {    
                    app.capitulos = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error chapter :" + resp);
                });

        },

        changeChapter(chapter_selected){
            var app = this;
            
            axios.get('/api/lersubchapter/' + chapter_selected.id)
                .then(function (resp) {   
                    app.subcapitulos = resp.data;
                    app.residues = [];
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error chapter :" + resp);
                });
        },

        changeSupChapter(subchapter_selected){
            var app = this;
            
            axios.get('/api/lerwaste/' + subchapter_selected.id)
                .then(function (resp) {   
                    app.residues = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error chapter :" + resp);
                });
        },

        changeResidue(residue_selected){
            this.residue_selected = residue_selected;
            this.residuetext = residue_selected.waste_code +' | '+ residue_selected.name;
        },

        changeCompany(company_selected){

            this.company_selected = company_selected;
        },

        changeEstablishment(establishment_selected){
            this.establishment_selected = establishment_selected;
        },

        changeProcess(process_selected){
            this.process_selected = process_selected;
        },

        changeGestion(gestion_selected){
            this.gestion_selected = gestion_selected;
        },

        changeUnit(unit_selected){
            this.unit_selected = unit_selected;
        },

        saveResidue(){

            if (this.$refs.form.validate()){

                this.residue = {
                    waste: this.residuetext,
                    sum: this.cantidad + ' ' + this.unidad.name,
                    company: '92176000-0 | Gerdau Aza SA',
                    establishment: '12345 | Gerdau Aza Colina',
                    processing: this.procesing.name,
                    gestion: this.gestion.name,
                    pais: this.pais,
                    empresa: this.empresa,
                    contacto: this.contacto,
                    email: this.email,

                    // company_id: this.company_selected.id,
                    company_id: 1,
                    // establishment_id: this.establishment_selected.id,
                    establishment_id: 1,
                    process_id: this.process_selected.id,
                    gestion_id: this.gestion_selected.id,
                    quantity: this.cantidad,
                    waste_id: this.residue_selected.id,
                    unit_id: this.unit_selected.id,
                    carrier_id: 1,
                };

                this.$store.commit('changeResidue', this.residue);

                this.dialog = false;

                EventBus.$emit('saveResidues', 'someValue'); 
            }
            
        }
    }
}
  
</script>


