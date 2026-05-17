<script setup>
    // Tämä on lista kaikista käyttäjistä ja heidän kommenteista, joihin vain ylläpitäjällä (adminilla) on pääsy.
    // Pääkäyttäjä pystyy poistamaan kommentteja ja käyttäjiä tämän näkymän kautta.
    // Omasta mielstä ei ole kovin turvallista toteuttaa samassa käyttöliittymässä kuin normikäyttäjät,
    // mutta tehdään kuitenkin tehtävän annon mukaan.

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

  const deleteUser = async (userid) => {
    try {
        const response = await axios.post(
            'http://localhost/KStieto/deleteUser.php',
            {
                id: userid
            }
        )

        alert(response.data)
        // Päivitetään näkymä
        fetchUsersComments()

    } catch (error) {
        console.error('Error deleting user:', error)
    }
  }

</script>

<template>
  <div>
    <h1> Käyttäjät ja kommentit </h1>

    <div v-for="user in users" :key="user.id" class="adminViewBox">
      <h2>{{ user.username }}</h2> <button @click="deleteUser(user.id)"> Poista käyttäjä </button>

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