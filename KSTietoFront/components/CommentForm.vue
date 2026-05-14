<script setup>
import axios from 'axios'
import { ref } from 'vue'
const baseUrl = 'http://localhost/KStieto/newComment.php'
const content = ref("")
const publicComment = ref(0)

const emit = defineEmits(['comment-added'])

const submit = async () => {
    try {

        // Haetaan kirjautuneen käyttäjän id.
        const userid = JSON.parse(localStorage.getItem('user')).id

        const response = await axios.post(
            baseUrl,
            {
                content: content.value,
                userid: userid,
                public: publicComment.value
            }
        )
        
        // Ilmoitetaan jos kommentin lisäämisessä on ongelma.
        if (response.data.error) {
            alert(response.data.error)
            return
        }

        // Tyhjennetään lomakkeen kentät
        content.value = ""
        publicComment.value = 0

        // Kommenttien päivitystä varten ilmoitetaan App-komponentille,
        // että kommentti on lisätty.
        emit('comment-added')
        
    } catch (error) {
        console.error('Error adding comment:', error)
    }

}
</script>

<template>
    <div class="commentForm">
        <h2> Kommentoi </h2>
    <form @submit.prevent="submit">
      <div>
            <label> 
                Kommentti
                <input type="text" v-model="content"/>
            </label>
            <label> Julkinen: 
                <input
                    type="checkbox"
                    v-model="publicComment"
                    true-value=1
                    false-value=0 />
            </label>
        </div>
        <button type="submit"> Tallenna </button>
    </form>
    </div>
</template>
