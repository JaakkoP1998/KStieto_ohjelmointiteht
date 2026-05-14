<script setup>
import { ref, onMounted, defineExpose } from 'vue'
// Axios on jo entuudestaan tuttu, joten käytetään sitä.
import axios from 'axios'

// Käyttäjän omien kommentien URL.
const baseUrl = 'http://localhost/KStieto/privateComments.php'
const comments = ref([])

// Käyttäjän id on annettu propsina App-komponentissa
const props = defineProps({
  userId: {
    type: [String, Number], 
    required: true
  }
})

console.log(props.userId)

// Kovakoodataan käyttäjä väliaikaisesti testaamista varten.
const fetchUserComments = async () => {
    try {
        const response = await axios.post(
            baseUrl,
            {
                userId: props.userId
            }
        )

        comments.value = response.data
    } catch (error) {
        console.error('Error fetching comments:', error)
    }
}

// Annetaan parent-komponentin päästä käsiksi fetchComments-funktioon.
defineExpose({
    fetchUserComments
})

onMounted(() => {
    fetchUserComments()
})

</script>

<template>
    <div class="privateComments">
        <h2> Omat kommentit </h2>
        <ul>
            <li
                v-for="comment in comments"
                :key="comment.id" >
                {{ comment.content }}
            </li>
        </ul>
    </div>
</template>
