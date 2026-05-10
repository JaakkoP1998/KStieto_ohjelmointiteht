<script setup>
  import axios from 'axios'
  import { ref, onMounted } from 'vue'

  const baseUrl = 'http://localhost/KStieto/login.php'
  const user = ref([])
  
  const submit = async () => {
    
    try {
        const response = await axios.post(
            baseUrl,
            {
                username: "Roope"
            }
        )

        user.value = response.data
    } catch (error) {
        console.error('Error fetching user:', error)
    }

    console.log(user)
  }
</script>

<template>
  <div class="loginForm">
    <h2>Login</h2>
    <form @submit.prevent="submit">
      <div>
            <label>
                username
                <input
                type="text"
                />
            </label>
        </div>
        <div>
            <label>
                password
                <input
                type="password"
                />
            </label>
        </div>
        <button type="submit"> Login </button>
    </form>
  </div>
</template>
