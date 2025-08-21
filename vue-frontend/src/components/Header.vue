<template>
  <header class="dashboard-header">
    <div class="logo">
      <a href="#" @click.prevent="goHome">Home</a>
    </div>
    <nav class="nav-links">
      <a href="#" @click.prevent="goUsers">Users</a>
      <a href="#" @click.prevent="goRoles">Roles</a>
    </nav>
    <button @click="logout" class="logout-button">Logout</button>
  </header>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { useRouter } from "vue-router";

export default defineComponent({
  setup() {
    const router = useRouter();

    const goHome = () => router.push("/dashboard");
    const goUsers = () => router.push("/users");
    const goRoles = () => router.push("/roles");

    const logout = () => {
      localStorage.removeItem("token");
      localStorage.removeItem("full_name");
      router.push("/");
    };

    return { goHome, goUsers, goRoles, logout };
  },
});
</script>

<style scoped>
.dashboard-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #5294d1;
  color: white;
  padding: 10px 20px;
  z-index: 10;
}

.dashboard-header .logo a {
  color: white;
  text-decoration: none;
  font-size: 1.4rem;
  font-weight: bold;
}

.nav-links {
  display: flex;
  gap: 20px;
}

.nav-links a {
  color: white;
  text-decoration: none;
  font-size: 1.1rem;
  cursor: pointer;
}

.nav-links a:hover {
  text-decoration: underline;
}

.logout-button {
  padding: 10px 15px;
  background-color: #f44336;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 1.1rem;
  cursor: pointer;
}

.logout-button:hover {
  background-color: #d32f2f;
}
</style>
