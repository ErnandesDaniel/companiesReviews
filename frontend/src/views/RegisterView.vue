<template>

  <div class='Page'>

    <div class='form'>

      <input type='text' placeholder='Логин' v-model='login'>

      <input type='password' placeholder='Пароль' v-model='password' autocomplete="new-password">

      <button v-on:click='Register'>Зарегистрироваться</button>

      <div class='Error' v-if='errorExist'>{{errorMessage}}</div>

    </div>

    {{info}}

  </div>

</template>

<script>

import axios from 'axios'
import { useGeneralCondition } from "@/stores/generalCondition.js";

export default {

  setup(){

    const generalCondition=useGeneralCondition();

    return{generalCondition}

  },

  data(){
    return{

      login:'',
      password:'',
      errorExist:false,
      errorMessage:'Неверный логин или пароль',
      info:'',

    }
  },

  watch:{

    login(){this.errorExist=false;},

    password(){this.errorExist=false;},

  },

  methods:{

    Register:function(){

      //Проверка на подключение к сети

      if(this.login=='' && this.errorExist==false){this.errorMessage='Введите логин';this.errorExist=true}



      if(this.password=='' && this.errorExist==false){this.errorMessage='Введите пароль';this.errorExist=true}

      if(this.password<6 && this.errorExist==false){this.errorMessage='Слишком короткий пароль';this.errorExist=true}


      if(this.errorExist==false){



          let url='registerNewUser.php';
          let data={login:this.login, password:this.password};

          this.$axios.post(url,data).then(response =>{
          console.log(response.data);


          if(response.data.actionCompleted==true && response.data.message=='userWasCreated'){
            //Устанавливаем токен в локальную память
            localStorage.setItem('authorizationToken', response.data.content);
            //Устанавливаем токен в память магазина
            this.generalCondition.setAuthenticationToken(response.data.content);
            //Устанавливаем статус авториации true
             this.generalCondition.setAuthorizationStatus(true);
             //Обновляем данные о компаниях
             this.generalCondition.getCompanyList();
            //Переходим на главную страницу
             this.$router.replace('/');

          }else if(response.data.actionCompleted==false && response.data.message=='loginIsUsed'){

            alert('Ошибка: '+response.data.message);

          }

          }).catch(error => console.log(error));
          
      }

    },


  },

}
</script>


<style scoped>

.Page{

  width:100%;
  height:100%;
  display:flex;
  justify-content:center;

}

.Page>.form{

  max-width:300px;
  width:80%;
  min-height:210px;
  height:min-content;
  margin-top:20vh;
  display:flex;
  flex-direction:column;
  align-items:center;
  border-radius:20px;
  border-style:solid;
  border-color:black;
  border-width:2px;

}



.Page>.form>input,button{

  margin-top:15px;
  margin-bottom:15px;
  width:80%;
  border-radius:10px;
  padding-left:10px;
  font-size: min(calc(16px + 8 * ((100vw - 320px) / (1280 - 320))), 22px);






  border-style:solid;
  border-color:black;
  border-width:2px;

  background:rgb(107,117,125);
  color:white;

}


.Page>.form>input:nth-of-type(1){
  margin-top:30px;

}


.Page>.form>input::placeholder{

  color:white;
  font-style:italic;

}


.Error{

  font-size:18px;
  font-size: calc(16px + 8 * ((100vw - 320px) / (1280 - 320)));
  margin-bottom:20px;
  width:80%;
  text-align:center;
  color:white;

}

</style>