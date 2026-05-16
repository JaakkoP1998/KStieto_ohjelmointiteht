<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

import Login from './components/Login.vue';
import NewUser from './components/NewUser.vue';
import CommentForm from './components/CommentForm.vue';
import Comments from './components/Comments.vue';
import Admin from './components/Admin.vue';

const user = ref()
const commentsRef = ref(null)

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
const checkUser = () => {
  // Localstorage tallentaa vain string-muodossa
  const storedUser = localStorage.getItem('user')

  // Jos käyttäjä löytyy asetetaan se ref:iin, muuten pidetään tyhjänä.
  if (storedUser) {
    user.value = JSON.parse(storedUser)
  } else {
    user.value = null
  }
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

// Kirjaudutaan ulos poistamalla käyttäjä lokaalista muistista
// ja ladataan sivu uudelleen.
const logOut = () => {
  localStorage.removeItem('user')
  location.reload();
}

// Kommenttien päivitys käyttöliittymässä, kun uusi kommentti lisätään
const refreshComments = () => {
    commentsRef.value?.fetchComments()
}

</script>

<template>
  <div class="main">

    <div v-if="!user" class="loginForms">
      <a href="#/"> Kirjaudu sisään </a> |
      <a href="#/uusi"> Luo uusi käyttäjä </a> |
      <component :is="currentView" />
    </div>
    <div v-else> 
      <h3> {{ user.username }} on kirjautunut sisään. </h3>
      <button @click="logOut"> Kirjaudu ulos </button>
      <CommentForm @comment-added="refreshComments" />
      <Comments :userId="user.id" ref="commentsRef" />
    </div>
    <Admin />

  </div>
</template>
