<template>
    <div>
        <Header />
        <div class="dashboard-box">
            <h1>All Users:</h1>
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>
                            <router-link
                                :to="`/users/${user.id}`"
                                class="clickable-link"
                            >
                                {{ user.full_name }}
                            </router-link>
                        </td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role?.role_name || "—" }}</td>
                        <td>
                            <button class="edit-btn" @click="editUser(user.id)">
                                Edit
                            </button>
                            <button
                                class="delete-btn"
                                @click="deleteUser(user.id)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-if="error" class="error-message">{{ error }}</p>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import api from "../axios";
import Header from "../components/Header.vue";
import { useRouter } from "vue-router";

export default defineComponent({
    components: { Header },
    setup() {
        const users = ref<any[]>([]);
        const error = ref("");
        const router = useRouter();

        const fetchUsers = async () => {
            try {
                const response = await api.get("/user/GetAll", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                });
                users.value = response.data;
            } catch {
                error.value = "Failed to load users.";
            }
        };

        const editUser = (id: number) => {
            router.push(`/users/update/${id}`);
        };

        const deleteUser = async (id: number) => {
            if (confirm("Are you sure you want to delete this user?")) {
                try {
                    await api.delete(`/user/delete/${id}`, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    });
                    users.value = users.value.filter((u) => u.id !== id);
                } catch {
                    alert("Failed to delete user.");
                }
            }
        };

        onMounted(fetchUsers);

        return { users, error, editUser, deleteUser };
    },
});
</script>

<style scoped>
.dashboard-box {
    margin-top: 80px;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    margin-bottom: 20px;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th,
td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: center;
}

th {
    background: #5294d1;
    color: white;
}

tr:nth-child(even) {
    background: #f9f9f9;
}

.clickable-link {
    color: #13538e;
    text-decoration: none;
    font-weight: bold;
    cursor: pointer;
}

.clickable-link:hover {
    text-decoration: underline;
}

/* Action buttons */
.edit-btn {
    background: #ffc107;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    color: #fff;
    margin-right: 5px;
}

.edit-btn:hover {
    background: #e0a800;
}

.delete-btn {
    background: #dc3545;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    color: #fff;
}

.delete-btn:hover {
    background: #c82333;
}
</style>
