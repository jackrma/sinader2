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
	    company: '',
	    residue:'',
	    carrier:'',

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
		changeCompany(state, company) {
		   	state.company = company;
		},
		changeResidue(state, residue) {
		   	state.residue = residue;
		},
		changeCarrier(state, carrier) {
		   	state.carrier = carrier;
		},
	},
	getters: {
		type: state => state.type,
		token: state => state.token,
		establishment: state => state.establishment, 
		user: state => state.user,
		company: state => state.company,
		residue: state => state.residue,
		carrier: state => state.carrier,
	},
    plugins: [
    	createPersistedState()
  	]
});