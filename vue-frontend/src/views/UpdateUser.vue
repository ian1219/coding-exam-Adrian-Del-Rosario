<template>
  <div>
    <Header />

    <div class="update-container">
      <div class="update-box">
        <h1>Update User</h1>
        <form @submit.prevent="updateUser">
          <!-- ✅ Existing data will show here -->
          <input v-model="user.full_name" type="text" placeholder="Full Name" required />
          <input v-model="user.email" type="email" placeholder="Email" required />
          <input v-model="user.password" type="password" placeholder="Password (optional)" />
          <input v-model="user.password_confirmation" type="password" placeholder="Confirm Password" />

          <button type="submit">Update</button>
        </form>

        <p v-if="message">{{ message }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Header from "@/components/Header.vue";

export default {
  name: "UpdateUser",
  components: { Header },
  data() {
    return {
      user: {
        full_name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      message: "",
    };
  },
  async mounted() {
    const userId = this.$route.params.id;
    try {
      // ✅ Correct API route: /user/read/{id}
      const response = await axios.get(`http://127.0.0.1:8000/api/user/read/${userId}`, {
        headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
      });

      // ✅ Fill form with existing data
      this.user.full_name = response.data.full_name;
      this.user.email = response.data.email;

      // Leave password fields empty
      this.user.password = "";
      this.user.password_confirmation = "";
    } catch (error) {
      console.error("Error fetching user:", error.response?.data || error.message);
      this.message = "Failed to load user data.";
    }
  },
methods: {
  async updateUser() {
    try {
      const userId = this.$route.params.id;

      // ✅ Build payload for backend
      const payload = {
        full_name: this.user.full_name,
        email: this.user.email,
      };

      // Only include password if filled
      if (this.user.password) {
        payload.password = this.user.password;
        payload.password_confirmation = this.user.password_confirmation;
      }

      await axios.put(
        `http://127.0.0.1:8000/api/user/edit/${userId}`,
        payload,
        { headers: { Authorization: `Bearer ${localStorage.getItem("token")}` } }
      );

      this.message = "User updated successfully!";
      setTimeout(() => this.$router.push("/users"), 1200);
    } catch (error) {
      console.error("Error updating user:", error.response?.data || error.message);
      this.message = error.response?.data?.message || "Failed to update user.";
    }
  },
  },
};
</script>

<style scoped>
.update-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f0f2f5;
}

.update-box {
  background-color: #fff;
  padding: 40px;
  border-radius: 10px;
  width: 100%;
  max-width: 400px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  text-align: center;
  margin-top: 80px;
}

input,
select {
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

.message {
  color: green;
  margin-top: 20px;
}
</style>
