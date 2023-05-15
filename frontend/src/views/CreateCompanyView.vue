<template>
  <div class="Page">

    <p>Название</p>
    <input type='text' v-model='name'>

    <p>ИНН</p>
    <input type='text' v-model='INN'>

    <p>Общая информация</p>
    <textarea v-model='generalInformation'></textarea>

    <p>Генеральный директор</p>
    <input type='text' v-model='generalDirector'>

    <p>Адрес</p>
    <input type='text' v-model='address'>

    <p>Телефон</p>
    <input type='text' v-model='telephone'>

    <button v-on:click='createCompany'>Добавить компанию</button>

    <div v-if='errorExist==true || visibleSuccessMessage==true' class='error'>{{errorMessage}}</div>

  </div>
</template>

<script>

import InformationField from '@/components/InformationField.vue'
import { useGeneralCondition } from "@/stores/generalCondition.js";

export default {
  name: 'HomeView',
  components:{InformationField,},

  setup(){

    const generalCondition=useGeneralCondition();

    return{generalCondition}

  },

  data(){
    return{

      name:'',
      INN:'',
      generalInformation:'',
      generalDirector:'',
      address:'',
      telephone:'',
      errorMessage:'',
      errorExist:false,
      visibleSuccessMessage:false,

    }
  },

  watch:{

    name(){this.errorExist=false},
    INN(){this.errorExist=false},
    generalInformation(){this.errorExist=false},
    generalDirector(){this.errorExist=false},
    address(){this.errorExist=false},
    telephone(){this.errorExist=false},

  },

  methods:{

    createCompany(){

      if(this.name=='' && this.errorExist==false){this.errorMessage='Введите имя компании';this.errorExist=true; this.visibleSuccessMessage=false}

      if(this.INN=='' && this.errorExist==false){this.errorMessage='Введите ИНН компании';this.errorExist=true; this.visibleSuccessMessage=false}

      if(this.generalInformation=='' && this.errorExist==false){this.errorMessage='Введите общую информацию об компании';this.errorExist=true; this.visibleSuccessMessage=false; this.visibleSuccessMessage=false}

      if(this.generalDirector=='' && this.errorExist==false){this.errorMessage='Введите имя генерального директора компании';this.errorExist=true; this.visibleSuccessMessage=false}

      if(this.address=='' && this.errorExist==false){this.errorMessage='Введите адресс компании';this.errorExist=true; this.visibleSuccessMessage=false}

      if(this.telephone=='' && this.errorExist==false){this.errorMessage='Введите телефон компании';this.errorExist=true; this.visibleSuccessMessage=false}


      if(this.errorExist==false){

        let url='addCompany.php';

        let data={

          name:this.name,
          inn:this.INN,
          general_information:this.generalInformation,
          general_director:this.generalDirector,
          address:this.address,
          telephone:this.telephone,
          token:localStorage.getItem("authorizationToken"),

        };

          this.$axios.post(url,data).then(response =>{

          if(response.data.actionCompleted==true && response.data.message=='companyWasAdded'){
            
            this.errorMessage='Компания ' + this.name + ' добавлена';
            this.visibleSuccessMessage=true;

            this.name='';
            this.INN='';
            this.generalInformation='';
            this.generalDirector='';
            this.address='';
            this.telephone='';

            //После добавления компании в базу данных обновляем локальный список компаний 

            this.generalCondition.getCompanyList();

          }else if(response.data.actionCompleted==false && response.data.message=='userNotFound'){

            alert('Ошибка: '+response.data.message);

          }

          }).catch(error => console.log(error));

      }

    }

  }

}
</script>



<style scoped>

  .Page{

    padding-left:5px;
    width:90%;
    margin-left:auto;
    margin-right:auto;

  }


 p{

    font-size: calc(16px + 3 * ((100vw - 320px) / (1280 - 320)));
    margin-top:5px;


 } 



input{

  height:30px;
  width:max(70%,220px);
  margin-top:5px;
  font-size: calc(16px + 3 * ((100vw - 320px) / (1280 - 320)));
  padding-left:5px;



}

textarea{

  height:60px;
  width:max(70%,220px);
  margin-top:5px;
  font-size: calc(16px + 3 * ((100vw - 320px) / (1280 - 320)));
  resize:none;
  padding-left:5px;

}


button{

  font-size: calc(16px + 3 * ((100vw - 320px) / (1280 - 320)));

  height:30px;
  width:200px;
  font-size:18px;
  display:flex;
  justify-content:center;
  align-items:center;
  background:rgb(255,193,52);
  border-radius:10px;
  margin-top:10px;

}



.error{

  margin-top:10px;
  width:70%;
  font-size: calc(16px + 8 * ((100vw - 320px) / (1280 - 320)));
  color:white;

}


@media (max-width: 550px) {


  .Page{

    padding-left:0px;
    display:flex;
    flex-direction:column;
    align-items:center;

  }

  p{

    width:max(70%,220px);

 }



.error{

   width:max(70%,220px);
}



}


















</style>
