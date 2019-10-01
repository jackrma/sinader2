import App from './views/App.vue'
import Vue from 'vue';
import VueRouter from 'vue-router'

import Welcome    from './views/Welcome'
import RequisitionList    from './views/RequisitionListView'


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Welcome,
        },
        {
            path: '/app',
            name: 'app',
            component: App,
        },
        {
            path: '/welcome',
            name: 'welcome',
            component: Welcome,
        },
        {
            path: '/requisition_list',
            name: 'requisition_list',
            component: RequisitionList,
        },

        
    ],
});


export default router;