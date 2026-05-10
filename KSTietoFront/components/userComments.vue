<script setup>
import { ref, onMounted } from 'vue'
// Axios on jo entuudestaan tuttu, joten käytetään sitä.
import axios from 'axios'

// Käyttäjän omien kommentien URL.
const baseUrl = 'http://localhost/KStieto/privateComments.php'
const comments = ref([])

// Kovakoodataan käyttäjä väliaikaisesti testaamista varten.

const fetchComments = async () => {
    try {
        const response = await axios.post(
            baseUrl,
            {
                userId: 1
            }
        )

        comments.value = response.data
    } catch (error) {
        console.error('Error fetching comments:', error)
    }
}

onMounted(() => {
    fetchComments()
})

</script>

<template>
    <div class="privateComments">
        <h2>My Comments</h2>
        <ul>
            <li
                v-for="comment in comments"
                :key="comment.id"
            >
                {{ comment.content }}
            </li>
        </ul>
    </div>
</template>
