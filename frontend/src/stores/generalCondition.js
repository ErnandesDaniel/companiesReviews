import { defineStore } from 'pinia'

import axios from "axios"

import {axiosConfig} from '../assets/axios.js';

export const useGeneralCondition = defineStore('generalCondition',{

	state(){
		return{
			
			authorizationStatus:false,

			authenticationToken:'',

			companiesList:[],
		
		}
	},
	
	
	actions:{
		
		setAuthorizationStatus(newValue){
			
			this.authorizationStatus=newValue;
			
		},

		setAuthenticationToken(newValue){
			
			this.authenticationToken=newValue;
			
		},

		getCompanyList(){

		    //Основная страница список - компаний, поэтому эти данные будут загружаться при входе
		    let url=axiosConfig.baseURL+'getCompanyList.php';
		    let data={token:this.authenticationToken};
		    axios.post(url,data).then(response =>{

		    	console.log(response.data);

		      this.companiesList=response.data.content;

		    }).catch(error => console.log(error));

		},
	  
	},
	
})






