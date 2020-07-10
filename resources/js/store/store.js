import Vue from "vue";
import Vuex from "vuex";
import brands from "./modules/brands";
import types from "./modules/types";
import colors from "./modules/colors";
import conditions from "./modules/conditions";
import origins from "./modules/origins";
import fuels from "./modules/fuels";
import transmissions from "./modules/transmissions";
import styles from "./modules/styles";
import convenients from "./modules/convenients";
import cars from "./modules/cars";
import users from "./modules/users";
import contacts from "./modules/contacts";
import roles from "./modules/roles";
import permissions from "./modules/permissions";
import employees from "./modules/employees";
import report from "./modules/report";

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        brands,
        types,
        colors,
        conditions,
        origins,
        fuels,
        transmissions,
        styles,
        convenients,
        cars,
        users,
        contacts,
        roles,
        permissions,
        employees,
        report
    },
    state: {
        csrf: document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        auth: {}
    },
    getters: {
        csrf(state) {
            return state.csrf;
        },
        auth(state) {
            return state.auth;
        }
    },
    mutations: {
        auth(state, data) {
            state.auth = data;
        }
    },
    actions: {
        auth({ commit }) {
            $.ajax({
                url: "/admin/api/auth",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    commit("auth", data);
                },
                error: function(errors) {
                    console.log(errors);
                }
            });
        }
    }
});
