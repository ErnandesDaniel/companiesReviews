import { createRouter, createWebHistory } from 'vue-router'
import EnterView from '@/views/EnterView.vue'
import RegisterView from '@/views/RegisterView.vue'
import CompaniesListView from '@/views/CompaniesListView.vue'
import CompanyView from '@/views/CompanyView.vue'
import PageNotFoundView from '@/views/PageNotFoundView.vue'
import CreateCompanyView from '@/views/CreateCompanyView.vue'

import { useGeneralCondition } from "@/stores/generalCondition.js";

//Список маршрутов:
const routes = [
  
 {
    path: '/',
    name: 'companiesList',
    component: CompaniesListView
  },


  {
    path: '/createcompany',
    name: 'createCompany',
    component: CreateCompanyView
  },


  {
    path: '/enter',
    name: 'enter',
    component: EnterView
  },


  {
    path: '/register',
    name: 'register',
    component: RegisterView
  },


  {
    path: '/company/:id',
    name: 'company',
    component: CompanyView
  },

  {

    path: '/:pathMatch(.*)*',
    name: 'not-found',
    alias: '/404',
    component: PageNotFoundView
  } ,

]

const router = createRouter({
  
  history: createWebHistory(),

  routes
})


router.beforeEach((to, from) => {

  let  generalCondition=useGeneralCondition();

  if(generalCondition.authorizationStatus==true){

    if(to.name=='enter'){return { name: from.name, replace: true }}

    if(to.name=='register'){return { name: from.name, replace: true }}

  }else{

    if(to.name=='company'){return { name: from.name, replace: true }}

    if(to.name=='createCompany'){return { name: from.name, replace: true }}

  }

})


export default router
