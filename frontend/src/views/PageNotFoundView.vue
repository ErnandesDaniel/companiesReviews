<template>

  <p>Извините, данной страницы не существует</p>

  <router-link to="/" replace>На главную</router-link>

</template>

<style scoped>


p{

  width:80%;
  min-height:30px;
  margin-left:auto;
  margin-right:auto;
  text-align:center;
  margin-top:40px;
  font-size: min(calc(18px + 8 * ((100vw - 320px) / (1280 - 320))), 24px);
  color:white;

}


a{

  width:60%;
  max-width:180px;
  height:60px;
  margin-left:auto;
  margin-right:auto;
  display:flex;
  justify-content:center;
  align-items:center;
  background:rgb(255,193,52);
  border-radius:10px;
  margin-top:20px;
  font-size: min(calc(16px + 8 * ((100vw - 320px) / (1280 - 320))), 24px);

}


</style>