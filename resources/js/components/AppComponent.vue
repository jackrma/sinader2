<template>
  <v-app id="inspire">

    <v-navigation-drawer
      :clipped="$vuetify.breakpoint.lgAndUp"
      v-model="drawer"
      fixed
      app
      class="side_bar_gray"
    >
      <v-list class="white--text"  dense>
        <template v-for="item in items">
          <v-layout
            v-if="item.heading"
            :key="item.heading"
            :to="item.link"
            row
            align-center
          >
            <v-flex xs4>
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-flex>

          </v-layout>
          <v-list-group
            v-else-if="item.children"
            v-model="item.model"
            :key="item.text"
          >
            <v-list-tile slot="activator" active-class="secondary_green--text">
              <v-list-tile-content>
                <v-list-tile-title>
                  {{ item.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
              v-for="(child, i) in item.children"

              :key="i"
              @click=""
            >
            </v-list-tile>
          </v-list-group>
          <v-list-tile  active-class="secondary_green--text" :to="item.link" v-else :key="item.text" @click="">

            <v-list-tile-content>
              <v-list-tile-title>
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider color="white"></v-divider>
        </template>
      </v-list>
    </v-navigation-drawer>



    <v-toolbar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      color="main_green"
      app
      fixed
      class="pl-0"
      style="padding-left: 0px"
    >
      <v-btn
        color="side_bar_gray"
        dark
        class="bold--text"
        style="position:relative; height: 100%"
        @click.stop="drawer = !drawer"
      >
        SINADER
      </v-btn>
      <v-toolbar-title class="ml-0 pl-3 white--text">
        <!-- <span class="hidden-md-and-down">SINADER</span> -->
        </v-toolbar-title>        
        <v-spacer></v-spacer>
      </v-toolbar-title>

        <!-- <p>Empresa: {{$store.getters.company.name}}</p>  -->
        

      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon color="white">account_circle</v-icon>
      </v-btn>
    </v-toolbar>

    <v-content>
      <v-container fluid>
        <!-- COntenido -->
        <div class="container">
          <router-view></router-view>
        </div>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  import Vue from 'vue'; 
  import router  from './../routes';
  export default {
    data: () => ({
      dialog: false,
      drawer: null,
      step:"",
      establishment: null,
      naturalStates:[],
      items: [
        { icon: 'contacts', text: 'Bienvenida', link: '/welcome' },
        { icon: 'declaration', text: 'Declaraciones', link: '/declarations' },
        { icon: 'wrap_text', text: 'Administrar Solicitudes', link: '/requisition_list'},     
        { icon: 'wrap_text', text: 'Preguntas Frecuentes', link: '/'},
        { icon: 'wrap_text', text: 'Tutoriales', link: '/'},
      ]
    }),
    created () {
      
    },
    methods: {



    }
}
</script>