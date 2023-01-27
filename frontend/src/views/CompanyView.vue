<template>

  <div class="Page">

    <InformationField name='Название' type='name' ref='name' :value='fieldList.name' v-on:sendComment='sendComment' :commentsList="comments('name')"/>

    <InformationField name='ИНН' type='inn' ref='inn' :value='fieldList.inn' v-on:sendComment='sendComment'
    :commentsList="comments('inn')"/>

    <InformationField name='Общая информация' type='general_information' ref='general_information'
    :value='fieldList.general_information' v-on:sendComment='sendComment' 
    :commentsList="comments('general_information')"/>

    <InformationField name='Генеральный директор' type='general_director' ref='general_director'
    :value='fieldList.general_director' v-on:sendComment='sendComment' 
    :commentsList="comments('general_director')"/>

    <InformationField name='Адрес' type='address' ref='address' :value='fieldList.address' v-on:sendComment='sendComment' :commentsList="comments('address')"/>

    <InformationField name='Телефон' type='telephone' ref='telephone' 
    :value='fieldList.telephone' v-on:sendComment='sendComment' :commentsList="comments('telephone')"/>


    <InformationField name='Общие комментарии' type='common' ref='common' 
    :value='null' v-on:sendComment='sendComment' :commentsList="comments('common')"/>

  </div>


</template>

<script>

import InformationField from '@/components/InformationField.vue'
import { useGeneralCondition } from "@/stores/generalCondition.js";

export default {

  components:{InformationField,},

  setup(){

    const generalCondition=useGeneralCondition();

    return{generalCondition}

  },


  data(){
    return{

      fieldList:[],

      ListOfAllComments:[],

    }
  },

  created(){

    this.getAllDataOfCompany();

  },

  methods:{

    getAllDataOfCompany(){

      let url='getAllInformationAboutCompany.php';

      let data={

        company_id:this.$route.params.id,
        token:localStorage.getItem("authorizationToken"),

      };

      this.$axios.post(url,data).then(response =>{

        console.log(response.data);

        if(response.data.actionCompleted==true && response.data.message=='allInformationAboutCompany'){
        
        this.fieldList=response.data.content[0];

        this.ListOfAllComments=response.data.content[0].comments;

        }else if(
          response.data.actionCompleted==false && response.data.message=='companyNotExist'
          ){

            //Если сервер выдал ошибку и такой компании не существует, то перенаправляем пользователя
            //на страницу с ошибкой
            this.$router.replace('/404');
          }

      }).catch(error => console.log(error));

    },

    sendComment(fieldInformationObject){

        let url='addComment.php';
        let data={

          company_id:this.$route.params.id,
          token:localStorage.getItem("authorizationToken"),
          comment_type:fieldInformationObject.type,
          content:fieldInformationObject.value

        };

        this.$axios.post(url,data).then(response =>{

          if(response.data.actionCompleted==true && response.data.message=='commentWasAdded'){

            this.$refs[fieldInformationObject.type].toggleAction();
            this.getAllDataOfCompany();

          }else if(response.data.actionCompleted==false && response.data.message=='userNotFound'){

            alert('Ошибка: '+response.data.message);

          }

      }).catch(error => console.log(error));

    },

    comments:function(nameOfFiledType){

      if(this.ListOfAllComments!=null){

        return this.ListOfAllComments.filter(

          (comment)=>{

            if(comment.comment_type==nameOfFiledType){

              return true;

            }else{

              return false
            }

          });

      }else{ 

          return null;
      }

    }

  },

}
</script>


<style scoped>

.Page{

  padding-top:20px;
  width:90%;
  margin-left:auto;
  margin-right:auto;

}

</style>
