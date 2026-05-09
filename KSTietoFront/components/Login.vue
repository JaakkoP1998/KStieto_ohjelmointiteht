<script setup>
  const submit = () => {
    
    console.log("Logged In!")
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
