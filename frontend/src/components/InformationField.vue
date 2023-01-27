<template>

  <div class='Field'>

    <p class='name'>{{name}}</p>

    <p class='value'>{{value}}</p>

    <div class='toggleAction'>

      <button v-on:click='toggleAction'>{{nameOfAction}}</button>

      <img src='@/assets/chatIcon.jpg' class='chatIcon'>

    </div>

    <textarea v-if="nameOfAction=='Отменить комментарий'" v-model='commentValue'></textarea>

    <button v-on:click='sendComment' class='sendComment'
    v-if="nameOfAction=='Отменить комментарий'">Отправить комментарий</button>

    <div class='commentsList'>

      <div v-for='comment in commentsList' class='comment'>

        <span>{{comment.time + ' '}}</span>
        <span>{{comment.login + ': '}}</span>
        <span>{{comment.content + ' '}}</span>
        
      </div>
      
    </div>

  </div>


</template>

<script>

export default {

  props:{

    name:String,
    value:String,
    type:String,
    commentsList:Array,
  },

  emits:['sendComment'],

  data(){

    return{

      nameOfAction:'Прокомментировать',
      commentValue:'',
    }
  },

  created(){

    if(this.type=='common'){

      this.nameOfAction='Прокомментировать компанию';

    }

  },

  methods:{

    toggleAction(){

      if(this.nameOfAction=='Прокомментировать'||this.nameOfAction=='Прокомментировать компанию'){

        this.nameOfAction='Отменить комментарий';
        this.commentValue='';

      }else if(this.nameOfAction=='Отменить комментарий'){

        if(this.type=='common'){

          this.nameOfAction='Прокомментировать компанию';

        }else{

          this.nameOfAction='Прокомментировать';

        }

        this.commentValue='';

      }

    },

    sendComment(){

      if(this.commentValue!=''){

        this.$emit('sendComment', {name:this.name, value:this.commentValue, type:this.type});
      }
    },

  },
  
}



</script>


<style scoped>

  .Field{

    width:100%;
    min-height:40px;
    display:block;
    position:relative;
    margin-bottom:20px;
    padding-left:15px;

  }

  p{
    display:flex;
    align-items:center;
    font-size:18px;

  }


  .name{
    
     color:rgb(255,193,52);

  }

  .value{

    color:white;
    margin-top:5px;

  }

  .toggleAction{

    position:absolute;
    right:10px;
    top:0px;

    display:flex;
  }


 .toggleAction>button{

    background:none;
    color:white;
    font-size:16px;
    color:rgb(179,183,184);

  }


  .toggleAction>.chatIcon{

    display:block;
    height:20px;
    width:auto;
    margin-left:3px;

  }

  textarea{

    resize:none;
    font-size:18px;
    padding-left:5px;
    padding-top:2px;
    width:max(90%, calc(100% - 30px));
    margin-right:15px;
    margin-top:5px;

    height:50px;
  }


  .sendComment{

    height:30px;
    width:200px;
    font-size:18px;
    display:flex;
    justify-content:center;
    align-items:center;
    background:rgb(255,193,52);
    border-radius:10px;
    margin-top:5px;


  }

  .commentsList{

    margin-top:10px;
    margin-left:10px;
    font-size:16px;
    color:rgb(179,183,184);


  }

  @media(max-width:450px){

    .toggleAction{

      position: static;
      margin-top:5px;

    }

  }

</style>
