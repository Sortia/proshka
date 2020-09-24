<template>
    <form v-on:submit.prevent="register">
        <div class="registration">
            <div class="form-group row required">

                <label for="name" class="col-md-4 col-form-label text-md-right">{{trans.get('auth.name')}}</label>
                <div class="col-md-6">
                    <input id="name" type="text" required class="form-control"
                           v-bind:class="[errors.name ? 'is-invalid' : '', '']"
                           v-model="name" autocomplete="name"
                           autofocus>
                    <span v-for="(error) in errors.name" v-if="errors.name" class="invalid-feedback" role="alert">
                        <strong>{{ error }}</strong>
                    </span>
                </div>
            </div>
            <div class="form-group row required">
                <label for="surname" class="col-md-4 col-form-label text-md-right">{{trans.get('auth.surname')}}</label>
                <div class="col-md-6">
                    <input id="surname" type="text" required class="form-control"
                           v-bind:class="[errors.surname ? 'is-invalid' : '', '']"
                           v-model="surname" autocomplete="surname"
                           autofocus>
                    <span v-for="(error) in errors.surname" v-if="errors.surname" class="invalid-feedback" role="alert">
                        <strong>{{ error }}</strong>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label for="nickname" class="col-md-4 col-form-label text-md-right">{{trans.get('auth.nickname')}}</label>
                <div class="col-md-6">
                    <input id="nickname" type="text"     class="form-control"
                           v-bind:class="[errors.nickname ? 'is-invalid' : '', '']"
                           v-model="nickname" autocomplete="nickname"
                           autofocus>
                    <span v-for="(error) in errors.nickname" v-if="errors.nickname" class="invalid-feedback" role="alert">
                        <strong>{{ error }}</strong>
                    </span>
                </div>
            </div>
            <div class="form-group row required">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{trans.get('auth.email')}}</label>
                <div class="col-md-6">
                    <input id="email" type="email" required class="form-control"
                           v-bind:class="[errors.email ? 'is-invalid' : '', '']"
                           v-model="email" autocomplete="email"
                           autofocus>
                    <span v-for="(error) in errors.email" v-if="errors.email" class="invalid-feedback" role="alert">
                        <strong>{{ error }}</strong>
                    </span>
                </div>
            </div>
            <div class="form-group row required">
                <label for="role_id"
                       class="col-md-4 col-form-label text-md-right">{{trans.get('auth.user_type')}}</label>

                <div class="col-md-6">
                    <select class="custom-select" v-model="role_id" v-bind:class="[errors.role_id ? 'is-invalid' : '', '']" id="role_id">
                        <option value="3">{{trans.get('auth.student')}}</option>
                        <option value="4">{{trans.get('auth.representative')}}</option>
                    </select>

                    <span v-for="(error) in errors.role_id" v-if="errors.role_id" class="invalid-feedback" role="alert">
                        <strong>{{ error }}</strong>
                    </span>
                </div>
            </div>
            <div v-if="role_id === '3'" class="d-flex justify-content-center bd-highlight mb-3">
                <div class="p-2 bd-highlight">
                    <div class="custom-control custom-checkbox align-content-center">
                        <input name="adult_checkbox" value="1" v-model="adult_checkbox"
                        type="checkbox" class="custom-control-input" id="adult_checkbox">
                        <label class="custom-control-label" for="adult_checkbox">{{trans.get('auth.is_adult')}}</label>
                    </div>
                </div>
            </div>
            <div class="form-group row required" v-if="role_id === '3' && !adult_checkbox">
                <label for="representative_email" class="col-md-4 col-form-label text-md-right">{{trans.get('auth.representative_email')}}</label>
                <div class="col-md-6">
                    <input id="representative_email" type="email" required class="form-control"
                           v-bind:class="[errors.representative_email ? 'is-invalid' : '', '']"
                           v-model="representative_email" autocomplete="representative_email"
                           autofocus>
                    <span v-for="(error) in errors.representative_email" v-if="errors.representative_email" class="invalid-feedback" role="alert">
                        <strong>{{ error }}</strong>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label for="city" class="col-md-4 col-form-label text-md-right">{{trans.get('auth.city')}}</label>
                <div class="col-md-6">
                    <input id="city" type="text" class="form-control"
                           v-bind:class="[errors.city ? 'is-invalid' : '', '']"
                           v-model="city" autocomplete="city"
                           autofocus>
                    <span v-for="(error) in errors.city" v-if="errors.city" class="invalid-feedback" role="alert">
                        <strong>{{ error }}</strong>
                    </span>
                </div>
            </div>
            <div class="form-group row required">
                <label for="phone" class="col-md-4 col-form-label text-md-right">{{trans.get('auth.phone')}}</label>
                <div class="col-md-6">
                    <the-mask id="phone" type="text" required class="form-control"
                              :mask="['+7(###) ###-##-##']"
                              v-bind:class="[errors.phone ? 'is-invalid' : '', '']"
                              v-model="phone" autocomplete="phone"/>
                    <span v-for="(error) in errors.phone" v-if="errors.phone" class="invalid-feedback" role="alert">
                        <strong>{{ error }}</strong>
                    </span>
                </div>
            </div>
