<script setup>
  import { ref, computed, onMounted, onUnmounted } from 'vue'

  import Login from './components/Login.vue';
  import NewUser from './components/NewUser.vue';
  import CommentForm from './components/CommentForm.vue';
  import Comments from './components/Comments.vue';
  import userComments from './components/userComments.vue';

  // Lomakkeiden vaihtumisten välillä on otettu mallia
  // https://vuejs.org/guide/scaling-up/routing esimerkistä.
  const routes = {
    '/': Login,
    '/uusi': NewUser
  }

  const currentPath = ref(window.location.hash)

  window.addEventListener('hashchange', () => {
    currentPath.value = window.location.hash
  })

  const currentView = computed(() => {
    return routes[currentPath.value.slice(1) || '/'] || Login
  })


  // Katsotaan löytyykö käyttäjää localStoragesta.
  const user = ref()
  const checkUser = () => {
    user.value = localStorage.getItem('user')
  } 

  onMounted(() => {
    // Tarkistetaan sivun ladattaessa 
    checkUser()

    // Kuunnellaan jos jokin komponetti tekee muutoksia localStorageen.
    window.addEventListener('storage', checkUser)
  })

  onUnmounted(() => {
    window.removeEventListener('storage', checkUser)
  })

</script>

<template>
  <div class="main">

    <div>
      <a href="#/"> Kirjaudu sisään </a> |
      <a href="#/uusi"> Luo uusi käyttäjä </a> |
      <component :is="currentView" />
    </div>

    <div v-if="user">
      <CommentForm />
      <userComments />
    </div>

    <Comments />
  </div>
</template>
