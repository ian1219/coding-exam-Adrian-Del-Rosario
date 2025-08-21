<template>
    <div>
        <!-- ✅ Shared Header -->
        <Header />

        <div class="create-container">
            <div class="create-box">
                <h1>Create User</h1>
                <form @submit.prevent="createUser">
                    <input
                        v-model="fullName"
                        type="text"
                        placeholder="Full Name"
                        required
                    />
                    <input
                        v-model="email"
                        type="email"
                        placeholder="Email"
                        required
                    />
                    <input
                        v-model="password"
                        type="password"
                        placeholder="Password"
                        required
                    />
                    <input
                        v-model="passwordConfirmation"
                        type="password"
                        placeholder="Confirm Password"
                        required
                    />

                    <!-- Show all active roles -->
                    <select v-model="roleId" required>
                        <option value="" disabled>Select a role</option>
                        <option
                            v-for="role in roles"
                            :key="role.id"
                            :value="role.id"
                        >
                            {{ role.role_name }}
                        </option>
                    </select>

                    <button type="submit">Create</button>
                </form>

                <p v-if="message" class="message">{{ message }}</p>
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
import axios from "axios";
import { useRouter } from "vue-router";
import Header from "../components/Header.vue"; // ✅ import header

export default defineComponent({
    components: { Header },
    setup() {
        const fullName = ref("");
        const email = ref("");
        const password = ref("");
        const passwordConfirmation = ref("");
        const roleId = ref("");
        const roles = ref<any[]>([]);
        const message = ref("");
        const router = useRouter();

        // Ensure user is logged in
        onMounted(() => {
            if (!localStorage.getItem("token")) {
                router.push("/"); // redirect to login if not authenticated
            } else {
                fetchRoles();
            }
        });

        // Fetch active roles
        const fetchRoles = async () => {
            try {
                const res = await axios.get("http://127.0.0.1:8000/api/roles", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                });
                roles.value = res.data;
            } catch (error) {
                console.error("Error fetching roles", error);
                message.value = "Failed to load roles";
            }
        };

        // Create user
        const createUser = async () => {
            if (!roleId.value) {
                message.value = "Please select a role";
                return;
            }

            try {
                await axios.post(
                    "http://127.0.0.1:8000/api/user/register",
                    {
                        full_name: fullName.value,
                        email: email.value,
                        password: password.value,
                        password_confirmation: passwordConfirmation.value,
                        role_id: roleId.value,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    }
                );

                message.value = "User created successfully!";
                setTimeout(() => {
                    router.push("/users"); // go back to user list
                }, 1300);

                // reset fields
                fullName.value = "";
                email.value = "";
                password.value = "";
                passwordConfirmation.value = "";
                roleId.value = "";
            } catch (error: any) {
                message.value =
                    error.response?.data?.message || "Error creating user";
            }
        };

        const goToDashboard = () => {
            router.push("/dashboard");
        };

        return {
            fullName,
            email,
            password,
            passwordConfirmation,
            roleId,
            roles,
            message,
            createUser,
            goToDashboard,
        };
    },
});
</script>

<style scoped>
.create-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f0f2f5;
}

.create-box {
    background-color: #fff;
    padding: 40px;
    border-radius: 10px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    text-align: center;
    margin-top: 80px; /* ✅ space below header */
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

.back-link {
    color: #13538e;
    cursor: pointer;
    margin-top: 20px;
}

.back-link:hover {
    text-decoration: underline;
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
