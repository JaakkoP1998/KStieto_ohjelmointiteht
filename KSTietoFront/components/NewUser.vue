<script setup>
    import { ref, onMounted } from 'vue'
    const username = ref("")
    const password = ref("")


</script>

<template>
  <div class="loginForm">
    <h2> Luo uusi käyttäjä </h2>
    <form @submit.prevent="submit">
      <div>
            <label> 
                username
                <input type="text" v-model="username"/>
            </label>
        </div>
        <div>
            <label>
                password
                <input type="password" v-model="password"/>
            </label>
        </div>
        <button type="submit"> Login </button>
    </form>
  </div>
</template>
