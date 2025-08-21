<template>
    <div>
        <Header />
        <div class="dashboard-box">
            <h1>
                <span class="highlight-name">{{ role?.role_name }}</span>
                Details
            </h1>
            <div v-if="role">
                <p><strong>Role Name:</strong> {{ role.role_name }}</p>
                <p>
                    <strong>Description:</strong> {{ role.description || "—" }}
                </p>
                <p><strong>Created At:</strong> {{ role.created_at }}</p>
                <p><strong>Updated At:</strong> {{ role.updated_at }}</p>
            </div>
            <p v-else-if="error" class="error-message">{{ error }}</p>
            <p v-else>Loading...</p>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import api from "../axios";
import Header from "../components/Header.vue";

export default defineComponent({
    components: { Header },
    setup() {
        const route = useRoute();
        const role = ref<any | null>(null);
        const error = ref("");

        const fetchRole = async () => {
            try {
                const id = route.params.id;
                const response = await api.get(`/role/read/${id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                });
                role.value = response.data;
            } catch (err) {
                console.error(err);
                error.value = "Failed to load role details.";
            }
        };

        onMounted(fetchRole);

        return { role, error };
    },
});
</script>

<style scoped>
.dashboard-box {
    margin-top: 80px;
    max-width: 700px;
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
p {
    margin: 10px 0;
    font-size: 1rem;
}
.error-message {
    color: red;
    margin-top: 20px;
}
.highlight-name {
    color: #13538e;
    font-weight: bold;
}
</style>
