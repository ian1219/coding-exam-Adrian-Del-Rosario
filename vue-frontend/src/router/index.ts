import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import Users from "../views/UserList.vue";
import Roles from "../views/RolesList.vue";
import RegisterRole from "../views/RegisterRole.vue";
import RegisterUser from "../views/RegisterUser.vue";
import UserDetail from "../views/UserDetail.vue";
import RoleDetail from "../views/RoleDetail.vue";
import CreateUser from "../views/CreateUser.vue";
import UpdateUser from "../views/UpdateUser.vue";
import UpdateRoles from "../views/UpdateRoles.vue";

const routes = [
    { path: "/", component: Login },
    { path: "/dashboard", component: Dashboard, meta: { requiresAuth: true } },
    { path: "/roles", component: Roles, meta: { requiresAuth: true } },
    { path: "/roles/:id", component: RoleDetail, meta: { requiresAuth: true } },
    { path: "/roles/update/:id", component: UpdateRoles, meta: { requiresAuth: true } },
    { path: "/users", component: Users, meta: { requiresAuth: true } },
    { path: "/users/:id", component: UserDetail, meta: { requiresAuth: true } },
    { path: "/users/update/:id", component: UpdateUser, meta: { requiresAuth: true } },
    { path: "/register-role", component: RegisterRole, meta: { requiresAuth: true } },
    { path: "/create-user", component: CreateUser, meta: { requiresAuth: true } },
    { path: "/register-user", component: RegisterUser },
    { path: "/:pathMatch(.*)*", redirect: "/dashboard" },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
