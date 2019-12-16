<template>
  <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="1000"
      persistent="true"
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
        <v-toolbar dark color="main_green">
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Agregar Residuo</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn icon color="main_green"  @click="saveResidue()">
                <v-icon>save</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
            <v-form ref="form"  lazy-validation>
                    <v-layout>
                        <v-flex  xs3 class="px-1">

                            <v-text-field v-model="receiver_name" readonly label="Destinatario"></v-text-field>

                        </v-flex>
                        <v-flex xs1 class="px-1">
                            <v-btn text icon color="grey lighten-2" @click='toSearch' >
                                <v-icon>search</v-icon>
                            </v-btn>
                        </v-flex>

                        <v-flex  xs3 class="px-1">
                            <v-select
                                :items="establishments"
                                v-model="establishment"
                                item-text="name"  
                                label="Establecimiento"
                                v-on:change="changeEstablishment"
                                return-object
                            ></v-select> 

                        </v-flex>
                        <v-flex xs3 class="px-1">
                            
                            <v-select
                                :items="processings"
                                v-model="procesing"
                                label="Tipo de Tratamiento"
                                item-text="name"  
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
                          @click = "selectExport()"
                        ></v-checkbox>
                    </v-layout>    

                    <v-layout v-if="checkbox">
                        <v-flex xs3 class="px-1">
                            <!-- <v-text-field v-model="pais" label="País"></v-text-field> -->

                            <v-select
                                :items="countries"
                                v-model="country"
                                label="Pais"
                                item-text="name" 
                                v-on:change="changeCountry"
                                return-object
                            ></v-select> 


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
                    <v-layout v-if="this.$store.getters.type=='CentroAcopio'">
                        <v-flex xs3 class= "px-2">                  
                            <v-btn @click='toTransport' class='white--text' color="main_green">Agregar Transporte</v-btn>
                        </v-flex>
                        <v-flex xs3>
                            <p>Trasnporte: {{carriername}} {{vehicleplate}}</p>  
                        </v-flex>
                      
                    </v-layout>
            </v-form>        

        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  import Vue from 'vue';  
  import Vuex from 'vuex'; 
  import { mapState } from 'vuex';  
  
  import { EventBus } from './../eventbus.js';

  import TransportComponent  from './../components/TransportComponent';
  import SearchReceiverComponent  from './../components/SearchCompanyComponent';


  export default {
    props: {
        residue_edit: Object,
    },
    data () {
      return {

        generalRule: [v => !!v || 'Campo requerido'],
        numberRule: [v => !!v || 'Campo requerido', v => v && /^[0-9]+$/.test(v) || 'Debe ser valor numérico',],

        receiver_name:'',

        checkbox:false,
        dialog: true,

        cantidad:0,
        unidad:'',
        destiny:'',
        residue:'',
        residuetext:'',
        capitulos: '',
        capitulo:'',
        subcapitulos: '',
        subcapitulo: '',
        residues: '',

        company_selected:'',
        establishment_selected:'',
        establishment:'',
        residue_selected:'',
        process_selected:'',
        gestion_selected:'',
        unit_selected:'',
        country_selected:'',

        pais:'Chile',
        empresa:'',
        contacto:'',
        email:'',
        
        carrier:'',
        carriername:'',
        vehicleplate:'',

        tipos_recoleccion: '',
        
        companies: [],
        countries:[],
        establishments: [],


        procesing:'',
        processings:'',
        gestion:'',
        gestions:'',
        units:'',
        }
    },
    created(){
        var app = this;
        this.initialize();
        EventBus.$on('saveCarrier', function(){  
            app.refreshCarrier();
        });
        EventBus.$on('selectReceiver', function(){ 
            app.selectCompany();
        });

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

            axios.get('/api/countries')
                .then(function (resp) {    
                    app.countries = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error chapter :" + resp);
                });

            if(this.residue_edit){
                //alert(JSON.stringify(this.residue_edit));
                this.setEdit();
            } 
        },

        setEdit(){
            
                    this.residuetext = this.residue_edit.waste; 
                    this.cantidad    = this.residue_edit.quantity;
                     
                    this.empresa     = this.residue_edit.empresa;
                    this.contacto    = this.residue_edit.contacto;
                    this.email       = this.residue_edit.email;
                    
                    var app = this;
                    axios.get('/api/unit/forid/'+this.residue_edit.unit_id)
                        .then(function (resp) {    
                            app.unidad = resp.data;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Error unit :" + resp);
                        });

                    if(this.residue_edit.company_id){
                    axios.get('/api/company/forid/'+this.residue_edit.company_id)
                        .then(function (resp) {    
                            app.$store.commit('changeReceiver',  resp.data);
                            app.selectCompany();
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Error company :" + resp);
                        });    
                    }    

                    if(this.residue_edit.establishment_id){
                    axios.get('/api/establishment/forid/'+this.residue_edit.establishment_id)
                        .then(function (resp) {    
                            app.establishment_selected=resp.data;
                            app.establishment = app.establishment_selected.name;

                            // alert('establesimiento');

                            // alert(JSON.stringify(app.establishment_selected));
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Error establisgment :" + resp);
                        }); 
                    }    

                    if(this.residue_edit.country_id){
                    axios.get('/api/country/forid/'+this.residue_edit.country_id)
                        .then(function (resp) {    
                            app.country_selected=resp.data;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Error country :" + resp);
                        }); 
                    }    

                    if(this.residue_edit.process_id){
                    axios.get('/api/processtype/forid/'+this.residue_edit.process_id)
                        .then(function (resp) {    
                            app.process_selected=resp.data;
                            app.procesing= app.process_selected.name;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Error process :" + resp);
                        }); 
                    }

                    if(this.residue_edit.manage_id){
                    axios.get('/api/managetype/forid/'+this.residue_edit.manage_id)
                        .then(function (resp) {    
                            app.gestion_selected=resp.data;
                            app.gestion = app.gestion_selected.name;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Error gestion :" + resp);
                        });
                    }

                    if(this.residue_edit.waste_id){

                    axios.get('/api/lerwaste/forid/'+this.residue_edit.waste_id)
                        .then(function (resp) {    
                            app.residue_selected=resp.data;
                            app.subchapter_selected = app.residue_selected.subchapter;


                            axios.get('/api/lerchapter/forid/'+app.subchapter_selected.chapter_id)
                                .then(function (resp) {    
                                    app.chapter_selected=resp.data;
                                    app.capitulo = app.chapter_selected.name;

                                    app.changeChapter(app.chapter_selected);
                                    app.changeSupChapter(app.subchapter_selected);
                                    app.changeResidue(app.residue_selected);

                                    app.residue = app.residue_selected.name;
                                    app.subcapitulo = app.subchapter_selected.name;


                                })
                                .catch(function (resp) {
                                    console.log(resp);
                                    alert("Error lerwaste :" + resp);
                                });

                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Error lerwaste :" + resp);
                        });
                    

                    }


                    if(this.residue_edit.carrier_id){
                    axios.get('/api/carrier/forid/'+this.residue_edit.carrier_id)
                        .then(function (resp) {    
                            app.carrier=resp.data;
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Error carrier :" + resp);
                        });
                    }                    
        

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

        selectCompany(){
            // alert(JSON.stringify(this.$store.getters.receiver));

            this.receiver_name= this.$store.getters.receiver.rut +'-'+ this.$store.getters.receiver.digit +' | '+ this.$store.getters.receiver.name;
            this.changeCompany(this.$store.getters.receiver);
            
        },

        changeCompany(company_selected){

            // alert('receiver');
            var app = this;
            this.company_selected = company_selected;

            axios.get('/api/establishments/'+this.company_selected.id)
                .then(function (resp) {    
                    app.establishments = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error chapter :" + resp);
                });
        },

        changeEstablishment(establishment_selected){
            //alert(JSON.stringify(establishment_selected));
            this.establishment_selected = establishment_selected;
        },

        changeProcess(process_selected){
            this.process_selected = process_selected;
        },

        changeGestion(gestion_selected){
            this.gestion_selected = gestion_selected;
        },

        changeCountry(country_selected){
            this.pais = country_selected.name;
            this.country_selected = country_selected;
        },

        changeUnit(unit_selected){
            this.unit_selected = unit_selected;
        },

        selectExport(){
            this.company_selected        = '';
            this.establishment_selected  = '';
            this.process_selected        = '';
            this.gestion_selected        = '';  

            this.receiver_name = ''; 
            this.establishment = ''; 
            this.processings   = ''; 
            this.gestion       = ''; 

            // if(this.checkbox){
            //     this.checkbox=false;
            // }else {
                this.checkbox=true;
            // }
            
        },



        saveResidue(){


            if (this.$refs.form.validate()){

                var establishment_name = this.establishment_selected.id + ' | ' + this.establishment_selected.name;
                var company_name = this.company_selected.rut + ' | ' + this.company_selected.name;

                if(this.checkbox){
                    establishment_name = '';
                    company_name = this.country_selected.name + ' | ' + this.empresa;
                }        


                this.residue = {
                    waste: this.residuetext,
                    sum: this.cantidad + ' ' + this.unidad.name,
                    company: company_name,
                    establishment: establishment_name,
                    
                    processing: this.procesing.name,
                    gestion: this.gestion.name,
                    pais: this.pais,
                    empresa: this.empresa,
                    contacto: this.contacto,
                    email: this.email,

                    company_id: this.company_selected.id,
                    establishment_id: this.establishment_selected.id,
                    process_id: this.process_selected.id,
                    manage_id: this.gestion_selected.id,
                    quantity: this.cantidad,
                    waste_id: this.residue_selected.id,
                    unit_id: this.unit_selected.id,
                    carrier_id: this.carrier.carrier_id,
                    carrier:this.carrier,


                };

                this.$store.commit('changeResidue', this.residue);

                this.dialog = false;

                EventBus.$emit('saveResidues', 'someValue'); 
            }
            
        },
        toTransport (){
            var ComponentReserv = Vue.extend(TransportComponent)
            var instance = new ComponentReserv({store: this.$store, propsData: {
            source: '', 
            }});
            instance.$mount();
            this.$refs.container.appendChild(instance.$el);
        },

        refreshCarrier(){
            this.carrier = this.$store.getters.carrier;
            this.carriername = this.carrier.carriername;
            this.vehicleplate = this.carrier.vehicleplate;

            //alert(JSON.stringify(this.carrier));
        },
        toSearch(){
                var ComponentReserv = Vue.extend(SearchReceiverComponent)
                var instance = new ComponentReserv({store: this.$store, propsData: {
                source: '', 
                }});
                instance.$mount();
                this.$refs.container.appendChild(instance.$el);
       
        },


    }
}
  
</script>


