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
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button class="btn btn-primary">{{trans.get('auth.registrate')}}</button>
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
        city: '',
        phone: '',
        password: '',
        password_confirmation: '',
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
            formData.append("representative_email", $('#representative_email').val());
            formData.append("city", this.city);
            formData.append("phone", this.phone);
            formData.append("password", this.password);
            formData.append("password_confirmation", this.password_confirmation);
            formData.append("role_id", '3');
            formData.append("adult_checkbox", null);

            axios
                .post(
                    `/profile/register`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                .then(function (response) {
                    // location.href = '/profile'
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
