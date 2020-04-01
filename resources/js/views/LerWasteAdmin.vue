<template>
  <div>
    <v-toolbar dark color="main_green">
      <v-toolbar-title>Residuo LER</v-toolbar-title>
      <v-divider
        class="mx-2"
        inset
        vertical
      ></v-divider>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="500px">
        <template v-slot:activator="{ on }">
          <v-btn color="primary" dark class="mb-2" v-on="on">Nuevo Registro</v-btn>
        </template>
        <v-card>
          <v-card-title>
            <!-- <span class="hidden-md-and-down">SINADER</span> -->
            <span  color="main_green" dark class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 class="px-2">
                  <v-text-field v-model="editedItem.waste_number" label="Número de Sub Capítulo"></v-text-field>
                  <v-text-field v-model="editedItem.subcharper_id" label="Id Sub Capítulo"></v-text-field>
                  <v-textarea v-model="editedItem.name" label="Nombre"></v-textarea>
                  <v-text-field v-model="editedItem.waste_code" label="Código Residuo"></v-text-field>
                  <v-text-field v-model="editedItem.type_id" label="Tipo de Residuo"></v-text-field>                  
                  <v-text-field v-model="editedItem.active" label="Activo"></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn class="ma-2 white--text"  color="main_green" @click="close">Cancelar</v-btn>
            <v-btn class="ma-2 white--text"  color="main_green" @click="toSave()">Grabar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="lerwaste"
      class="elevation-1"
    >
      <template v-slot:items="props">
        <td>{{ props.item.waste_number }}</td>
        <td class="text-xs-left">{{ props.item.subchapter_id }}</td>
        <td class="text-xs-left">{{ props.item.name }}</td>
        <td class="text-xs-left">{{ props.item.waste_code }}</td>
         <td class="text-xs-left">{{ props.item.type_id }}</td>
        <td class="text-xs-left">{{ props.item.active }}</td>
        <td class="justify-center layout px-0">

            <v-btn icon  @click="edit_item(props.item)" >
                <v-icon>edit</v-icon>
            </v-btn>

            <v-btn  icon @click="delete_item(props.item)" >
                <v-icon>delete</v-icon>
            </v-btn>
        </td> 
      </template>
<!--       <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Eliminar</v-btn>
      </template> -->
    </v-data-table>
  </div>
</template>

<script>

  import Vue from 'vue';  
  import Vuex from 'vuex'; 
  import { mapState } from 'vuex'; 
  
  import { EventBus } from './../eventbus.js'

  export default {
    data: () => ({
      dialog: false,
      headers: [
        {
          text: 'Número de Residuo',
          align: 'left',
          sortable: false,
          value: 'waste_number'
        },
        { text: 'Id Sub Capítulo', value: 'subchapter_id' },
        { text: 'Nombre', value: 'name' },
        { text: 'Código de Residuo', value: 'waste_code' },
        { text: 'Tipo de Residuo', value: 'type_id' },
        { text: 'Activo', value: 'active' },
        { text: 'Acciones', value: 'actions' },
      ],
      lerwaste: [],
      editedIndex: -1,
      editedItem: {
        waste_number: 0,
        subchapter_id: 0,
        name: '',
        waste_code: 0,
        type_id: 0,
        active: 0
      },
      defaultItem: {
        waste_number: 0,
        subchapter_id: 0,
        name: '',
        waste_code: 0,
        type_id: 0,
        active: 0
      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Nuevo Registro' : 'Editar Registro'
      }
    },

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    created () {
      this.initialize()
      this.getlerwaste();
    },

    methods: {
      initialize () {
        this.lerwaste = []
      },

      getlerwaste(){
          var app = this;
          axios.get('/api/lerwaste')
              .then(function (resp) {
                  console.log(resp.data);    
                  app.lerwaste = resp.data;
              })
              .catch(function (resp) {
                  console.log(resp);
                  alert("Error lerwaste/index :" + resp);
              });
      },

      edit_item (item) {
        this.editedIndex = this.lerwaste.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },


      delete_item(item){
        var app = this;
        const index = this.lerwaste.indexOf(item)

        const lerwasteid = this.lerwaste[index]["id"];
        
        alert(this.lerwaste[index]["id"]);


        if (confirm('¿Está seguro de eliminar el registro?')){
          
          axios.post('/api/lerwaste/delete/'+lerwasteid)
              .then(function (resp) {  
                  app.lerwaste.splice(index, 1)
              })
              .catch(function (resp) {
                  console.log(resp);
                  alert("Error lerwaste/index :" + resp);
          });
          } else {
            alert("no hay nada que borrar")
          }
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      toSave() {

        var app = this;

        if (this.editedIndex > -1) {
          Object.assign(this.lerwaste[this.editedIndex], this.editedItem)
        } 
        //else {
        //  this.lerwaste.push(this.editedItem)
        //}
        
        var lerwaste = this.editedItem;
         
        axios.post('/api/lerwaste/store', {lerwaste: lerwaste})
            .then(function (resp) {    
                alert('Registro Grabado Correctamente!!');
                app.lerwaste.push(resp.data);
                EventBus.$emit('savelerwaste', 'someValue');
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error lerwaste/store :" + resp);
            });
        this.close()
      }
    }
  }
</script>