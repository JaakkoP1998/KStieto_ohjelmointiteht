<script setup>
    // TODO: Tämä on lista kaikista käyttäjistä ja heidän kommenteista, joihin vain pääkäyttäjällä on pääsy.
    // Pääkäyttäjä pystyy poistamaan kommentteja ja käyttäjiä tämän näkymän kautta.

    import axios from "axios";
    import { ref, onMounted } from "vue";

    const users = ref([])

    onMounted(() => {
        fetchUsersComments()
    })

   const  fetchUsersComments = async () => {
      try {
        const response = await axios.get(
          'http://localhost/KStieto/adminView.php'
        );

        users.value = response.data;

      } catch (error) {
        console.error(error);
      }
    }

</script>

<template>
  <div>
    <h1> Käyttäjät ja kommentit </h1>

    <div v-for="user in users" :key="user.id" class="adminViewBox">
      <h2>{{ user.username }}</h2>

      <ul v-if="user.comments.length">
        <li
          v-for="comment in user.comments"
          :key="comment.id">
          {{ comment.content }}
        </li>
      </ul>

      <p v-else> Käyttäjällä ei ole kommentteja </p>
    </div>
  </div>
</template>