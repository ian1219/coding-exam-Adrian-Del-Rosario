<template>
    <div>
        <Header />
        <div class="dashboard-box">
            <h1>
                <span class="highlight-name">{{ user?.full_name }}</span>
                Details
            </h1>

            <div v-if="user">
                <p><strong>Full Name:</strong> {{ user.full_name }}</p>
                <p><strong>Email:</strong> {{ user.email }}</p>
                <p><strong>Role:</strong> {{ user.role?.role_name || "—" }}</p>
                <p>
                    <strong>Description:</strong>
                    {{ user.role?.description || "—" }}
                </p>
                <p><strong>Created At:</strong> {{ user.created_at }}</p>
                <p><strong>Updated At:</strong> {{ user.updated_at }}</p>
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
        const user = ref<any | null>(null);
        const error = ref("");

        const fetchUser = async () => {
            try {
                const id = route.params.id;
                const response = await api.get(`/user/read/${id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                });
                user.value = response.data;
            } catch (err) {
                console.error(err);
                error.value = "Failed to load user details.";
            }
        };

        onMounted(fetchUser);

        return { user, error };
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
