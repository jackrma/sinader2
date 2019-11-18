import App from './views/App.vue'
import Vue from 'vue';
import VueRouter from 'vue-router'

import Welcome    from './views/Welcome'
import RequisitionList    from './views/RequisitionListView'
import Declaration    from './views/Declaration'
import Receive    from './views/Receive'

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
            path: '/declarations',
            name: 'declarations',
            component: Declaration,
        },
        {
            path: '/receive',
            name: 'receive',
            component: Receive,
        },
        {
            path: '/requisition_list',
            name: 'requisition_list',
            component: RequisitionList,
        },
        
    ],
});


export default router;