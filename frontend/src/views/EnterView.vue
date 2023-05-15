<template>

  <div class='Page'>

    <form class='form' onsubmit="return false;">

      <input type='text' placeholder='Логин' v-model='login' name='username'>

      <input type='password' placeholder='Пароль' v-model='password' name='password'>

      <button v-on:click='Enter'>Войти</button>

      <div class='Error' v-if='errorIsVisible'>{{errorMessage}}</div>

    </form>


  </div>

</template>

<script>

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
      errorIsVisible:false,
      errorMessage:'Неверный логин или пароль',

    }
  },


 
  watch:{

    login(){this.errorIsVisible=false;},

    password(){this.errorIsVisible=false;},

  },

  methods:{

    Enter:function(){

        let url='enter.php';
        let data={login:this.login  ,password:this.password};
        this.$axios.post(url,data).then(response =>{
          console.log(response.data);

          if(response.data.actionCompleted==true && response.data.message=='userFound'){

            //Устанавливаем НОВЫЙ токен в локальную память
            localStorage.setItem('authorizationToken', response.data.content);
            //Устанавливаем НОВЫЙ токен в память магазина
            this.generalCondition.setAuthenticationToken(response.data.content);
            //Устанавливаем статус авториации true
            this.generalCondition.setAuthorizationStatus(true);
            //Загружаем список редактируемых и нередактируемых компаний (полностью обновляем список)
            this.generalCondition.getCompanyList();
            //Переходим на главную страницу
            this.$router.replace('/');

          }else if(response.data.actionCompleted==false && response.data.message=='userNotFound'){

            this.errorIsVisible=true;
            this.errorMessage='Неверный логин или пароль';

          }

        });

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

/*Настраиваем стили при автозаполнении*/
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {

  -webkit-text-fill-color: white;/* цвет текста */


  -webkit-box-shadow: 0 0 0 0 rgb(107,117,125),   /* ваш box-shadow для :focus */

  inset 0 0 0   50px rgb(107,117,125);  /* цвет вашего фона */

}


.Page>.form>input,button{

  margin-top:15px;
  margin-bottom:15px;
  width:80%;
  font-size:20px;
  border-radius:10px;
  padding-left:10px;

  font-size: calc(16px + 8 * ((100vw - 320px) / (1280 - 320)));

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