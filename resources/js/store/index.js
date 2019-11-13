import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
import createPersistedState from 'vuex-persistedstate'



export default new Vuex.Store(
{
	state: {
	    token:'',
	    type:'',
	    establishment: '',
	    user: '',
	    declaration_id: 0,

	},
	mutations: {
		changeType(state, type) {
		    state.type = type;
		},
		changeToken(state, token) {
		    state.token = token;
		},
		changeEstablishment(state, establishment) {
		   	state.establishment = establishment;
		   //	state.currentCiiu = establishment.ciiu4.name;
		},
		changeUser(state, user) {
		   	state.user = user
		},
		changeDeclaration(state, declaration_id) {
		   	state.declaration_id = declaration_id
		},
	},
	getters: {
		type: state => state.type,
		token: state => state.token,
		establishment: state => state.establishment, 
		user: state => state.user,
		declaration_id: state=>declaration_id,
	},
    plugins: [
    	createPersistedState()
  	]
});