<template>
  <div>
    <!-- ✅ Shared Header -->
    <Header />

    <div class="auth-container">
      <div class="auth-box">
        <h1>Create Role</h1>
        <form @submit.prevent="createRole">
          <input v-model="roleName" type="text" placeholder="Role Name" required />
          <textarea v-model="description" placeholder="Role Description"></textarea>
          <button type="submit">Save Role</button>
        </form>

        <p v-if="error" class="error-message">{{ error }}</p>
        <p v-if="success" class="success-message">{{ success }}</p>

        <!-- Back to Dashboard -->
        <p class="toggle-link" @click="goToDashboard">
          Back to Dashboard
        </p>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import api from "../axios";
import Header from "../components/Header.vue";

export default defineComponent({
  components: { Header },
  setup() {
    const roleName = ref("");
    const description = ref("");
    const error = ref("");
    const success = ref("");
    const router = useRouter();

    onMounted(() => {
      if (!localStorage.getItem("token")) {
        router.push("/");
      }
    });

    const createRole = async () => {
      if (roleName.value.trim() === "") {
        error.value = "Role name is required.";
        return;
      }

      try {
        await api.post(
          "/role/create",
          {
            role_name: roleName.value,
            description: description.value,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        );
        success.value = "Role created successfully!";
        error.value = "";
        roleName.value = "";
        description.value = "";

        setTimeout(() => {
          router.push("/roles");
        }, 1300);
      } catch (err: any) {
        error.value = err.response?.data?.message || "Failed to create role.";
        success.value = "";
      }
    };

    const goToDashboard = () => {
      router.push("/dashboard");
    };

    return { roleName, description, error, success, createRole, goToDashboard };
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

input,
textarea {
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

textarea {
  text-align: left;
  min-height: 80px;
  resize: none;
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

.success-message {
  color: green;
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
