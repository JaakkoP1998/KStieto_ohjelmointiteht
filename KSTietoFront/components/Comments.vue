<script setup>
import { ref, onMounted } from 'vue'
// Axios on jo entuudestaan tuttu, joten käytetään sitä.
import axios from 'axios'

// Kommenttien URL backendissä.
const baseUrl = 'http://localhost/KStieto/index.php'
const comments = ref([])

const fetchComments = async () => {
    try {
        const response = await axios.get(baseUrl)

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
<div class="commentBox">
        <div class="myComments">
            <h2>Comments</h2>

            <ul>
                <li
                    v-for="comment in comments"
                    :key="comment.id"
                >
                    {{ comment.content }}
                </li>
            </ul>
        </div>
    </div>
</template>
