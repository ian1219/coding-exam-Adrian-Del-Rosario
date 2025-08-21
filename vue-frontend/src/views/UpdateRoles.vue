<template>
  <div>
    <!-- ✅ Shared Header -->
    <Header />

    <div class="auth-container">
      <div class="auth-box">
        <h1>Update Role</h1>
        <form @submit.prevent="updateRole">
          <input v-model="role.role_name" type="text" placeholder="Role Name" required />
          <textarea v-model="role.description" placeholder="Role Description"></textarea>
          <button type="submit">Update Role</button>
        </form>

        <p v-if="error" class="error-message">{{ error }}</p>
        <p v-if="success" class="success-message">{{ success }}</p>

      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import api from "../axios";
import Header from "../components/Header.vue";

export default {
  name: "UpdateRoles",
  components: { Header },
  setup() {
    const role = ref({ role_name: "", description: "" });
    const error = ref("");
    const success = ref("");
    const router = useRouter();
    const route = useRoute();

    const fetchRole = async () => {
      try {
        const { data } = await api.get(`/role/read/${route.params.id}`, {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        });
        role.value = data;
      } catch (err) {
        error.value = "Failed to load role details.";
      }
    };

    const updateRole = async () => {
      if (role.value.role_name.trim() === "") {
        error.value = "Role name is required.";
        return;
      }

      try {
        await api.put(`/role/edit/${route.params.id}`, role.value, {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        });
        success.value = "Role updated successfully!";
        error.value = "";

        setTimeout(() => {
          router.push("/roles");
        }, 1000);
      } catch (err) {
        error.value = err.response?.data?.message || "Failed to update role.";
        success.value = "";
      }
    };

    onMounted(() => {
      if (!localStorage.getItem("token")) {
        router.push("/");
      } else {
        fetchRole();
      }
    });

    return { role, error, success, updateRole };
  },
};
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
