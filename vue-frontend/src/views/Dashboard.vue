<template>
  <div class="dashboard-container">
    <Header />

    <div class="dashboard-box" v-if="!$route.meta.childPage">
      <h1>Welcome, {{ fullName }}!</h1>
      <p>You are successfully logged in.</p>

      <div class="button-group">
        <!-- Create User Button -->
        <button @click="goToCreateUser">Create User</button>

        <!-- Create Role Button -->
        <button @click="goToCreateRole">Create Role</button>
      </div>
    </div>

    <router-view />
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Header from '@/components/Header.vue';

export default defineComponent({
  components: { Header },
  setup() {
    const router = useRouter();
    const fullName = localStorage.getItem('full_name') || '';

    onMounted(() => {
      if (!localStorage.getItem('token')) {
        router.push('/');
      }
    });

    const goToCreateUser = () => {
      router.push('/create-user');
    };

    const goToCreateRole = () => {
      router.push('/register-role');
    };

    return { fullName, goToCreateUser, goToCreateRole };
  },
});
</script>

<style scoped>
.dashboard-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background-color: #f0f2f5;
}

.dashboard-box {
  background-color: #ffffff;
  padding: 40px;
  border-radius: 8px;
  width: 100%;
  max-width: 500px;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  margin: 100px auto 20px; /* Top margin so it doesn’t hide behind fixed header */
}

h1 {
  color: #333;
  font-size: 2rem;
  font-weight: 600;
  margin-bottom: 20px;
}

p {
  color: #555;
  font-size: 1.2rem;
  margin-bottom: 30px;
}

/* ✅ Added margin between buttons */
.button-group {
  display: flex;
  flex-direction: column;
  gap: 15px; /* space between buttons */
}

button {
  padding: 12px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 1.1rem;
  cursor: pointer;
  width: 100%;
}

button:hover {
  background-color: #45a049;
}
</style>
