<script setup>
    import axios from 'axios'
    import { ref, onMounted } from 'vue'

    const baseUrl = 'http://localhost/KStieto/login.php'
    const username = ref("")
    const password = ref("")
    const user = ref()
    
    const submit = async () => {
        try {
            const response = await axios.post(
                baseUrl,
                {
                    username: username.value
                }
            )
            
            // Ilmoitetaan jos käyttäjän hakemisessa oli ongelmia.
            if (response.data.error) {
                alert(response.data.error)
                return
            }

            user.value = response.data
        } catch (error) {
            console.error('Error fetching user:', error)
        }
        //console.log(user)
    }
</script>

<template>
  <div class="loginForm">
    <h2> Kirjaudu sisään </h2>
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
        <button type="submit"> Kirjaudu sisään </button>
    </form>
  </div>
  <h3 v-if="username"> {{username}} on kirjautunut sisään. </h3>
</template>
