<template>
    <div>
        <Header />
        <div class="dashboard-box">
            <h1>All Roles:</h1>
            <table>
                <thead>
                    <tr>
                        <th>Role Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="role in roles" :key="role.id">
                        <td>
                            <router-link
                                :to="`/roles/${role.id}`"
                                class="clickable-link"
                            >
                                {{ role.role_name }}
                            </router-link>
                        </td>
                        <td>{{ role.description || "—" }}</td>
                        <td>
                            <button class="edit-btn" @click="editRole(role.id)">
                                Edit
                            </button>
                            <button
                                class="delete-btn"
                                @click="deleteRole(role.id)"
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
        const roles = ref<any[]>([]);
        const error = ref("");
        const router = useRouter();

        const fetchRoles = async () => {
            try {
                const response = await api.get("/role/GetAll", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                });
                roles.value = response.data;
            } catch {
                error.value = "Failed to load roles.";
            }
        };

        const editRole = (id: number) => {
            router.push(`/roles/update/${id}`);
        };

        const deleteRole = async (id: number) => {
            if (confirm("Are you sure you want to delete this role?")) {
                try {
                    await api.delete(`/role/delete/${id}`, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    });
                    roles.value = roles.value.filter((r) => r.id !== id);
                } catch {
                    alert("Failed to delete role.");
                }
            }
        };

        onMounted(fetchRoles);

        return { roles, error, editRole, deleteRole };
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
