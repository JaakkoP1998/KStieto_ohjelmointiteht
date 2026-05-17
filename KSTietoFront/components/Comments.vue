<script setup>
import { ref, onMounted, defineExpose } from 'vue'
import axios from 'axios'

const publicComments = ref([])
const privateComments = ref([])

// Käyttäjän id on annettu propsina App-komponentissa
const props = defineProps({
  userId: {
    type: [String, Number], 
    required: true
  }
})

// Haetaan julkiset kommentit
const fetchComments = async () => {
    try {
        const response = await axios.get('http://localhost/KStieto/publicComments.php')

        publicComments.value = response.data
    } catch (error) {
        console.error('Error fetching public comments:', error)
    }

    try {
        const response = await axios.post(
            'http://localhost/KStieto/privateComments.php',
            {
                userId: props.userId
            }
        )

        privateComments.value = response.data
    } catch (error) {
        console.error('Error fetching private comments:', error)
    }
}

// Annetaan parent-komponentin päästä käsiksi fetchComments-funktioon.
defineExpose({
    fetchComments
})

onMounted(() => {
    fetchComments()
})

// Functio joka hoitaa kommenttien julkisuuden muuttumisen.
const publishComment = async (id) => {
    try {
        const response = await axios.post(
            'http://localhost/KStieto/updatePublicity.php',
            {
                commentId: id
            }
        )

        alert(response.data)
        // Päivitetään kommentit
        fetchComments()

    } catch (error) {
        console.error('Error publishing comment:', error)
    }
}


</script>

<template>
    <!-- Käyttäjän omat henkilökohtaiset kommentit. 
     Kommenteissa on kiinni painike, jolla komentit voi julkaista, jos kommentti ei 
     ole jo julkinen. -->
    <div class="privateComments">
        <h2> Omat kommentit </h2>
        <ul>
            <li
                v-for="comment in privateComments"
                :key="comment.id" >
                {{ comment.content }}
                <button 
                    @click="publishComment(comment.id)"
                    v-if="comment.public == 0">
                    Julkaise 
                </button>
            </li> 
        </ul>
    </div>
    <div class="publicComments">
        <h2> Julkiset kommentit </h2>
        <ul>
            <li v-for="comment in publicComments" :key="comment.id">
                {{ comment.content }}
            </li>
        </ul>
    </div>
</template>
