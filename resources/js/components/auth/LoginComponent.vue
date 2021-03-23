<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <h4 class="h3 mb-3">Login!</h4>
                            <form
                                action
                                method="POST"
                                class="authentication-form"
                            >
                                <div class="form-group">
                                    <label class="form-control-label">
                                        Email Address
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i
                                                    class="icon-dual"
                                                    data-feather="mail"
                                                ></i>
                                            </span>
                                        </div>
                                        <input
                                            :class="[error ? 'is-invalid' : '']"
                                            class="form-control form-control-lg"
                                            type="email"
                                            id="email"
                                            name="email"
                                            value
                                            placeholder="ahmed@ahmedmostafa.com"
                                            v-model="form.email"
                                        />
                                        <span
                                            class="invalid-feedback"
                                            role="alert"
                                        >
                                            <strong>{{ error }}</strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <label class="form-control-label">
                                        Password
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <a
                                        href
                                        class="float-right text-muted text-unline-dashed ml-1"
                                    >
                                        <span>Forgot Your Password?</span>
                                    </a>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i
                                                    class="icon-dual"
                                                    data-feather="lock"
                                                ></i>
                                            </span>
                                        </div>
                                        <input
                                            type="password"
                                            class="form-control form-control-lg"
                                            id="password"
                                            name="password"
                                            placeholder="Enter your password"
                                            v-model="form.password"
                                        />
                                        <span
                                            class="invalid-feedback"
                                            role="alert"
                                        >
                                            <strong></strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            name="remember"
                                            id="checkbox-signin"
                                            v-model="form.remember"
                                        />

                                        <label
                                            class="custom-control-label"
                                            for="checkbox-signin"
                                            >Remember me</label
                                        >
                                    </div>
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button
                                        type="submit"
                                        :class="[
                                            !isValidaInputs() ? 'disabled' : ''
                                        ]"
                                        class="btn btn-primary btn-block"
                                        :disabled="!isValidaInputs()"
                                        @click.prevent="attemptLogin()"
                                    >
                                        Log In
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">
                            Don't have an account?
                            <a
                                href="/register"
                                class="text-primary font-weight-bold ml-1"
                            >
                                <span>Sign Up</span>
                            </a>
                        </p>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end col -->
        </div>
    </div>
</template>

<script>
import axios from "axios";
// import login from '../../Apis/auth/login.js';
export default {
    name: "LoginComponent",

    data() {
        return {
            form: {
                email: "",
                password: "",
                remember: false,
            },
            error: ""
        };
    },

    methods: {
        emailIsValid() {
            return /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(
                this.form.email
            )
                ? true
                : false;
        },

        isValidaInputs() {
            return this.emailIsValid() && this.form.password;
        },

        attemptLogin() {
            axios.post("/login", this.form)
                .then(response => {
                    console.log(response);
                    localStorage.setItem("access_token", response.data.access_token);
                    window.location.href = response.data.route
                })
                .catch(error => {
                    console.log(error.response);
                    this.error = error.response.data.response.msg;
                });
        }
    }
};
</script>

<style></style>