<!--            <div class="form-group row">-->
<!--                <label for="avatar"-->
<!--                       class="col-md-4 col-form-label text-md-right">{{trans.get('auth.avatar')}}</label>-->

<!--                <div class="col-md-6">-->
<!--                    <div class="custom-file">-->
<!--                        <input name="avatar" type="file"-->
<!--                               @change="updateLabel"-->
<!--                               class="custom-file-input"-->
<!--                               v-bind:class="[errors.avatar ? 'is-invalid' : '', '']"-->
<!--                               id="avatar">-->
<!--                        <label class="custom-file-label" for="avatar" v-html="file_name"></label>-->
<!--                        <span v-for="(error) in errors.avatar" v-if="errors.avatar" class="invalid-feedback" role="alert">-->
<!--                        <strong>{{ error }}</strong>-->
<!--                    </span>-->
<!--                    </div>-->

<!--                </div>-->
<!--            </div>-->
            <div class="form-group row required">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{trans.get('auth.password')}}</label>
                <div class="col-md-6">
                    <input id="password" type="password" required class="form-control"
                           v-bind:class="[errors.password ? 'is-invalid' : '', '']"
                           v-model="password" autocomplete="password"
                           autofocus>
                    <span v-for="(error) in errors.password" v-if="errors.password" class="invalid-feedback" role="alert">
                        <strong>{{ error }}</strong>
                    </span>
                </div>
            </div>
            <div class="form-group row required">
                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{trans.get('auth.confirm_password')}}</label>
                <div class="col-md-6">
                    <input id="password_confirmation" type="password" required class="form-control"
                           v-bind:class="[errors.password_confirmation ? 'is-invalid' : '', '']"
                           v-model="password_confirmation" autocomplete="password_confirmation"
                           autofocus>
                    <span v-for="(error) in errors.password_confirmation" v-if="errors.password_confirmation" class="invalid-feedback" role="alert">
                        <strong>{{ error }}</strong>
                    </span>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button class="btn btn-primary">{{trans.get('auth.register')}}</button>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import {TheMask} from 'vue-the-mask'

export default {
    components: {TheMask},
    data: () => ({
        errors: {},
        name: '',
        surname: '',
        nickname: '',
        email: '',
        representative_email: '',
        city: '',
        phone: '',
        password: '',
        password_confirmation: '',
        role_id: '3',
        adult_checkbox: '',
        // avatar: '',
        file_name: '',
    }),
    name: "registration",
    mounted() {
        this.file_name = Vue.prototype.trans.get('__JSON__.Choose file');
    },
    methods: {
        updateLabel(event) {
            this.file_name = event.target.files[0].name;
        },
        register() {

            let formData = new FormData();

            // let avatar = document.querySelector('#avatar');
            //
            // if (avatar.files[0]) {
            //     formData.append("avatar", avatar.files[0]);
            // }

            formData.append("name", this.name);
            formData.append("surname", this.surname);
            formData.append("nickname", this.nickname);
            formData.append("email", this.email);
            formData.append("representative_email", this.representative_email);
            formData.append("city", this.city);
            formData.append("phone", this.phone);
            formData.append("password", this.password);
            formData.append("password_confirmation", this.password_confirmation);
            formData.append("role_id", this.role_id);
            formData.append("adult_checkbox", this.adult_checkbox);

            axios
                .post(
                    `register`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                .then(function (response) {
                    location.href = '/email/verify'
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    console.log(this.errors.name);
                });

        }
    }
}
</script>

<style scoped>

</style>
