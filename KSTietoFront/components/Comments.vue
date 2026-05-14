<script setup>
import { ref, onMounted, defineExpose } from 'vue'
// Axios on jo entuudestaan tuttu, joten käytetään sitä.
import axios from 'axios'

// Kommenttien URL backendissä.
const baseUrl = 'http://localhost/KStieto/publicComments.php'
const comments = ref([])

const fetchComments = async () => {
    try {
        const response = await axios.get(baseUrl)

        comments.value = response.data
    } catch (error) {
        console.error('Error fetching comments:', error)
    }
}

// Annetaan parent-komponentin päästä käsiksi fetchComments-funktioon.
defineExpose({
    fetchComments
})

onMounted(() => {
    fetchComments()
})

</script>

<template>
    <div class="publicComments">
        <h2> Julkiset kommentit </h2>

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
