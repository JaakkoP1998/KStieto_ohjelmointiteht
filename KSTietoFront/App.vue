<script setup>
import Login from './components/Login.vue';
import Comments from './components/Comments.vue';
import userComments from './components/userComments.vue';
</script>

<template>
  <div class="main">
    <Login></Login>
    <userComments/>
    <Comments/>
  </div>
</template>
