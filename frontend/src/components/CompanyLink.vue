<template>

  <div class='Block'>

    <div>

      <p class='NameOfCompany' v-on:click='relocation' v-bind:style="linkVisibility">{{name}}</p>

      <p v-on:click='relocation' v-bind:style="linkVisibility">Адрес: {{address}}</p>

      <p v-on:click='relocation' v-bind:style="linkVisibility">Телефон: {{telephone}}</p>

      <p v-on:click='relocation' v-bind:style="linkVisibility">Генеральный директор: {{general_director}}</p>

    </div>

    <img class='deleteCompany' src='@/assets/deleteCompany.jpg' v-if='editable'  v-on:click='removeCompany'>

  </div>

</template>

<script>

import { useGeneralCondition } from "@/stores/generalCondition.js";

export default {

  setup(){

      const generalCondition=useGeneralCondition();

      return{generalCondition}

  },

  props:{

    id:String,
    name:String,
    address:String,
    telephone:String,
    general_director:String,
    editable:Boolean,
    index:Number,

  },

  emits: ["deleteCompany"],

  computed:{

    linkVisibility(){

      let cursorValue='';

      if(this.generalCondition.authorizationStatus==true){

        cursorValue='pointer';
     
      }

      return{cursor:cursorValue}

    },

  },

methods:{

  relocation(){

    if(this.generalCondition.authorizationStatus==true){

      this.$router.push('company/'+this.id);

    }
  

  },

  removeCompany(){

    let url='deleteCompany.php';
    let data={

      company_id:this.id,
      token:localStorage.getItem("authorizationToken"),

    };

  
    this.$axios.post(url,data).then(response =>{
      console.log(response.data);

      if(response.data.actionCompleted==true && response.data.message=='companyWasDeleted'){

        this.$emit('deleteCompany', this.index);

      }else if(response.data.actionCompleted==false && response.data.message=='userNotFound'){

        alert('Ошибка: '+response.data.message);

      }

    }).catch(error => console.log(error));


  },

}


}
</script>


<style scoped>

  .Block{

    width:100%;
    display:block;
    position:relative;

  }

  .Block>div{

    width:calc(100% - 30px);

  }

  
  p{


    font-size:20px;
    color:white;
    line-height:22px;

  }

  .NameOfCompany{

    font-weight:bold;
    color:rgb(255,193,52);

  }

  .deleteCompany{
    height:15px;
    width:auto;
    position:absolute;
    top:3px;
    right:0px;
    cursor:pointer;

  }

</style>
