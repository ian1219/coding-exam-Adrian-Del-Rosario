<template>
  <div class="auth-container">
    <div class="auth-box">
      <h1>Login</h1>
      <form @submit.prevent="login">
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Password" required />
        <button type="submit">Login</button>
      </form>
      <p v-if="error" class="error-message">{{ error }}</p>

      <!-- Navigate to RegisterUser.vue -->
      <p class="toggle-link" @click="goToRegister">
        Don't have an account? Sign Up
      </p>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import api from '../axios';

export default defineComponent({
  setup() {
    const email = ref('');
    const password = ref('');
    const error = ref('');
    const router = useRouter();

    // Redirect if already logged in
    onMounted(() => {
      if (localStorage.getItem('token')) {
        router.push('/dashboard');
      }
    });

    const login = async () => {
      if (password.value.length < 8) {
        error.value = 'The password must be at least 8 characters.';
        return;
      }
      try {
        const response = await api.post('/login', {
          email: email.value,
          password: password.value,
        });
        localStorage.setItem('token', response.data.data.token);
        localStorage.setItem('full_name', response.data.data.full_name);
        router.push('/dashboard');
      } catch (err: any) {
        error.value = err.response?.data?.message || 'Login failed';
      }
    };

    const goToRegister = () => {
      router.push('/register-user');
    };

    return { email, password, error, login, goToRegister };
  },
});

</script>

<style scoped>
.auth-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f0f2f5;
}

.auth-box {
  background-color: #ffffff;
  padding: 40px;
  border-radius: 10px;
  width: 100%;
  max-width: 400px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  text-align: center;
}

input {
  width: 92%;
  padding: 14px;
  margin-bottom: 18px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
  text-align: center;
  color: #333;
  background-color: #f9f9f9;
}

button {
  width: 100%;
  padding: 14px;
  background-color: #5b9bd5;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 1rem;
  cursor: pointer;
}

.error-message {
  color: red;
  margin-top: 20px;
}

.toggle-link {
  color: #13538e;
  cursor: pointer;
  margin-top: 20px;
}

.toggle-link:hover {
  text-decoration: underline;
}
</style>
